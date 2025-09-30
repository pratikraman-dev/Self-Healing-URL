<?php

namespace Bala\SelfHealingUrl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Controller;

class SelfHealingController extends Controller
{
    public function __invoke(Request $request)
    {
        $path = '/' . trim(strtolower($request->path()), '/');

        $staticDistance = config('selfhealing.static_distance', 3);
        $paramDistance = config('selfhealing.param_distance', 2);

        $allRoutes = collect(Route::getRoutes())
            ->filter(fn($r) => in_array('GET', $r->methods()));

        $staticRoutes = $allRoutes->filter(fn($r) => !str_contains($r->uri(), '{'))
            ->map(fn($r) => '/' . trim($r->uri(), '/'))
            ->toArray();

        // --- Fuzzy match static routes ---
        $best = null;
        $bestScore = PHP_INT_MAX;
        foreach ($staticRoutes as $uri) {
            $dist = levenshtein($path, $uri);
            if ($dist < $bestScore) {
                $bestScore = $dist;
                $best = $uri;
            }
        }

        if ($best && $bestScore <= $staticDistance) {
            return redirect($best, 301);
        }

        // --- Parameterized routes ---
        $paramRoutes = $allRoutes->filter(fn($r) => str_contains($r->uri(), '{'));
        foreach ($paramRoutes as $route) {
            $pattern = $route->uri();
            $regex = preg_replace('/\{[^}]+\}/', '[^/]+', $pattern);
            $regex = '#^/' . trim($regex, '/') . '$#i';

            if (preg_match($regex, $path)) {
                $givenSegments = explode('/', trim($path, '/'));
                $patternSegments = explode('/', trim($pattern, '/'));

                $score = 0;
                foreach ($patternSegments as $i => $seg) {
                    if (!str_contains($seg, '{')) {
                        $score += levenshtein(strtolower($givenSegments[$i] ?? ''), strtolower($seg));
                    }
                }

                if ($score <= $paramDistance) {
                    $redirectPath = '/' . implode('/', $givenSegments);
                    return redirect($redirectPath, 301);
                }
            }
        }

        return response()->view('errors.404', [], 404);
    }
}

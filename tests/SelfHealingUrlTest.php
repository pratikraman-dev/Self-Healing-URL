<?php

namespace Bala\SelfHealingUrl\Tests;

use Orchestra\Testbench\TestCase;
use Bala\SelfHealingUrl\SelfHealingUrlServiceProvider;

class SelfHealingUrlTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [SelfHealingUrlServiceProvider::class];
    }

    /** @test */
    public function it_redirects_static_url_with_typo()
    {
        $this->app['router']->get('/about-us', fn() => 'About Us');
        $response = $this->get('/abut-us');
        $response->assertRedirect('/about-us');
    }

    /** @test */
    public function it_redirects_parameterized_url()
    {
        $this->app['router']->get('/products/{id}', fn($id) => "Product $id");
        $response = $this->get('/produts/123');
        $response->assertRedirect('/produts/123'); // fixes typo
    }
}

<?php

use Illuminate\Support\Facades\Route;
use Bala\SelfHealingUrl\Http\Controllers\SelfHealingController;

Route::fallback(SelfHealingController::class);

<?php

use App\Http\Controllers\LighthouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/lighthouse', [LighthouseController::class, 'testPerformance']);

<?php

use App\Http\Controllers\CategoryManifestController;
use Illuminate\Support\Facades\Route;

Route::get('categories/', CategoryManifestController::class)->middleware('throttle:60,1');

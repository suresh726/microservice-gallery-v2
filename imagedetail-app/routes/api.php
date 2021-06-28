<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageDetailController;

Route::get('/test', [ImageDetailController::class, 'testAction']);
Route::get('/image-detail/{image_id}', [ImageDetailController::class, 'detailImage']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageListController;


Route::get('/test', [ImageListController::class, 'testAction']);
Route::get('/image-list/{category_id}', [ImageListController::class, 'listImages']);
Route::get('/category/{category_id}', [ImageListController::class, 'getCategory']);
Route::get('/category-by-image-id/{image_id}', [ImageListController::class, 'getCategoryByImage']);

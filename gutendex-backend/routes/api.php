<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/books/{id}/related', [BookController::class, 'related']);

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/search', [SearchController::class, 'index']);




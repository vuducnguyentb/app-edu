<?php

use App\Http\Livewire\Admin\HomeComponent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'admin', 'as' => 'v1.'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/dashboard', HomeComponent::class);
    #danh mục
    Route::get('/category', \App\Http\Livewire\Admin\AdminCategoryComponent::class);
    Route::get('/add-category', \App\Http\Livewire\Admin\AdminAddCategoryComponent::class)->name('admin-add-category');
});



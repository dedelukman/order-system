<?php

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

Route::redirect('/', 'dashboard');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/customer/branch', \App\Http\Livewire\ShowBranch::class)->name('branch');
Route::get('/customer/user', \App\Http\Livewire\ShowUser::class)->name('user');
Route::get('/product/category', \App\Http\Livewire\ShowCategory::class)->name('category');
Route::get('/product/detail', \App\Http\Livewire\ShowCategory::class)->name('product');
Route::get('/order/list', \App\Http\Livewire\ShowCategory::class)->name('list.order');

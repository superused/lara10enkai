<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/admin');
});

//Auth::routes();

Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//user
Route::get('/admin/user', [App\Http\Controllers\UserController::class,'index'])->name('admin.user.index');
Route::get('/admin/user/edit', [App\Http\Controllers\UserController::class,'edit'])->name('admin.user.edit');
Route::put('/admin/user', [App\Http\Controllers\UserController::class,'update'])->name('admin.user.update');
Route::get('/admin/user/edit/password', [App\Http\Controllers\UserController::class,'editPassword'])->name('admin.user.edit.password');
Route::put('/admin/user/edit', [App\Http\Controllers\UserController::class,'updatePassword'])->name('admin.user.update.password');

//login
Route::get('/admin/login', [App\Http\Controllers\Auth\LoginController::class,'showLoginForm'])->name('login');
Route::post('/admin/login', [App\Http\Controllers\Auth\LoginController::class,'login'])->name('login');
Route::get('/admin/logout', [App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');
Route::post('/admin/logout', [App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');

//register
Route::get('/admin/register', [App\Http\Controllers\Auth\RegisterController::class,'showRegistrationForm'])->name('register');
Route::post('/admin/register', [App\Http\Controllers\Auth\RegisterController::class,'register']);

//forgot
Route::get('/admin/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
Route::get('/admin/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::post('/admin/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::get('/admin/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class,'reset'])->name('password.update');

//event
Route::get('/admin/event', [App\Http\Controllers\EventController::class,'index'])->name('admin.event.index');
Route::get('/admin/event/create', [App\Http\Controllers\EventController::class,'create'])->name('admin.event.create');
Route::post('/admin/event', [App\Http\Controllers\EventController::class,'store'])->name('admin.event.store');
Route::get('/admin/event/{id}/edit', [App\Http\Controllers\EventController::class,'edit'])->name('admin.event.edit');
Route::put('/admin/event/{id}', [App\Http\Controllers\EventController::class,'update'])->name('admin.event.update');
Route::get('/admin/event/{id}/delete', [App\Http\Controllers\EventController::class,'delete'])->name('admin.event.delete');

//category
Route::get('/admin/category', [App\Http\Controllers\CategoryController::class,'index'])->name('admin.category.index');
Route::get('/admin/category/create', [App\Http\Controllers\CategoryController::class,'create'])->name('admin.category.create');
Route::post('/admin/category', [App\Http\Controllers\CategoryController::class,'store'])->name('admin.category.store');
Route::get('/admin/category/{id}/edit', [App\Http\Controllers\CategoryController::class,'edit'])->name('admin.category.edit');
Route::put('/admin/category/{id}/update', [App\Http\Controllers\CategoryController::class,'update'])->name('admin.category.update');
Route::get('/admin/category/{id}/delete', [App\Http\Controllers\CategoryController::class,'delete'])->name('admin.category.delete');
// Route::post('/admin/category/{id}/delete', [App\Http\Controllers\CategoryController::class,'delete'])->name('admin.category.delete');

// //order
// Route::get('/admin/order', [App\Http\Controllers\OrderController::class,'index'])->name('admin.order.index');
// Route::get('/admin/order/create', [App\Http\Controllers\OrderController::class,'create'])->name('admin.order.create');
// Route::post('/admin/order', [App\Http\Controllers\OrderController::class,'store'])->name('admin.order.store');
// Route::get('/admin/order/{id}/show', [App\Http\Controllers\OrderController::class,'show'])->name('admin.order.show');
// Route::get('/admin/order/{id}/edit', [App\Http\Controllers\OrderController::class,'edit'])->name('admin.order.edit');
// Route::put('/admin/order/{id}', [App\Http\Controllers\OrderController::class,'update'])->name('admin.order.update');

// //orderdetail
// Route::get('/admin/order_detail/{id}/create', [App\Http\Controllers\OrderDetailController::class,'create'])->name('admin.order_detail.create');
// Route::post('/admin/order_detail', [App\Http\Controllers\OrderDetailController::class,'store'])->name('admin.order_detail.store');
// Route::get('/admin/order_detail/{id}/edit', [App\Http\Controllers\OrderDetailController::class,'edit'])->name('admin.order_detail.edit');
// Route::post('/admin/order_detail/{id}', [App\Http\Controllers\OrderDetailController::class,'update'])->name('admin.order_detail.update');
// Route::put('/admin/order_detail/{id}', [App\Http\Controllers\OrderDetailController::class,'update'])->name('admin.order_detail.update');

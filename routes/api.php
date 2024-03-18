<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\DateController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SlotController;
use App\Http\Controllers\Api\TimeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ReservationController;

Route::get('addresses',         [AddressController::class, 'index'])->name('api.addresses.index');
Route::get('projects',          [ProjectController::class, 'index'])->name('api.projects.index');
Route::get('categories',        [CategoryController::class, 'index'])->name('api.categories.index');
Route::get('setting',           [SettingController::class, 'index'])->name('api.setting.index');
Route::get('post',              [PostController::class, 'index'])->name('api.post.index');
Route::get('tag',               [TagController::class, 'index'])->name('api.tag.index');
Route::post('reservations',     [ReservationController::class, 'store'])->name('api.reservations.store');
Route::post('orders',           [OrderController::class, 'store'])->name('api.orders.store');
Route::get('dates',             [DateController::class, 'index'])->name('api.dates.index');
//wcf =  where it come from e puo essere 0 (se viene da p-tavoli), 1 (se viene da p-asporto), 2 (se viene da p-domicilio),
Route::get('dates/findDate',    [DateController::class, 'findDate'])->name('api.dates.findDate');

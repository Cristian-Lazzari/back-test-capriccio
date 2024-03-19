<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DayController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\DateController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SlotController;
use App\Http\Controllers\Admin\TimeController;
use App\Http\Controllers\Admin\MonthController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\HashtagController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\admin\NotificationController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Guests\PageController as GuestsPageController;


Route::get('/', function () {
    return view('guests/home');
});

Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {

        Route::get('/',                                      [AdminPageController::class, 'dashboard'])->name('dashboard');
        Route::get('/setting',                               [AdminPageController::class, 'setting'])->name('setting');
        Route::get('/timeslot',                              [AdminPageController::class, 'timeslot'])->name('timeslot');
        Route::get('/slot',                                  [AdminPageController::class, 'slot'])->name('slot');

        // Rotte Projects 
        Route::get('/projects/showCategory/{category_id}',   [ProjectController::class, 'showCategory'])->name('projects.showCategory');
        Route::post('/projects/updatestatus/{project_id}',   [ProjectController::class, 'updatestatus'])->name('projects.updatestatus');
        Route::get('/projects/filter',                      [ProjectController::class, 'filter'])->name('projects.filter');
        Route::get('/projects/trashed',                      [ProjectController::class, 'trashed'])->name('projects.trashed');
        Route::post('/projects/{project}/restore',           [ProjectController::class, 'restore'])->name('projects.restore');
        Route::delete('/projects/{project}/hardDelete',      [ProjectController::class, 'harddelete'])->name('projects.hardDelete');

        // Rotte Post 
        Route::get('/posts/trashed',                         [PostController::class, 'trashed'])->name('posts.trashed');
        Route::resource('posts',                             PostController::class);

        // Rotte Orders
        Route::post('/orders/confirmOrder/{order_id}',       [OrderController::class, 'confirmOrder'])->name('orders.confirmOrder');
        Route::post('/orders/rejectOrder/{order_id}',       [OrderController::class, 'rejectOrder'])->name('orders.rejectOrder');
        Route::get('/orders/filters',       [OrderController::class, 'filters'])->name('orders.filters');

        // Rotte Reservations
        Route::post('/reservations/confirmReservation/{reservation_id}',       [ReservationController::class, 'confirmReservation'])->name('reservations.confirmReservation');
        Route::post('/reservations/rejectReservation/{reservation_id}',       [ReservationController::class, 'rejectReservation'])->name('reservations.rejectReservation');
        Route::get('/reservations/filters',       [ReservationController::class, 'filters'])->name('reservations.filters');

        // Rotte Settings
        Route::put('/settings/allupdate',                    [SettingController::class, 'allupdate'])->name('settings.allupdate');

        // Rotte Day
        Route::get('/days/showResOr/{date_slot}',       [DayController::class, 'showResOr'])->name('days.showResOr');

        // Rotte Notifications
        Route::delete('/notifications/showAndDestroy/{id}', [NotificationController::class, 'showAndDestroy'])->name('notifications.showAndDestroy');
        Route::get('/notifications/clearAll',               [NotificationController::class, 'clearAll'])->name('notifications.clearAll');

        // Rotte Resource
        Route::resource('dates',        DateController::class);
        Route::resource('slots',        SlotController::class);
        Route::resource('settings',     SettingController::class);
        Route::resource('reservations', ReservationController::class);
        Route::resource('orders',       OrderController::class);
        Route::resource('projects',     ProjectController::class);
        Route::resource('categories',   CategoryController::class);
        Route::resource('tags',         TagController::class);
        Route::resource('hashtags',     HashtagController::class);
        Route::resource('months',       MonthController::class);
        Route::resource('days',         DayController::class);
        Route::resource('notifications', NotificationController::class);
        Route::resource('addresses',     AddressController::class);

        // Rotte Date 

        Route::post('/dates/updatestatus/v}',               [DateController::class, 'updatestatus'])->name('dates.updatestatus');
        
        Route::post('/dates/updateMax}',                    [DateController::class, 'updateMax'])->name('dates.updateMax');

        Route::post('/dates/runSeeder',                     [DateController::class, 'runSeeder'])->name('dates.runSeeder');
    });

Route::middleware('auth')
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });


require __DIR__ . '/auth.php';

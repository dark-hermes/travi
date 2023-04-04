<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\LodgeController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\TourCategoryController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\Admin\NewsCategoryController;

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('users/{id}/edit-password', [UserController::class, 'editPassword'])->name('users.edit-password');
    Route::put('users/{id}/update-password', [UserController::class, 'updatePassword'])->name('users.update-password');
    Route::post('users/{id}/image', [UserController::class, 'storeImage'])->name('users.store-image');
    Route::delete('users/{id}/image', [UserController::class, 'destroyImage'])->name('users.destroy-image');
    Route::put('users/{id}/switch-status', [UserController::class, 'switchStatus'])->name('users.switch-status');
    Route::resource('users', UserController::class);

    Route::get('employees/{id}/edit-password', [EmployeeController::class, 'editPassword'])->name('employees.edit-password');
    Route::put('employees/{id}/update-password', [EmployeeController::class, 'updatePassword'])->name('employees.update-password');
    Route::put('employees/{id}/switch-status', [EmployeeController::class, 'switchStatus'])->name('employees.switch-status');
    Route::resource('employees', EmployeeController::class);

    Route::resource('roles', RoleController::class);

    Route::resource('news-categories', NewsCategoryController::class);

    Route::resource('news', NewsController::class);

    Route::resource('tour-categories', TourCategoryController::class);

    Route::get('tours/{slug}/images', [TourController::class, 'showImage'])->name('tours.images');
    Route::post('tours/{id}/image', [TourController::class, 'storeImage'])->name('tours.store-image');
    Route::delete('tours/{id}/image', [TourController::class, 'destroyImage'])->name('tours.destroy-image');
    Route::resource('tours', TourController::class);

    Route::get('lodges/{slug}/images', [LodgeController::class, 'showImage'])->name('lodges.images');
    Route::post('lodges/{id}/image', [LodgeController::class, 'storeImage'])->name('lodges.store-image');
    Route::delete('lodges/{id}/image', [LodgeController::class, 'destroyImage'])->name('lodges.destroy-image');
    Route::resource('lodges', LodgeController::class);

	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('auth.login');
    });
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

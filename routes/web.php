<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderHeaderController;
use App\Http\Controllers\OrderDetailController;

Auth::routes();
Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function () { return redirect('/home'); });
    Route::get('/home', [ SystemController::class, 'home' ]);
    Route::get('/profile', [ SystemController::class, 'profile' ]);
    Route::post('/updateProfile', [ SystemController::class, 'updateProfile' ]);
    Route::middleware('role:ADMIN')->resource('/userAccounts', UserAccountController::class);
    Route::middleware('role:ADMIN,USER')->resource('/products', ProductController::class);
    Route::middleware('role:ADMIN,USER')->resource('/brands', BrandController::class);
    Route::middleware('role:ADMIN,USER')->resource('/orderHeaders', OrderHeaderController::class);
    Route::middleware('role:ADMIN,USER')->resource('/orderDetails', OrderDetailController::class);
    Route::middleware('role:ADMIN,USER')->get('/orderDetails/{order_id}/{no}', [ OrderDetailController::class, 'show' ]);
    Route::middleware('role:ADMIN,USER')->get('/orderDetails/{order_id}/{no}/edit', [ OrderDetailController::class, 'edit' ]);
    Route::middleware('role:ADMIN,USER')->patch('/orderDetails/{order_id}/{no}', [ OrderDetailController::class, 'update' ]);
    Route::middleware('role:ADMIN,USER')->delete('/orderDetails/{order_id}/{no}', [ OrderDetailController::class, 'destroy' ]);
});
Route::get('/logout', [ LoginController::class, 'logout' ]);
Route::get('/resetPassword', [ LoginController::class, 'resetPassword' ]);
Route::post('/resetPassword', [ LoginController::class, 'resetPasswordPost' ]);
Route::get('/changePassword/{token}', [ LoginController::class, 'changePassword' ]);
Route::post('/changePassword/{token}', [ LoginController::class, 'changePasswordPost' ]);
Route::get('/stack', [ SystemController::class, 'stack' ]);

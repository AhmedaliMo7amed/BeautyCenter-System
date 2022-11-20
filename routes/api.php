<?php

use App\Http\Controllers\API\Admin\AdminCategoryController;
use App\Http\Controllers\API\Admin\AdminServiceController;
use App\Http\Controllers\API\Auth\AuthenticationController;
use App\Http\Controllers\API\Auth\RegistrationController;
use App\Http\Controllers\API\Auth\VerificationController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\Providers\DealsController;
use App\Http\Controllers\API\Providers\ProviderController;
use App\Http\Controllers\API\ServicesController;
use App\Http\Controllers\API\Users\OffersController;
use App\Http\Controllers\API\Users\OrdersController;
use Illuminate\Support\Facades\Route;


/********** Login & Register for User **********/

Route::post('login', [AuthenticationController::class, 'login']);
Route::post('resend', [AuthenticationController::class, 'resendCode']);
Route::post('verify', [VerificationController::class, 'verify']);


Route::group(['prefix'=>'user' , 'middleware' => 'auth:sanctum'],function (){
    Route::post('/register', [RegistrationController::class, 'userRegister']);
    Route::post('/add-offer', [OffersController::class, 'store']);
    Route::get('/offers', [OffersController::class, 'showOffers']);
    Route::get('/offer/{id}', [OffersController::class, 'showOffer']);
    Route::get('/order/{id}', [OrdersController::class, 'showOrder']);
    Route::post('/order/{id}/complete', [OrdersController::class, 'completeOrder']);
});

Route::group(['prefix'=>'provider' , 'middleware' => 'auth:sanctum'],function (){
    Route::post('/register', [RegistrationController::class, 'providerRegister']);
    Route::post('/join-category', [ProviderController::class, 'joinCategory']);
    Route::post('/add-service', [ProviderController::class, 'addService']);
    Route::post('/add-package', [ProviderController::class, 'addPackage']);

    Route::group(['prefix'=>'deals' , 'middleware' => 'auth:sanctum' ],function (){
        Route::get('/offers', [DealsController::class, 'allOffers']);
        Route::get('/offer/{id}', [DealsController::class, 'showOffer']);
        Route::get('/offer/{id}/accept', [DealsController::class, 'acceptOffer']);

    });
});

Route::group(['prefix'=>'category'],function (){
    Route::get('/all', [CategoryController::class, 'allCategories']);
    Route::get('/all-sub', [CategoryController::class, 'subCategories']);
    Route::get('/show/{id}', [CategoryController::class, 'getCategory']);
    Route::get('/{id}/providers', [CategoryController::class, 'categoryProviders']);

});

Route::group(['prefix'=>'service'],function (){
    Route::get('/all', [ServicesController::class, 'allServices']);
    Route::get('/{id}/providers', [ServicesController::class, 'serviceProviders']);
    Route::get('/all-sub', [ServicesController::class, 'subServices']);
    Route::get('/show/{id}', [ServicesController::class, 'getService']);
    Route::get('/provider/{id}', [ServicesController::class, 'providerServices']);
});


Route::group(['prefix'=>'admin'],function (){

    Route::group(['prefix'=>'category'],function (){
        Route::post('/add', [AdminCategoryController::class, 'store']);
        Route::post('/update/{id}', [AdminCategoryController::class, 'update']);
        Route::delete('/delete/{id}', [AdminCategoryController::class, 'destroy']);
    });

    Route::group(['prefix'=>'service'],function (){
        Route::post('/add', [AdminServiceController::class, 'store']);
        Route::post('/update/{id}', [AdminServiceController::class, 'update']);
        Route::delete('/delete/{id}', [AdminServiceController::class, 'destroy']);
    });

});











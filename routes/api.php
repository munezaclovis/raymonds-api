<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ThemeSettingsController;
use App\Http\Controllers\UsersController;
use App\Http\Requests\UserProfileRequest;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function (){
    Route::middleware('auth:api')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::get('logout', [AuthenticationController::class, 'logout']);

        Route::apiResource('users', UsersController::class);
        Route::apiResource('roles', RolesController::class);
        Route::apiResource('books', BooksController::class);
        Route::apiResource('theme-settings', ThemeSettingsController::class);
    });

    Route::post('login', [AuthenticationController::class, 'login']);
    Route::post('register', [AuthenticationController::class, 'register']);
    Route::post('test', function (UserProfileRequest $request) {
        // $asd = [];
        // foreach ($request->file('image') as $index){
        //     $asd[] = $index->getRealPath();
        // }
        return Cloudinary::upload(
            array_map(function ($image) {
                return $image->getRealPath();
            }, 
            $request->file('image'))
        )->getSecurePath();
        
        return User::find(10);
    });
});
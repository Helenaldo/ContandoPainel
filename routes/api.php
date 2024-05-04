<?php

use App\Events\UserRegistered;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CidadesController;
use App\Http\Controllers\TenantController;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user/register', RegisterController::class);

Route::post('/user/login', LoginController::class);

Route::apiResource('/tenants', TenantController::class);

Route::get('/cidades', CidadesController::class );

Route::post('email', function() {
    UserRegistered::dispatch();
});


Route::get('email2', function() {
    return view('emails.welcome');
});

<?php

use App\Events\UserRegistered;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CidadesController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContatoClienteController;
use App\Http\Controllers\ProcessoController;
use App\Http\Controllers\ProcessoMovimentoController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TributacaoClienteController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ROTAS AUTENTICADAS
Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::apiResource('/cliente', ClienteController::class);
    Route::apiResource('/tributacao-cliente', TributacaoClienteController::class);
    Route::apiResource('/contato-cliente', ContatoClienteController::class);
    Route::apiResource('/processos/movimentos', ProcessoMovimentoController ::class);
    Route::apiResource('/processos', ProcessoController::class);
    Route::apiResource('/app/user', UserController::class);

    Route::post('app/user/avatar', [UserController::class, 'changeAvatarAction'])->name('change.avatar');

});


// ROTAS PÚBLICAS
Route::post('/user/register', RegisterController::class);
Route::post('/user/login', LoginController::class);
Route::apiResource('/tenants', TenantController::class);
Route::get('/cidades', CidadesController::class );

Route::post('email', function() {
    UserRegistered::dispatch();
});

Route::post('/verify-email', EmailVerificationController::class);

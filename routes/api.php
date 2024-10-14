<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Protocol\CreateProtocolController;
use App\Http\Controllers\Protocol\DeleteProtocolController;
use App\Http\Controllers\Protocol\ListProtocolController;
use App\Http\Controllers\Protocol\UpdateProtocolController;
use App\Http\Controllers\Role\AssingProtocolToRoleController;
use App\Http\Controllers\Role\CreateRoleController;
use App\Http\Controllers\Role\DeleteRoleController;
use App\Http\Controllers\Role\UpdateRoleController;
use App\Http\Controllers\Role\ListRoleController;
use App\Http\Controllers\Role\RemoveProtocolFromRoleController;
use App\Http\Controllers\Role\ShowRoleController;
use App\Http\Controllers\User\AssignRoleToUserController;
use App\Http\Controllers\User\CreateUserController;
use App\Http\Controllers\User\DeleteUserController;
use App\Http\Controllers\User\ListUserController;
use App\Http\Controllers\User\ShowUserController;
use App\Http\Controllers\User\UpdateUserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth', AuthController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('/', ShowUserController::class);
        Route::middleware(['role:Manager'])->group(function () {
            Route::get('/list', ListUserController::class);
            Route::put('/{id_user}', UpdateUserController::class);
            Route::post('/', CreateUserController::class);
            Route::delete('/{id}', DeleteUserController::class);
            Route::put('/{user_id}/role/{role_id}', AssignRoleToUserController::class);
        });
    });
    Route::middleware(['role:Manager'])->group(function () {
        Route::prefix('/role')->group(function () { // só o manager deve ter acesso
            Route::get('/', ListRoleController::class); //Lista todas as roles e seus papeis, só o manager deve ter acesso
            Route::post('/', CreateRoleController::class);
            Route::get('/{id}', ShowRoleController::class); //Lista uma role específica
            Route::put('/{id}', UpdateRoleController::class);
            Route::delete('/{id}', DeleteRoleController::class);
            Route::put('/{id}/protocols', AssingProtocolToRoleController::class); // Adiciona protocolos a essa role
            Route::delete('/{id}/protocols', RemoveProtocolFromRoleController::class); // Retira um ou mais protocolos
        });
        Route::prefix('/protocol')->group(function () { // Apenas o manager deve ter acesso
            Route::get('/', ListProtocolController::class); //Lista todos os protocolos
            Route::post('/', CreateProtocolController::class); // Cria um protocolo
            Route::put('/{id}', UpdateProtocolController::class); // Atualiza um protocolo
            Route::delete('/{id}', DeleteProtocolController::class); // Retira um protocolo
        });
    });
});

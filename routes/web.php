<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register');

Route::get('/user', function () {
    return Inertia::render('User/User');
});

Route::get('/protocol', function () {
    return Inertia::render('Protocols/Protocols');
});

Route::prefix('/roles')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Roles/Roles');
    });
    Route::get('/create', function () {
        return Inertia::render('Roles/RoleCreate');
    });
    Route::get('/edit/{id}', function () {
        return Inertia::render('Roles/RoleEdit');
    });

});



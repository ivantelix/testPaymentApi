<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\PaymentsController;

//client url
Route::get('/api/clients', [ClientsController::class, 'show']);

//payments url
Route::get('/api/payments/{client_id}', [ClientsController::class, 'show']);
Route::post('/api/payments', [PaymentsController::class, 'create']);

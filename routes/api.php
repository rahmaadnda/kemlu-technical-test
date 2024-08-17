<?php

use App\Http\Controllers\NegaraController;

Route::get('/negara', [NegaraController::class, 'index']);
Route::get('/negara/{id}', [NegaraController::class, 'show']);
Route::post('negara', [NegaraController::class, 'store']);
Route::put('negara/{id}', [NegaraController::class, 'update']);
Route::delete('negara/{id}', [NegaraController::class, 'destroy']);

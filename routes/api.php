<?php

use App\Http\Controllers\Api\InventoryApiController;
use Illuminate\Support\Facades\Route;

Route::get('/tablet/inventories', [InventoryApiController::class, 'index']);
Route::post('/tablet/check-in/{id}', [InventoryApiController::class, 'checkIn']);

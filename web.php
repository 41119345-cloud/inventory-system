<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('admin/inventory', \App\Http\Controllers\Admin\InventoryController::class);

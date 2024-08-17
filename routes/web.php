<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/geomap', function () {
    return view('geomap'); // Adjust to your actual view file
})->name('geomap');

Route::get('/datatable', function () {
    return view('datatable'); // Adjust to your actual view file
})->name('datatable');

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/geomap', function () {
    return view('geomap'); 
})->name('geomap');

Route::get('/datatable', function () {
    return view('datatable');
})->name('datatable');

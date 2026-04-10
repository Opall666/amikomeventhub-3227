<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/profil', function () {
    return view('profil');
});

Route::get('/katalog', function () {
    return view('katalog');
});

Route::get('/bantuan', function () {
    return view('bantuan');

});
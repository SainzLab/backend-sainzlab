<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/link-storage', function () {
    Artisan::call('storage:link');
    return 'Symlink berhasil dibuat!';
});

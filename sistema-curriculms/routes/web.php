<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurriculumController;

Route::get('/', function () {
    return redirect()->route('curricula.index');
});

Route::resource('curricula', CurriculumController::class);
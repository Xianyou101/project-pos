<?php

use Illuminate\Support\Facades\Route;
use App\Exports\TemplateExport;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/download-template', function() {
    return Excel::download(new TemplateExport, 'template.xlsx');
})->name('download-template');
;

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
;




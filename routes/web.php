<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

Route::get('/',[\App\Http\Controllers\HomeController::class, 'index']);
Route::get('/biens',[\App\Http\Controllers\PropertyController::class, 'index'])->name('property.index');
Route::get('/biens/{slug}-{property}', [\App\Http\Controllers\PropertyController::class, 'show'])->name('property.show')->where([
    'property' => $idRegex,
    'slug' => $slugRegex
]);

Route::post('/biens/{property}-/contact', [App\Http\Controllers\PropertyController::class,'contact'])->name('property.contact')->where([
    'property' => $idRegex
]);

Route::get('/upload-image', [App\Http\Controllers\ImageUploadController::class, 'upload_image'])->name('upload.image');
Route::post('/store-image', [App\Http\Controllers\ImageUploadController::class, 'store_image'])->name('store.image');
Route::get('/show-image', [App\Http\Controllers\ImageUploadController::class, 'show_image'])->name('store.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



//Route::get('/images/{path}', [\App\Http\Controllers\ImagesController::class,'show'])->where('path', '.*');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () use ($idRegex){
    Route::resource('property', \App\Http\Controllers\Admin\PropertyController::class)->except(['show']);
    Route::resource('option', \App\Http\Controllers\Admin\OptionController::class)->except(['show']);
    Route::delete('picture/{picture}', [\App\Http\Controllers\Admin\OptionController::class, 'destroy'])
    ->name('picture.destroy')
    ->where([
        'picture' => $idRegex,
    ])
    ->can('delete', 'picture');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

require __DIR__.'/auth.php';

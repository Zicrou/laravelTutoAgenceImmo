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



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



//Route::get('/images/{path}', [\App\Http\Controllers\ImagesController::class,'show'])->where('path', '.*');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () use ($idRegex){
    Route::resource('property', \App\Http\Controllers\Admin\PropertyController::class)->except(['show']);
    Route::resource('option', \App\Http\Controllers\Admin\OptionController::class)->except(['show']);
    
    // Picture Index
    Route::get('picture/{property}', [\App\Http\Controllers\Admin\PictureController::class, 'index'])
    ->name('picture.index')
    ->where([
        'property' => $idRegex,
    ]);

    // Picture Destroy
    Route::delete('picture/{property}', [\App\Http\Controllers\Admin\PictureController::class, 'destroy'])
    ->name('picture.destroy')
    ->where([
        'property' => $idRegex,
    ]);
    
    // Store Picture
    Route::post('picture/{property}', [\App\Http\Controllers\Admin\PictureController::class, 'store_picture'])
    ->name('picture.store')
    ->where([
        'property' => $idRegex,
    ]);

    
    Route::get('/images/{property}/upload', [\App\Http\Controllers\Admin\ImageUploadController::class, 'index'])
    ->name('upload.image')
    ->where([
        'property' => $idRegex,
    ]);

    Route::post('/images/{property}/upload', [App\Http\Controllers\Admin\ImageUploadController::class, 'store_image'])
    ->name('store.image')
    ->where([
        'property' => $idRegex,
    ]);

    Route::get('images/{property}/delete', [App\Http\Controllers\Admin\ImageUploadController::class, 'destroy'])
    ->name('delete.image')
    ->where([
        'property' => $idRegex,
    ]);
    //->can('delete', 'imageUpload');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

require __DIR__.'/auth.php';

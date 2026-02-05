<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DetelsCoursesController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\Auth\RegisteredUserController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [CoursesController::class, 'index'])->name('courses');
Route::get('/course-details/{id}', [DetelsCoursesController::class, 'index'])->name('course.details');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth:client')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/course/{id}', [DetelsCoursesController::class, 'show'])->name('course.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/client/logout', [RegisteredUserController::class, 'logout'])->name('client.logout');
});

Route::post('/course/book/{id}', [DetelsCoursesController::class, 'book'])->name('course.book');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');
Route::get('/terms-and-conditions', [AboutUsController::class, 'termsAndConditions'])->name('terms-and-conditions');
Route::get('/privacy-policy', [AboutUsController::class, 'privacyPolicy'])->name('privacy-policy');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter');

// Video upload routes (protected for admin panel)
Route::middleware(['web', 'auth'])->prefix('admin/api/videos')->group(function () {
    Route::post('/get-signed-url', [VideoController::class, 'getSignedUploadUrl'])->name('videos.signed-url');
    Route::post('/confirm-upload', [VideoController::class, 'confirmUpload'])->name('videos.confirm-upload');
    Route::post('/cancel-upload', [VideoController::class, 'cancelUpload'])->name('videos.cancel-upload');
    Route::get('/', [VideoController::class, 'index'])->name('videos.index');
    Route::delete('/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');
});

require __DIR__.'/auth.php';

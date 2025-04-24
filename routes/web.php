<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Feedback_validate;
use Illuminate\Support\Facades\Route;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     if (Auth::check() && Auth::user()->is_admin === 1) {
//         return view('dashboard');
//     }
//     else {
//         return redirect('/')->with('error', 'Unauthorized access');
//     }
   
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::post('/feedback', [Feedback_validate::class, 'submit'])->name('feedback.submit');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');


Route::post('/feedbacks/{id}/update-addressed', function (Request $request, $id) {
    $feedback = Feedback::findOrFail($id);
    $feedback->addressed = $request->input('addressed');
    $feedback->save();

    return response()->json(['success' => true, 'addressed' => $feedback->addressed]);
});
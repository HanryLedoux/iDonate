<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/perfil/{id?}', [ProfileController::class, 'show'])->name('perfil.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [\App\Http\Controllers\EventController::class, 'create'])->name('events.create');
    Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
    Route::post('/events', [\App\Http\Controllers\EventController::class, 'store'])->name('events.store');
    Route::post('/events/{event}/register', [\App\Http\Controllers\EventController::class, 'register'])->name('events.register');

    // Alimentos no evento
    Route::post('/events/{event}/food-items', [\App\Http\Controllers\EventFoodItemController::class, 'store'])->name('events.food-items.store');
    Route::patch('/events/{event}/food-items/{foodItem}/status', [\App\Http\Controllers\EventFoodItemController::class, 'updateStatus'])->name('events.food-items.status');
    Route::delete('/events/{event}/food-items/{foodItem}', [\App\Http\Controllers\EventFoodItemController::class, 'destroy'])->name('events.food-items.destroy');

    Route::get('/companies', [\App\Http\Controllers\CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/{company}', [\App\Http\Controllers\CompanyController::class, 'show'])->name('companies.show');
    
    Route::get('/companies/{company}/food-items/create', [\App\Http\Controllers\FoodItemController::class, 'create'])->name('food-items.create');
    Route::post('/companies/{company}/food-items', [\App\Http\Controllers\FoodItemController::class, 'store'])->name('food-items.store');
    
    Route::get('/food-items/{food_item}', [\App\Http\Controllers\FoodItemController::class, 'show'])->name('food-items.show');

    Route::get('/donations', [\App\Http\Controllers\DonationController::class, 'index'])->name('donations.index');
    Route::post('/donations', [\App\Http\Controllers\DonationController::class, 'store'])->name('donations.store');
    Route::delete('/donations/{donation}', [\App\Http\Controllers\DonationController::class, 'destroy'])->name('donations.destroy');
    Route::post('/donations/{donation}/cancel', [\App\Http\Controllers\DonationController::class, 'cancel'])->name('donations.cancel');
    Route::post('/donations/{donation}/partial-cancel', [\App\Http\Controllers\DonationController::class, 'partialCancel'])->name('donations.partialCancel');
    
});

require __DIR__.'/auth.php';

<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;


Route::get('/', function () {
    return view('home');
});

Route::resource('/expenses', ExpenseController::class);
Route::resource('/users', UserController::class);

Route::post('/users/{user}/search', function(User $user) {
    return redirect("/users/{$user->id}?searchQuery=" . request('searchQuery'));
});

Route::post('/user-search', function() {
    return redirect('/users?searchQuery=' . request('searchQuery'));
});

Route::post('/users/{user}/search-expenses', [UserController::class, 'searchExpenses']);
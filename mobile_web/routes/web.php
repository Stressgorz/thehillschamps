<?php

use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\UserPageController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\IncentiveController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});





Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/performance', [PerformanceController::class, 'index'])->name('performance.view');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.view');
    Route::get('/roadmap', [RoadmapController::class, 'index'])->name('roadmap.view');
    Route::get('/requirement', [RequirementController::class, 'index'])->name('requirement.view');
    Route::get('/mkt-requirement', [UserPageController::class, 'requirement'])->name('mkt-requirement.view');
    Route::get('/ib-requirement', [UserPageController::class, 'requirement'])->name('ib-requirement.view');
    Route::get('/incentive', [IncentiveController::class, 'index'])->name('incentive.view');
    Route::get('/', [UserPageController::class, 'home'])->name('home.view');
});

require __DIR__ . '/auth.php';

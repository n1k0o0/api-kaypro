<?php

use Illuminate\Support\Facades\Route;

Route::prefix('users')->as('users.')->group(function () {
    Route::post('login', [\App\Http\Controllers\Users\AuthController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\Users\AuthController::class, 'register']);
    Route::post('verify/resend', [\App\Http\Controllers\Users\AuthController::class, 'resendEmailVerify']);
    Route::put('verify/confirm', [\App\Http\Controllers\Users\AuthController::class, 'verifyEmail']);
    Route::post('password/recover', [\App\Http\Controllers\Users\AuthController::class, 'recoverPassword']);
    Route::put('password/recover', [\App\Http\Controllers\Users\AuthController::class, 'updatePassword']);
    Route::middleware(['auth:users'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Users\AuthController::class, 'logout']);
        Route::get('/me', [\App\Http\Controllers\Users\AuthController::class, 'getMe']);
    });
    Route::resource('news', \App\Http\Controllers\Users\NewsController::class)->only('index', 'show');
    Route::post(
        'trainings/{training}/application',
        [\App\Http\Controllers\Users\TrainingController::class, 'applyForTraining']
    );
    Route::resource('trainings', \App\Http\Controllers\Users\TrainingController::class)->only('index', 'show');
    Route::resource('pages', \App\Http\Controllers\Users\PageController::class)->only('show');
    Route::post('/feedback', \App\Http\Controllers\Users\FeedbackController::class);
    Route::resource('product-categories', \App\Http\Controllers\Users\ProductCategoryController::class);
    Route::resource('products', \App\Http\Controllers\Users\ProductController::class);
});

Route::prefix('moderators')->as('moderators.')->group(function () {
    Route::post('login', [\App\Http\Controllers\Moderators\AuthController::class, 'login']);
    Route::middleware(['auth:moderators'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Moderators\AuthController::class, 'logout']);
        Route::get('/me', [\App\Http\Controllers\Moderators\AuthController::class, 'getMe']);
        Route::resource('users', \App\Http\Controllers\Moderators\UserController::class);
        Route::resource('moderators', \App\Http\Controllers\Moderators\ModeratorController::class);
        Route::resource('trainings', \App\Http\Controllers\Moderators\TrainingController::class);
        Route::resource('applications', \App\Http\Controllers\Moderators\ApplicationTrainingController::class);
        Route::resource('news', \App\Http\Controllers\Moderators\NewsController::class);
        Route::resource('pages', \App\Http\Controllers\Moderators\PageController::class);
        Route::resource('product-categories', \App\Http\Controllers\Moderators\ProductCategoryController::class);
        Route::resource('products', \App\Http\Controllers\Moderators\ProductController::class);
    });
});

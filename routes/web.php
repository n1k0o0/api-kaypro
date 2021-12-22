<?php

Route::get('password/reset/{token}', [\App\Http\Controllers\Users\AuthController::class, 'updatePassword'])->name(
    'users.updatePassword'
);

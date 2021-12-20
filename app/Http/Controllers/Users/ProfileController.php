<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Profile\ChangePasswordRequest;
use App\Http\Requests\Users\Profile\UpdateProfileRequest;
use App\Http\Resources\Users\User\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = auth()->user();
        if (!Hash::check($request->old_password, $user?->password)) {
            return $this->respondUnprocessableEntity('Неправильный текущий пароль');
        }
        $user?->update(['password' => $request->password]);
        return $this->respondSuccess();
    }

    /**
     * @param UpdateProfileRequest $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = auth()->user();
        $user?->update($request->validated());
        return $this->respondSuccess();
    }

    /**
     * @return JsonResponse
     */
    public function getProfile(): JsonResponse
    {
        return $this->respondSuccess(UserResource::make(auth()->user()));
    }
}

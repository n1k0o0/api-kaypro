<?php

namespace App\Http\Controllers\Moderators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moderators\Auth\LoginUserRequest;
use App\Http\Resources\Moderators\Moderator\ModeratorResource;
use App\Models\Moderator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        return $this->respondCreated();
    }

    /**
     * Display the specified resource.
     *
     * @param  Moderator  $moderator
     * @return void
     */
    public function show(Moderator $moderator): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return JsonResponse
     */
    public function update(): JsonResponse
    {
        return $this->respondSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Moderator  $moderator
     * @return void
     */
    public function destroy(Moderator $moderator): void
    {
        //
    }

    /**
     * @throws Exception
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $user = Moderator::query()->where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return $this->respondUnauthorized('The provided credentials are incorrect.');
        }

        $token = $user->createToken($request->input('device_name') || $user->name)->plainTextToken;
        return $this->respondWithToken($token);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function getMe(): JsonResponse
    {
        return $this->respondSuccess(ModeratorResource::make(auth()->user()));
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()?->logout();
        return $this->respondSuccess();
    }
}

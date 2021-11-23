<?php

namespace App\Http\Controllers\Moderators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moderators\User\GetUsersRequest;
use App\Http\Requests\Moderators\User\UpdateUserRequest;
use App\Http\Resources\Moderators\User\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{

    /**
     * @param  UserService  $userService
     */
    public function __construct(
            private UserService $userService
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @param  GetUsersRequest  $request
     * @return AnonymousResourceCollection
     */
    public function index(GetUsersRequest $request): AnonymousResourceCollection
    {
        $user = $this->userService->getUsers($request->validated(), $request->input('limit'));

        return UserResource::collection($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return $this->respondSuccess(UserResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());
        return $this->respondSuccess($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return $this->respondSuccess();
    }
}

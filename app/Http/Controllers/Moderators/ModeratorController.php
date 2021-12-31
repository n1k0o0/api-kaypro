<?php

namespace App\Http\Controllers\Moderators;

use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Moderators\Moderator\CreateModeratorRequest;
use App\Http\Requests\Moderators\Moderator\GetModeratorsRequest;
use App\Http\Requests\Moderators\Moderator\UpdateModeratorRequest;
use App\Http\Resources\Moderators\Moderator\ModeratorResource;
use App\Models\Moderator;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ModeratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GetModeratorsRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GetModeratorsRequest $request): AnonymousResourceCollection
    {
        $query = Moderator::query()
            ->when(
                $request->input('first_name'),
                fn(Builder $query) => $query->where('first_name', 'LIKE', '%' . $request->input('first_name') . '%')
            )
            ->when(
                $request->input('last_name'),
                fn(Builder $query) => $query->where('last_name', 'LIKE', '%' . $request->input('last_name') . '%')
            )
            ->when(
                $request->input('phone'),
                fn(Builder $query) => $query->where('phone', 'LIKE', '%' . $request->input('phone') . '%')
            )
            ->when(
                $request->input('email'),
                fn(Builder $query) => $query->where('email', 'LIKE', '%' . $request->input('email') . '%')
            )
            ->when(
                isset($data['sort']),
                fn(Builder $query) => $query->orderBy($request->input('sort'), $request->input('sort_type'))
            );

        if ($request->input('limit')) {
            return ModeratorResource::collection($query->latest()->paginate($request->input('limit')));
        }
        return ModeratorResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateModeratorRequest $request
     * @return JsonResponse
     */
    public function store(CreateModeratorRequest $request): JsonResponse
    {
        Moderator::query()->create($request->validated());
        return $this->respondSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param Moderator $moderator
     * @return JsonResponse
     */
    public function show(Moderator $moderator): JsonResponse
    {
        return $this->respondSuccess(ModeratorResource::make($moderator));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateModeratorRequest $request
     * @param Moderator $moderator
     * @return JsonResponse
     */
    public function update(UpdateModeratorRequest $request, Moderator $moderator): JsonResponse
    {
        $moderator->update($request->validated());
        return $this->respondSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Moderator $moderator
     * @return JsonResponse
     * @throws BusinessLogicException
     * @throws AuthorizationException
     */
    public function destroy(Moderator $moderator): JsonResponse
    {
        if ($moderator->isSuperAdmin() || auth('moderators')->user()?->isModerator() || ($moderator->isAdmin() && !auth(
                    'moderators'
                )->user()?->isSuperAdmin())) {
            throw new AuthorizationException();
        }
        $moderator->delete();
        return $this->respondSuccess();
    }
}

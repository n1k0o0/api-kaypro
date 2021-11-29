<?php

namespace App\Http\Controllers\Moderators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moderators\ApplicationTraining\CreateApplicationTrainingRequest;
use App\Http\Requests\Moderators\ApplicationTraining\GetApplicationsTrainingRequest;
use App\Http\Requests\Moderators\ApplicationTraining\UpdateApplicationTrainingRequest;
use App\Http\Resources\Moderators\ApplicationTraining\ApplicationTrainingResource;
use App\Models\ApplicationTraining;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApplicationTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  GetApplicationsTrainingRequest  $request
     * @return AnonymousResourceCollection
     */
    public function index(GetApplicationsTrainingRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $limit = data_get($data, 'limit');
        $applications = ApplicationTraining::query()
                ->with('training', 'user')
                ->when(
                        isset($data['name']),
                        fn(Builder $q) => $q->whereHas(
                                'training',
                                fn(Builder $q) => $q->where('name', 'like', '%'.$data['name'].'%')
                        )
                )
                ->when(
                        isset($data['sort']),
                        fn(Builder $query) => $query->orderBy($data['sort'], $data['sort_type'])
                );

        if ($limit) {
            return ApplicationTrainingResource::collection($applications->latest()->paginate($limit));
        }
        return ApplicationTrainingResource::collection($applications->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateApplicationTrainingRequest  $request
     * @return JsonResponse
     */
    public function store(CreateApplicationTrainingRequest $request): JsonResponse
    {
        ApplicationTraining::query()->create($request->validated());
        return $this->respondSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  ApplicationTraining  $application
     * @return JsonResponse
     */
    public function show(ApplicationTraining $application): JsonResponse
    {
        return $this->respondSuccess(ApplicationTrainingResource::make($application));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateApplicationTrainingRequest  $request
     * @param  ApplicationTraining  $application
     * @return JsonResponse
     */
    public function update(
            UpdateApplicationTrainingRequest $request,
            ApplicationTraining $application
    ): JsonResponse {
        $application->update($request->validated());
        return $this->respondSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ApplicationTraining  $application
     * @return JsonResponse
     */
    public function destroy(ApplicationTraining $application): JsonResponse
    {
        $application->delete();
        return $this->respondSuccess();
    }
}

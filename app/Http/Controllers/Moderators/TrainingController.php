<?php

namespace App\Http\Controllers\Moderators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moderators\Training\CreateTrainingRequest;
use App\Http\Requests\Moderators\Training\GetTrainingsRequest;
use App\Http\Requests\Moderators\Training\UpdateTrainingRequest;
use App\Http\Resources\Moderators\Training\TrainingResource;
use App\Models\Training;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  GetTrainingsRequest  $request
     * @return AnonymousResourceCollection
     */
    public function index(GetTrainingsRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $limit = data_get($data, 'limit');
        $trainings = Training::query()
                ->with('logo')
                ->when(isset($data['name']), fn(Builder $q) => $q->where('name', 'like', '%'.$data['name'].'%'))
                ->when(isset($data['date']), fn(Builder $q) => $q->whereDate('date', $data['date']))
                ->when(
                        isset($data['sort']),
                        fn(Builder $query) => $query->orderBy($data['sort'], $data['sort_type'])
                );

        if ($limit) {
            return TrainingResource::collection($trainings->latest()->paginate($limit));
        }
        return TrainingResource::collection($trainings->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTrainingRequest  $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(CreateTrainingRequest $request): JsonResponse
    {
        /* @var Training $training */
        {
            DB::beginTransaction();
            $training = Training::query()->create($request->validated());
            if (data_get($request, 'logo')) {
                $training->addMediaFromRequest('logo')->toMediaCollection(Training::LOGO_MEDIA_COLLECTION);
            }
            DB::commit();

            return $this->respondSuccess();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Training  $training
     * @return JsonResponse
     */
    public function show(Training $training): JsonResponse
    {
        return $this->respondSuccess(TrainingResource::make($training->loadMissing('logo')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTrainingRequest  $request
     * @param  Training  $training
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(UpdateTrainingRequest $request, Training $training): JsonResponse
    {
        DB::beginTransaction();
        $training->update($request->validated());
        if (data_get($request, 'logo')) {
            $training->addMediaFromRequest('logo')->toMediaCollection(Training::LOGO_MEDIA_COLLECTION);
        } else {
            $training->logo()->delete();
        }
        DB::commit();

        return $this->respondSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Training  $training
     * @return JsonResponse
     */
    public function destroy(Training $training): JsonResponse
    {
        $training->delete();
        return $this->respondSuccess();
    }

}

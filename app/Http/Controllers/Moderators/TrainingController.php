<?php

namespace App\Http\Controllers\Moderators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moderators\Training\CreateTrainingRequest;
use App\Http\Requests\Moderators\Training\GetTrainingsRequest;
use App\Http\Requests\Moderators\Training\UpdateTrainingRequest;
use App\Http\Resources\Moderators\Training\TrainingResource;
use App\Models\Training;
use Exception;
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

        try {
            DB::beginTransaction();
            $training = Training::query()->create($request->validated());
            if (data_get($request, 'logo_upload')) {
                $training->addMediaFromRequest('logo_upload')->toMediaCollection(Training::LOGO_MEDIA_COLLECTION);
            }
            if (data_get($request, 'lecturer_avatar_upload')) {
                $training->addMediaFromRequest('lecturer_avatar_upload')->toMediaCollection(
                        Training::LECTURER_AVATAR_MEDIA_COLLECTION
                );
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $this->respondSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  Training  $training
     * @return JsonResponse
     */
    public function show(Training $training): JsonResponse
    {
        return $this->respondSuccess(TrainingResource::make($training->loadMissing('logo', 'lecturerAvatar')));
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
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $training->update($data);
            if (data_get($request, 'logo_upload')) {
                $training->addMediaFromRequest('logo_upload')->toMediaCollection(Training::LOGO_MEDIA_COLLECTION);
            }
            if (data_get($request, 'lecturer_avatar_upload')) {
                $training->addMediaFromRequest('lecturer_avatar_upload')->toMediaCollection(
                        Training::LECTURER_AVATAR_MEDIA_COLLECTION
                );
            } elseif (array_key_exists('lecturer_avatar_upload', $data)) {
                $training->lecturerAvatar()->delete();
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
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

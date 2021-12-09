<?php

namespace App\Http\Controllers\Users;

use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ApplicationTraining\CreateApplicationTrainingRequest;
use App\Http\Requests\Users\Training\GetTrainingsRequest;
use App\Http\Resources\Users\Training\TrainingResource;
use App\Models\Training;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GetTrainingsRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GetTrainingsRequest $request): AnonymousResourceCollection
    {
        /** @noinspection PhpUndefinedMethodInspection */
        /* @var Training $trainings */
        $trainings = Training::query()
            ->visible()
            ->with('logo')
            ->when($request->date_from, fn(Builder $q) => $q->whereDate('date', '>=', $request->date_from))
            ->when($request->date_to, fn(Builder $q) => $q->whereDate('date', '<=', $request->date_to))
            ->orderBy('date')
            ->select('id', 'name', 'meta_slug', 'date', 'price', 'lecturer', 'city', 'status')
            ->paginate(20);

        return TrainingResource::collection($trainings);
    }


    /**
     * Display the specified resource.
     *
     * @param Training $training
     * @return JsonResponse
     */
    public function show(Training $training): JsonResponse
    {
        return $this->respondSuccess(TrainingResource::make($training->loadMissing('logo')));
    }

    /**
     * @param Training $training
     * @param CreateApplicationTrainingRequest $request
     * @return JsonResponse
     * @throws BusinessLogicException
     */
    public function applyForTraining(Training $training, CreateApplicationTrainingRequest $request): JsonResponse
    {
        $data = $request->validated();
        if (auth('users')->check()) {
            if ($training->applications()->where('user_id', auth('users')->id())->exists()) {
                throw new BusinessLogicException('Вы уже записались на данное обучение');
            }
            $data['user_id'] = auth('users')->id();
        }
        $training->applications()->create($data);
        return $this->respondSuccess();
    }

}

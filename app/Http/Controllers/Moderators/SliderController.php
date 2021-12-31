<?php

namespace App\Http\Controllers\Moderators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moderators\Slider\CreateSlideRequest;
use App\Http\Requests\Moderators\Slider\UpdateSliderRequest;
use App\Http\Resources\Moderators\Slider\SliderResource;
use App\Models\Slider;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SliderController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateSlideRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(CreateSlideRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            /**@var Slider $slide */
            $data = $request->validated();
            $slide = Slider::query()
                ->create($data);
            $slide->addMediaFromRequest('image_upload')->toMediaCollection();
            if ($request->hasFile('media_upload')) {
                $slide->addMediaFromRequest('media_upload')->toMediaCollection('media_file');
            }
            DB::commit();
            return $this->respondSuccess(SliderResource::make($slide->loadMissing('image', 'mediaFile')));
        } catch (Exception $e) {
            DB::rollBack();
            throw new $e();
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSliderRequest $request
     * @param Slider $slider
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(UpdateSliderRequest $request, Slider $slider): JsonResponse
    {
        try {
            DB::beginTransaction();
            $slider->update($request->validated());
            if ($request->file('image_upload')) {
                $slider->addMediaFromRequest('image_upload')->toMediaCollection();
            }
            DB::commit();
            return $this->respondSuccess();
        } catch (Exception $e) {
            DB::rollBack();
            throw new $e();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateOrder(Request $request): JsonResponse
    {
        Slider::query()->upsert($request->sliders, ['id'], ['order']);

        return $this->respondSuccess(222);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Slider $slider
     * @return JsonResponse
     */
    public function destroy(Slider $slider): JsonResponse
    {
        $slider->delete();
        return $this->respondSuccess();
    }
}

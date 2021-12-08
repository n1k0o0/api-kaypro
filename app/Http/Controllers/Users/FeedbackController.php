<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Feedback\SendFeedbackRequest;
use App\Models\Page;
use App\Notifications\Users\Feedback\SendFeedbackNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

class FeedbackController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param SendFeedbackRequest $request
     * @return JsonResponse
     */
    public function __invoke(SendFeedbackRequest $request): JsonResponse
    {
        $route = match ($request->type) {
            Page::FEEDBACK_TYPE_APPEAL => 'l.sotnikova@handsapp.ru',
            Page::FEEDBACK_TYPE_REQUEST => 'l.sotnikova@handsapp.ru',
            Page::FEEDBACK_TYPE_SUPPORT => 'l.sotnikova@handsapp.ru',
        };
        Notification::route('mail', $route)->notify(new SendFeedbackNotification($request->validated()));
        return $this->respondSuccess();
    }
}

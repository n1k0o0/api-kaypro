<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     *
     * @param  mixed  $data
     * @return JsonResponse
     */
    public function respondCreated(mixed $data = []): JsonResponse
    {
        return response()->json($data, Response::HTTP_CREATED);
    }

    /**
     *
     * @param  mixed  $data
     * @return JsonResponse
     */
    public function respondAccepted(mixed $data = []): JsonResponse
    {
        return response()->json($data, Response::HTTP_ACCEPTED);
    }

    /**
     * @param  mixed|null  $data
     *
     * @return JsonResponse
     */
    public function respondUnprocessableEntity(mixed $data = null): JsonResponse
    {
        return response()->json($data, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param  mixed|null  $data
     *
     * @return JsonResponse
     */
    public function respondUnauthorized(mixed $data = null): JsonResponse
    {
        return response()->json($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return $this->respondSuccess([
                'access_token' => $token,
                'token_type' => 'bearer',
//            'expires_in' => auth('internal-users')->factory()->getTTL() * 60
        ]);
    }

    /**
     *
     * @param  mixed  $data
     * @return JsonResponse
     */
    public function respondSuccess(mixed $data = []): JsonResponse
    {
        return response()->json($data, Response::HTTP_OK);
    }

}

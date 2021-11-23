<?php

namespace App\Http\Controllers\Users;

use App\Events\Users\Auth\Registered;
use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Auth\LoginRequest;
use App\Http\Requests\Users\Auth\RecoverPasswordRequest;
use App\Http\Requests\Users\Auth\RegisterRequest;
use App\Http\Requests\Users\Auth\ResendVerifyEmailRequest;
use App\Http\Requests\Users\Auth\UpdatePasswordRequest;
use App\Http\Requests\Users\Auth\VerifyEmailRequest;
use App\Http\Resources\Users\User\UserResource;
use App\Models\EmailVerification;
use App\Models\PasswordRecovery;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  RegisterRequest  $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::query()->create($request->validated())->fresh();
        if (data_get($request, 'entity')) {
            $request->merge(['entity_status' => User::STATUS_NOT_CHECKED]);
        }
        event(new Registered($user));
        return $this->respondCreated();
    }

    /**
     * @throws Exception
     */
    public function resendEmailVerify(ResendVerifyEmailRequest $request): JsonResponse
    {
        $user = User::query()->where('email', $request->input('email'))->firstOrFail();
        if ($user->isActive()) {
            throw new BusinessLogicException('Пользователь уже подтвержден');
        }
        $user->emailVerifications()->whereNull('verified_at')->delete();
        $emailVerification = $user->emailVerifications()->create(
                [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'verified_at' => null,
                        'verification_code' => create4DigitCodeForEmailVerify()
                ]
        );
        $user->notifyByEmailVerification($emailVerification);
        $emailVerification->sent_at = now();
        $emailVerification->save();
        return $this->respondSuccess();
    }

    /**
     * @throws BusinessLogicException
     */
    public function verifyEmail(VerifyEmailRequest $request): JsonResponse
    {
        /** @var EmailVerification $verification */
        $verification = EmailVerification::query()
                ->where('email', $request->input('email'))
                ->whereNotNull('sent_at')
                ->whereNull('verified_at')
                ->orderBy('sent_at', 'desc')
                ->firstOrFail();

        if (!$verification || $verification->verification_code !== (int)$request->input('code')) {
            throw new BusinessLogicException('Неправильный код');
        }

        $verification->markAsVerified();

        /** @var User $user */
        $user = $verification->user;

        if ($user->email !== $verification->email) {
            $user->email = $verification->email;
        }

        if ($user->isNotVerified()) {
            $user->status = User::STATUS_ACTIVE;
        }

        if ($user->isDirty()) {
            $user->save();
        }

        return $this->respondWithToken($user->createToken($user->first_name)->plainTextToken);
    }

    /**
     * @param  RecoverPasswordRequest  $request
     *
     * @return JsonResponse
     * @throws Exception
     * @throws Throwable
     */
    public function recoverPassword(RecoverPasswordRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()->where('email', $request->input('email'))->firstOrFail();
        /** @var PasswordRecovery $passwordRecovery */
        try {
            DB::beginTransaction();
            $user->passwordRecoveries()->whereNull('recovered_at')->delete();
            $passwordRecovery = $user->passwordRecoveries()->create([
                    'user_id' => $user->id,
                    'verification_code' => create4DigitCodeForPasswordRecovery(),
            ]);

            $user->notifyByPasswordRecovery($passwordRecovery);

            $passwordRecovery->sent_at = now();
            $passwordRecovery->save();
            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
        return $this->respondSuccess();
    }

    /**
     * @param  UpdatePasswordRequest  $request
     *
     * @return JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        /** @var PasswordRecovery $recovery */
        /** @var User $user */
        $recovery = PasswordRecovery::query()
                ->where('verification_code', $request->input('code'))
                ->whereNotNull('sent_at')
                ->whereNull('recovered_at')
                ->orderBy('sent_at', 'desc')
                ->firstOrFail();

        $recovery->markAsRecovered();

        $user = $recovery->user;
        $user->update(['password' => $request->input('new_password')]);
        $user->tokens()->delete();
        return $this->respondSuccess();
    }

    /**
     * @throws Exception
     */
    public function login(LoginRequest $request): JsonResponse|null|string
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $user = User::query()->where('email', $request->input('email'))->active()->first();
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return $this->respondUnauthorized('The provided credentials are incorrect.');
        }
        if ($user->isNotVerified()) {
            return null;
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
        return $this->respondSuccess(UserResource::make(auth()->user()));
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

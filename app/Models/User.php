<?php

namespace App\Models;

use App\Notifications\Users\Auth\PasswordRecoveryNotification;
use App\Notifications\Users\Auth\VerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $patronymic
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $address
 * @property string $status
 * @property string $entity
 * @property string $entity_status
 * @property string $entity_name
 * @property string|null $ITN ИНН (Идентификационный Номер Налогоплательщика) — ITN (Individual Taxpayer Number)
 * @property string|null $PSRN ОГРН (Основной Государственный Регистрационный Номер) — PSRN (Primary State Registration Number)
 * @property string|null $entity_address
 * @property string|null $price_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|EmailVerification[] $emailVerifications
 * @property-read int|null $email_verifications_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|PasswordRecovery[] $passwordRecoveries
 * @property-read int|null $password_recoveries_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public const STATUS_EMAIL_VERIFICATION = 'email_verification',
            STATUS_ACTIVE = 'active',
            STATUS_DISABLED = 'disabled',
            STATUS_NOT_CHECKED = 'not_checked',
            STATUS_ON_VERIFICATION = 'on_verification',
            STATUS_VERIFIED = 'verified',
            STATUS_REJECTED = 'rejected';

    public const STATUSES = [
            self::STATUS_EMAIL_VERIFICATION,
            self::STATUS_ACTIVE,
            self::STATUS_DISABLED
    ];

    public const ENTITY_STATUSES = [
            self::STATUS_NOT_CHECKED,
            self::STATUS_ON_VERIFICATION,
            self::STATUS_VERIFIED,
            self::STATUS_REJECTED
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
            'email',
            'first_name',
            'last_name',
            'patronymic',
            'phone',
            'address',
            'password',
            'status',
            'entity',
            'entity_status',
            'entity_name',
            'itn',
            'psrn',
            'entity_address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
            'password',
            'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
            'entity' => 'boolean',
    ];

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->currentAccessToken()->delete();
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value): void
    {
        if (!is_null($value)) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    /**
     * check if user is not verified
     *
     * User has created account but not confirmed it
     *
     * @return bool
     */
    public function isNotVerified(): bool
    {
        return $this->status === self::STATUS_EMAIL_VERIFICATION;
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', [
                self::STATUS_ACTIVE,
                self::STATUS_EMAIL_VERIFICATION
        ]);
    }

    /**
     * User email verifications
     *
     * @return HasMany
     */
    public function emailVerifications(): HasMany
    {
        return $this->hasMany(EmailVerification::class);
    }

    /**
     * User password recoveries
     *
     * @return HasMany
     */
    public function passwordRecoveries(): HasMany
    {
        return $this->hasMany(PasswordRecovery::class);
    }

    /**
     * Send email verify notification
     */
    public function notifyByEmailVerification(EmailVerification $emailVerification): void
    {
        logger(999);
        $this->notify(new VerifyEmail($emailVerification));
    }

    /**
     * Send password recovery notification
     */
    public function notifyByPasswordRecovery(PasswordRecovery $passwordRecovery): void
    {
        $this->notify(new PasswordRecoveryNotification($passwordRecovery));
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->status === self::STATUS_DISABLED;
    }

}

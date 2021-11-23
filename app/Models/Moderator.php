<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;


/**
 * App\Models\Moderator
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $patronymic
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $type
 * @property bool $isAdmin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 */
class Moderator extends Model
{
    use HasFactory;
    use HasApiTokens;

    public const TYPE_ADMIN = 'admin',
            TYPE_MODERATOR = 'moderator';

    public const TYPES = [
            self::TYPE_ADMIN,
            self::TYPE_MODERATOR
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
            'first_name',
            'last_name',
            'patronymic',
            'email',
            'phone',
            'type',
            'password',
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
            'id' => 'integer',
    ];

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->type === self::TYPE_ADMIN;
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
     * @return void
     */
    public function logout(): void
    {
        $this->currentAccessToken()->delete();
    }
}

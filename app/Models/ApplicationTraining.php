<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ApplicationTraining
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $training_id
 * @property string $user_name
 * @property string $email
 * @property string $phone
 * @property string|null $message
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Training $training
 * @property-read User|null $user
 * @mixin Eloquent
 */
class ApplicationTraining extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending',
            STATUS_APPROVED = 'approved',
            STATUS_REJECTED = 'rejected';

    public const STATUSES = [
            self::STATUS_PENDING,
            self::STATUS_APPROVED,
            self::STATUS_REJECTED
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
            'user_id',
            'training_id',
            'user_name',
            'email',
            'phone',
            'message',
            'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
            'id' => 'integer',
            'user_id' => 'integer',
            'training_id' => 'integer',
    ];

    /**
     * @return BelongsTo
     */
    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

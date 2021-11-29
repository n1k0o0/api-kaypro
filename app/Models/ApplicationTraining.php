<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

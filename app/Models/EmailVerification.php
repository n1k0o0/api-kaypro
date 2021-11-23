<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Date;

/**
 * App\Models\EmailVerification
 * @property int $id
 * @property int user_id
 * @property string email
 * @property date sent_at
 * @property int verification_code
 * @property bool markAsRecovered
 * @property Collection user
 */
class EmailVerification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'user_id',
            'email',
            'verification_code'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
            'user_id' => 'integer',
            'verification_code' => 'integer',
            'sent_at' => 'datetime',
            'verified_at' => 'datetime'
    ];

    /**
     * User relation
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark this verification as verified
     *
     * @return bool
     */
    public function markAsVerified(): bool
    {
        return $this->forceFill([
                'verified_at' => $this->freshTimestamp(),
        ])->save();
    }
}

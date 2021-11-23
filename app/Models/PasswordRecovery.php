<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Date;


/**
 * @property int $id
 * @property int user_id
 * @property int verification_code
 * @property date sent_at
 * @property bool markAsRecovered
 * @property Collection user
 */
class PasswordRecovery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'user_id',
            'verification_code'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
            'user_id' => 'integer',
            'verification_code' => 'integer'
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
     * Mark this recovery as recovered
     *
     * @return bool
     */
    public function markAsRecovered(): bool
    {
        return $this->forceFill([
                'recovered_at' => $this->freshTimestamp(),
        ])->save();
    }
}

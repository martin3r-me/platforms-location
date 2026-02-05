<?php

namespace Platform\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Platform\ActivityLog\Traits\LogsActivity;
use Symfony\Component\Uid\UuidV7;

/**
 * Pricing Board - Mietpreise fuer eine Location
 */
class LocationPricing extends Model
{
    use LogsActivity, SoftDeletes;

    protected $table = 'location_pricings';

    protected $fillable = [
        'uuid',
        'location_id',
        'name',
        'description',
        'order',
        'mietpreis_aufbautag',
        'mietpreis_abbautag',
        'mietpreis_va_tag',
        'valid_from',
        'valid_to',
        'is_active',
        'done',
        'done_at',
        'user_id',
        'team_id',
    ];

    protected $casts = [
        'uuid' => 'string',
        'mietpreis_aufbautag' => 'decimal:2',
        'mietpreis_abbautag' => 'decimal:2',
        'mietpreis_va_tag' => 'decimal:2',
        'valid_from' => 'date',
        'valid_to' => 'date',
        'is_active' => 'boolean',
        'done' => 'boolean',
        'done_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->uuid)) {
                do {
                    $uuid = UuidV7::generate();
                } while (self::where('uuid', $uuid)->exists());

                $model->uuid = $uuid;
            }

            if (empty($model->order)) {
                $model->order = static::where('location_id', $model->location_id)->max('order') + 1;
            }
        });
    }

    /**
     * Location
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(LocationLocation::class, 'location_id');
    }

    /**
     * Benutzer
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\Platform\Core\Models\User::class);
    }

    /**
     * Team
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(\Platform\Core\Models\Team::class);
    }

    /**
     * Meta Boards die dieses Pricing Board verwenden
     */
    public function metaBoards(): HasMany
    {
        return $this->hasMany(LocationMetaBoard::class, 'pricing_id');
    }

    /**
     * Scopes
     */
    public function scopeForTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

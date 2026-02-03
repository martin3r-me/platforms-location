<?php

namespace Platform\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\Uid\UuidV7;

/**
 * Gallery Board - Bildergalerie für eine Location
 */
class LocationGalleryBoard extends Model
{
    protected $table = 'location_gallery_boards';

    protected $fillable = [
        'uuid',
        'location_id',
        'name',
        'description',
        'order',
        'user_id',
        'team_id',
        'done',
        'done_at',
    ];

    protected $casts = [
        'uuid' => 'string',
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
     * Items in dieser Gallery
     */
    public function items(): HasMany
    {
        return $this->hasMany(LocationGalleryBoardItem::class, 'gallery_board_id')->orderBy('order');
    }
}

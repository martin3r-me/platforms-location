<?php

namespace Platform\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Symfony\Component\Uid\UuidV7;

/**
 * Gallery Board Item - Einzelnes Item in einer Gallery
 */
class LocationGalleryBoardItem extends Model
{
    protected $table = 'location_gallery_board_items';

    protected $fillable = [
        'uuid',
        'gallery_board_id',
        'title',
        'description',
        'order',
        'media_type',
        'media_id',
        'user_id',
        'team_id',
    ];

    protected $casts = [
        'uuid' => 'string',
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
                $model->order = static::where('gallery_board_id', $model->gallery_board_id)->max('order') + 1;
            }
        });
    }

    /**
     * Gallery Board
     */
    public function galleryBoard(): BelongsTo
    {
        return $this->belongsTo(LocationGalleryBoard::class, 'gallery_board_id');
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
     * Polymorphic Media (für Spatie Media Library etc.)
     */
    public function media(): MorphTo
    {
        return $this->morphTo('media');
    }
}

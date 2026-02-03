<?php

namespace Platform\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Symfony\Component\Uid\UuidV7;

/**
 * Content Board Block - Polymorphischer Content-Container
 * Kann verschiedene Content-Typen enthalten (Text, Bilder, etc.)
 */
class LocationContentBoardBlock extends Model
{
    protected $table = 'location_content_board_blocks';

    protected $fillable = [
        'uuid',
        'row_id',
        'name',
        'description',
        'order',
        'span',
        'content_type',
        'content_id',
        'user_id',
        'team_id',
    ];

    protected $casts = [
        'uuid' => 'string',
        'span' => 'integer',
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
                $model->order = static::where('row_id', $model->row_id)->max('order') + 1;
            }

            if (empty($model->span)) {
                $model->span = 12;
            }
        });
    }

    /**
     * Row
     */
    public function row(): BelongsTo
    {
        return $this->belongsTo(LocationContentBoardRow::class, 'row_id');
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
     * Polymorphic Content (Text, Bild, etc.)
     */
    public function content(): MorphTo
    {
        return $this->morphTo('content');
    }
}

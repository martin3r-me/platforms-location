<?php

namespace Platform\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Symfony\Component\Uid\UuidV7;

/**
 * Content Board Block Text - Text-Content für Blocks
 */
class LocationContentBoardBlockText extends Model
{
    protected $table = 'location_content_board_block_texts';

    protected $fillable = [
        'uuid',
        'content',
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
        });
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
     * Block, zu dem dieser Text gehört
     */
    public function block(): MorphOne
    {
        return $this->morphOne(LocationContentBoardBlock::class, 'content');
    }
}

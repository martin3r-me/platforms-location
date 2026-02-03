<?php

namespace Platform\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\Uid\UuidV7;

/**
 * Content Board Row - Grid-Zeile innerhalb einer Section
 */
class LocationContentBoardRow extends Model
{
    protected $table = 'location_content_board_rows';

    protected $fillable = [
        'uuid',
        'section_id',
        'name',
        'description',
        'order',
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
                $model->order = static::where('section_id', $model->section_id)->max('order') + 1;
            }
        });
    }

    /**
     * Section
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(LocationContentBoardSection::class, 'section_id');
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
     * Blocks dieser Row
     */
    public function blocks(): HasMany
    {
        return $this->hasMany(LocationContentBoardBlock::class, 'row_id')->orderBy('order');
    }
}

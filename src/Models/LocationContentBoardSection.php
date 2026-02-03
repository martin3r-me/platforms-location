<?php

namespace Platform\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\Uid\UuidV7;

/**
 * Content Board Section - Organisiert Content in Sektionen
 */
class LocationContentBoardSection extends Model
{
    protected $table = 'location_content_board_sections';

    protected $fillable = [
        'uuid',
        'content_board_id',
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
                $model->order = static::where('content_board_id', $model->content_board_id)->max('order') + 1;
            }
        });
    }

    /**
     * Content Board
     */
    public function contentBoard(): BelongsTo
    {
        return $this->belongsTo(LocationContentBoard::class, 'content_board_id');
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
     * Rows dieser Section
     */
    public function rows(): HasMany
    {
        return $this->hasMany(LocationContentBoardRow::class, 'section_id')->orderBy('order');
    }
}

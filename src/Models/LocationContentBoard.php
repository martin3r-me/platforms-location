<?php

namespace Platform\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\Uid\UuidV7;

/**
 * Content Board - Gehört zu einer Location
 * Enthält Sections mit Rows und Blocks.
 */
class LocationContentBoard extends Model
{
    protected $table = 'location_content_boards';

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
     * Location, zu der dieses Content Board gehört
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
     * Sections dieses Content Boards
     */
    public function sections(): HasMany
    {
        return $this->hasMany(LocationContentBoardSection::class, 'content_board_id')->orderBy('order');
    }

    /**
     * Items dieses Content Boards (vereinfachte Struktur)
     */
    public function items(): HasMany
    {
        return $this->hasMany(LocationContentBoardItem::class, 'content_board_id')->orderBy('order');
    }
}

<?php

namespace Platform\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Platform\ActivityLog\Traits\LogsActivity;
use Platform\Core\Contracts\HasFileContext;
use Symfony\Component\Uid\UuidV7;

/**
 * Location - Simple child entity belonging to a Site
 * Has Content Boards and Gallery Boards.
 */
class LocationLocation extends Model implements HasFileContext
{
    use LogsActivity, SoftDeletes;

    protected $table = 'location_locations';

    protected $fillable = [
        'uuid',
        'site_id',
        'name',
        'description',
        'order',
        // User/Team
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
                $model->order = static::where('site_id', $model->site_id)->max('order') + 1;
            }
        });
    }

    /**
     * Site this location belongs to
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(LocationSite::class, 'site_id');
    }

    /**
     * User who created the location
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\Platform\Core\Models\User::class);
    }

    /**
     * Team that owns the location
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(\Platform\Core\Models\Team::class);
    }

    /**
     * Content Boards of this location
     */
    public function contentBoards(): HasMany
    {
        return $this->hasMany(LocationContentBoard::class, 'location_id')->orderBy('order');
    }

    /**
     * Gallery Boards of this location
     */
    public function galleryBoards(): HasMany
    {
        return $this->hasMany(LocationGalleryBoard::class, 'location_id')->orderBy('order');
    }

    /**
     * Meta Boards of this location
     */
    public function metaBoards(): HasMany
    {
        return $this->hasMany(LocationMetaBoard::class, 'location_id')->orderBy('order');
    }

    /**
     * Pricing Boards of this location
     */
    public function pricingBoards(): HasMany
    {
        return $this->hasMany(LocationPricing::class, 'location_id')->orderBy('order');
    }

    /**
     * Scopes
     */
    public function scopeForTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }

    public function scopeForSite($query, $siteId)
    {
        return $query->where('site_id', $siteId);
    }

    public function scopeDone($query)
    {
        return $query->where('done', true);
    }

    public function scopeNotDone($query)
    {
        return $query->where('done', false);
    }

    /**
     * Der Kontext-Typ für Dateien (zeigt auf sich selbst)
     */
    public function getFileContextType(): string
    {
        return self::class;
    }

    /**
     * Die Kontext-ID für Dateien
     */
    public function getFileContextId(): int
    {
        return $this->id;
    }
}

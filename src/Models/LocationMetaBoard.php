<?php

namespace Platform\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Symfony\Component\Uid\UuidV7;

/**
 * Meta Board - Metadaten-Board fuer eine Location
 */
class LocationMetaBoard extends Model
{
    protected $table = 'location_meta_boards';

    protected $fillable = [
        'uuid',
        'location_id',
        'name',
        'description',
        'order',
        'flaeche_m2',
        'mietpreis_aufbautag',
        'mietpreis_abbautag',
        'mietpreis_va_tag',
        'adresse',
        'hallennummer',
        'personenauslastung_max',
        'besonderheit',
        'barrierefreiheit',
        'user_id',
        'team_id',
        'done',
        'done_at',
    ];

    protected $casts = [
        'uuid' => 'string',
        'flaeche_m2' => 'decimal:2',
        'mietpreis_aufbautag' => 'decimal:2',
        'mietpreis_abbautag' => 'decimal:2',
        'mietpreis_va_tag' => 'decimal:2',
        'personenauslastung_max' => 'integer',
        'barrierefreiheit' => 'boolean',
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
     * Anlaesse (n:m ueber Pivot-Tabelle)
     */
    public function occasions(): BelongsToMany
    {
        return $this->belongsToMany(
            LocationOccasion::class,
            'location_meta_board_occasion',
            'meta_board_id',
            'occasion_id'
        )->withTimestamps();
    }

    /**
     * Bestuhlungen (n:m ueber Pivot-Tabelle mit max_pax)
     */
    public function seatings(): BelongsToMany
    {
        return $this->belongsToMany(
            LocationSeating::class,
            'location_meta_board_seating',
            'meta_board_id',
            'seating_id'
        )->withPivot('max_pax')->withTimestamps();
    }
}

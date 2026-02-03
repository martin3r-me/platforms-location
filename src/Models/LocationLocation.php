<?php

namespace Platform\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Platform\ActivityLog\Traits\LogsActivity;
use Symfony\Component\Uid\UuidV7;

/**
 * Location - Gehört zu einem Standort
 * Hat Adressdaten, Content Boards und Gallery Boards.
 */
class LocationLocation extends Model
{
    use LogsActivity, SoftDeletes;

    protected $table = 'location_locations';

    protected $fillable = [
        'uuid',
        'standort_id',
        'name',
        'description',
        'order',
        // Adresse
        'street',
        'street_number',
        'postal_code',
        'city',
        'state',
        'country',
        'country_code',
        // GPS
        'latitude',
        'longitude',
        // International
        'is_international',
        'timezone',
        // Kontakt
        'phone',
        'email',
        'website',
        'notes',
        // User/Team
        'user_id',
        'team_id',
        'done',
        'done_at',
    ];

    protected $casts = [
        'uuid' => 'string',
        'is_international' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
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
                $model->order = static::where('standort_id', $model->standort_id)->max('order') + 1;
            }
        });
    }

    /**
     * Standort, zu dem diese Location gehört
     */
    public function standort(): BelongsTo
    {
        return $this->belongsTo(LocationStandort::class, 'standort_id');
    }

    /**
     * Benutzer, der die Location erstellt hat
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\Platform\Core\Models\User::class);
    }

    /**
     * Team, dem die Location gehört
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(\Platform\Core\Models\Team::class);
    }

    /**
     * Content Boards dieser Location
     */
    public function contentBoards(): HasMany
    {
        return $this->hasMany(LocationContentBoard::class, 'location_id')->orderBy('order');
    }

    /**
     * Gallery Boards dieser Location
     */
    public function galleryBoards(): HasMany
    {
        return $this->hasMany(LocationGalleryBoard::class, 'location_id')->orderBy('order');
    }

    /**
     * Vollständige Adresse als String
     */
    public function getFullAddressAttribute(): string
    {
        $parts = [];

        if ($this->street) {
            $street = $this->street;
            if ($this->street_number) {
                $street .= ' ' . $this->street_number;
            }
            $parts[] = $street;
        }

        if ($this->postal_code || $this->city) {
            $city = trim(($this->postal_code ?? '') . ' ' . ($this->city ?? ''));
            if ($city) {
                $parts[] = $city;
            }
        }

        if ($this->state) {
            $parts[] = $this->state;
        }

        if ($this->country) {
            $parts[] = $this->country;
        }

        return implode(', ', $parts);
    }

    /**
     * GPS-Koordinaten als Array
     */
    public function getGpsCoordinatesAttribute(): ?array
    {
        if ($this->latitude && $this->longitude) {
            return [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude,
            ];
        }

        return null;
    }

    /**
     * Scopes
     */
    public function scopeForTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }

    public function scopeForStandort($query, $standortId)
    {
        return $query->where('standort_id', $standortId);
    }

    public function scopeInternational($query)
    {
        return $query->where('is_international', true);
    }

    public function scopeNational($query)
    {
        return $query->where('is_international', false);
    }

    public function scopeWithGps($query)
    {
        return $query->whereNotNull('latitude')->whereNotNull('longitude');
    }

    public function scopeDone($query)
    {
        return $query->where('done', true);
    }

    public function scopeNotDone($query)
    {
        return $query->where('done', false);
    }
}

<?php

namespace Platform\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Platform\ActivityLog\Traits\LogsActivity;
use Symfony\Component\Uid\UuidV7;

/**
 * Site - Parent entity with detailed data (address, GPS, contact)
 * Locations belong to a Site.
 */
class LocationSite extends Model
{
    use LogsActivity, SoftDeletes;

    protected $table = 'location_sites';

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'order',
        // Address
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
        // Contact
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
                $model->order = static::where('team_id', $model->team_id)->max('order') + 1;
            }
        });
    }

    /**
     * User who created the site
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\Platform\Core\Models\User::class);
    }

    /**
     * Team that owns the site
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(\Platform\Core\Models\Team::class);
    }

    /**
     * All locations of this site
     */
    public function locations(): HasMany
    {
        return $this->hasMany(LocationLocation::class, 'site_id')->orderBy('order');
    }

    /**
     * Full address as string
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
     * GPS coordinates as array
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

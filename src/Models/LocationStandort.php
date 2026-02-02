<?php

namespace Platform\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Platform\ActivityLog\Traits\LogsActivity;
use Symfony\Component\Uid\UuidV7;

class LocationStandort extends Model
{
    use LogsActivity;
    
    protected $table = 'location_standorte';
    
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'location_id', // FK zu LocationLocation
        // Adresse
        'street',
        'street_number',
        'postal_code',
        'city',
        'state',
        'country',
        'country_code', // ISO 3166-1 alpha-2 (z.B. DE, US, FR)
        // GPS-Koordinaten
        'latitude',
        'longitude',
        // International
        'is_international',
        'timezone',
        // Zusätzliche Felder
        'phone',
        'email',
        'website',
        'notes',
        // User/Team-Kontext
        'created_by_user_id',
        'owned_by_user_id',
        'team_id',
        'is_active',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'is_international' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
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
     * Beziehungen
     */
    public function createdByUser()
    {
        return $this->belongsTo(\Platform\Core\Models\User::class, 'created_by_user_id');
    }
    
    public function ownedByUser()
    {
        return $this->belongsTo(\Platform\Core\Models\User::class, 'owned_by_user_id');
    }
    
    public function team()
    {
        return $this->belongsTo(\Platform\Core\Models\Team::class, 'team_id');
    }
    
    public function location()
    {
        return $this->belongsTo(LocationLocation::class, 'location_id');
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
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
    
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
}

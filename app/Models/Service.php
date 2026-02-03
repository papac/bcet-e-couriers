<?php

namespace App\Models;

use Bow\Database\Barry\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $address
 * @property string $city
 * @property string $phone
 * @property string $email
 * @property int $chief_id
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 */
class Service extends Model
{
    /**
     * The table name
     *
     * @var string
     */
    protected string $table = 'services';

    /**
     * The fillable fields
     *
     * @var array
     */
    protected array $fillable = [
        'name',
        'code',
        'address',
        'city',
        'phone',
        'email',
        'chief_id',
        'is_active'
    ];

    /**
     * Get the chief/manager of this service
     *
     * @return \Bow\Database\Barry\Relations\BelongsTo
     */
    public function chief()
    {
        return $this->belongsTo(User::class, 'chief_id');
    }

    /**
     * Get agents assigned to this service
     *
     * @return \Bow\Database\Barry\Relations\HasMany
     */
    public function agents()
    {
        return $this->hasMany(User::class, 'service_id');
    }

    /**
     * Get couriers originating from this service
     *
     * @return \Bow\Database\Barry\Relations\HasMany
     */
    public function originCouriers()
    {
        return $this->hasMany(Courier::class, 'origin_service_id');
    }

    /**
     * Get couriers destined for this service
     *
     * @return \Bow\Database\Barry\Relations\HasMany
     */
    public function destinationCouriers()
    {
        return $this->hasMany(Courier::class, 'destination_service_id');
    }

    /**
     * Get couriers currently at this service
     *
     * @return \Bow\Database\Barry\Relations\HasMany
     */
    public function currentCouriers()
    {
        return $this->hasMany(Courier::class, 'current_service_id');
    }

    /**
     * Get active services
     *
     * @return \Bow\Database\Barry\Builder
     */
    public static function active()
    {
        return self::where('is_active', true);
    }

    /**
     * Generate unique service code
     *
     * @param string $name
     * @return string
     */
    public static function generateCode(string $name): string
    {
        $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $name), 0, 3));
        $random = strtoupper(substr(md5(uniqid()), 0, 4));

        return $prefix . '-' . $random;
    }

    /**
     * Get full display name with city
     *
     * @return string
     */
    public function getFullName(): string
    {
        return $this->city ? "{$this->name} ({$this->city})" : $this->name;
    }
}

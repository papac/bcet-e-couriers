<?php

namespace App\Models;

use Bow\Database\Barry\Model;

/**
 * @property int $id
 * @property string $tracking_number
 * @property string $sender_name
 * @property string $sender_phone
 * @property string $sender_address
 * @property string $receiver_name
 * @property string $receiver_phone
 * @property string $receiver_address
 * @property string $description
 * @property float $weight
 * @property float $price
 * @property string $status
 * @property int $agent_id
 * @property string $notes
 * @property string $created_at
 * @property string $updated_at
 */
class Courier extends Model
{
    /**
     * The table name
     *
     * @var string
     */
    protected string $table = 'couriers';

    /**
     * The fillable fields
     *
     * @var array
     */
    protected array $fillable = [
        'tracking_number',
        'sender_name',
        'sender_phone',
        'sender_address',
        'receiver_name',
        'receiver_phone',
        'receiver_address',
        'description',
        'weight',
        'price',
        'status',
        'agent_id',
        'notes'
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_RECEIVED = 'received';
    const STATUS_IN_TRANSIT = 'in_transit';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_RETURNED = 'returned';

    /**
     * Get all status options
     *
     * @return array
     */
    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'En attente',
            self::STATUS_RECEIVED => 'Reçu',
            self::STATUS_IN_TRANSIT => 'En transit',
            self::STATUS_DELIVERED => 'Livré',
            self::STATUS_RETURNED => 'Retourné'
        ];
    }

    /**
     * Generate unique tracking number
     *
     * @return string
     */
    public static function generateTrackingNumber(): string
    {
        $prefix = 'BCT';
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        
        return "{$prefix}-{$date}-{$random}";
    }

    /**
     * Get the agent that created this courier
     *
     * @return \Bow\Database\Barry\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Get status history
     *
     * @return \Bow\Database\Barry\Relations\HasMany
     */
    public function statusHistory()
    {
        return $this->hasMany(CourierStatusHistory::class, 'courier_id');
    }

    /**
     * Get formatted status label
     *
     * @return string
     */
    public function getStatusLabel(): string
    {
        return self::getStatusOptions()[$this->status] ?? $this->status;
    }

    /**
     * Get status color for UI
     *
     * @return string
     */
    public function getStatusColor(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_RECEIVED => 'blue',
            self::STATUS_IN_TRANSIT => 'purple',
            self::STATUS_DELIVERED => 'green',
            self::STATUS_RETURNED => 'red',
            default => 'gray'
        };
    }
}

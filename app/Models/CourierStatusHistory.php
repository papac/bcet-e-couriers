<?php

namespace App\Models;

use Bow\Database\Barry\Model;

/**
 * @property int $id
 * @property int $courier_id
 * @property int $changed_by
 * @property string $old_status
 * @property string $new_status
 * @property string $comment
 * @property string $created_at
 * @property string $updated_at
 */
class CourierStatusHistory extends Model
{
    /**
     * The table name
     *
     * @var string
     */
    protected string $table = 'courier_status_history';

    /**
     * The fillable fields
     *
     * @var array
     */
    protected array $fillable = [
        'courier_id',
        'changed_by',
        'old_status',
        'new_status',
        'comment'
    ];

    /**
     * Get the courier
     *
     * @return \Bow\Database\Barry\Relations\BelongsTo
     */
    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id');
    }

    /**
     * Get the user who changed the status
     *
     * @return \Bow\Database\Barry\Relations\BelongsTo
     */
    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}

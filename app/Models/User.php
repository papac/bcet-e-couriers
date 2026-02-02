<?php

namespace App\Models;

use Bow\Auth\Authentication as AuthenticationModel;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $role
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 */
class User extends AuthenticationModel
{
    /**
     * The table name
     *
     * @var string
     */
    protected string $table = 'users';

    /**
     * The list of hidden field when toJson is called
     *
     * @var array
     */
    protected array $hidden = [
        'password'
    ];

    /**
     * The fillable fields
     *
     * @var array
     */
    protected array $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active'
    ];

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is agent
     *
     * @return bool
     */
    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    /**
     * Get couriers created by this agent
     *
     * @return \Bow\Database\Barry\Relations\HasMany
     */
    public function couriers()
    {
        return $this->hasMany(Courier::class, 'agent_id');
    }
}

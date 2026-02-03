<?php

namespace App\Models;

use App\Enums\AppAccess;
use Bow\Auth\Authentication as AuthenticationModel;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $role
 * @property bool $is_active
 * @property string $app_access
 * @property int|null $service_id
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
        'is_active',
        'service_id',
        'app_access'
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
     * Check if user has access to a specific app
     *
     * @param AppAccess|string $app
     * @return bool
     */
    public function hasAppAccess(AppAccess|string $app): bool
    {
        if ($this->isAdmin()) {
            return true; // Admin has access to all apps
        }

        $appValue = $app instanceof AppAccess ? $app->value : $app;
        $apps = $this->getAppAccessList();
        return in_array($appValue, $apps);
    }

    /**
     * Check if user has access to courier app
     *
     * @return bool
     */
    public function hasCourierAccess(): bool
    {
        return $this->hasAppAccess(AppAccess::COURRIER);
    }

    /**
     * Get the list of apps the user has access to
     *
     * @return array
     */
    public function getAppAccessList(): array
    {
        // Admin has access to all apps
        if ($this->isAdmin()) {
            return AppAccess::values();
        }

        if (empty($this->app_access)) {
            return [];
        }

        return array_map('trim', explode(',', $this->app_access));
    }

    /**
     * Set app access from array
     *
     * @param array $apps
     * @return void
     */
    public function setAppAccessFromArray(array $apps): void
    {
        $this->app_access = implode(',', array_filter($apps));
    }

    /**
     * Get available apps list
     *
     * @return array
     */
    public static function getAvailableApps(): array
    {
        return AppAccess::toArray();
    }

    /**
     * Get the service this user belongs to
     *
     * @return \Bow\Database\Barry\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
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

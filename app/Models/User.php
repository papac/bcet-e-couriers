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
 * @property string $app_access
 * @property int|null $service_id
 * @property string $created_at
 * @property string $updated_at
 */
class User extends AuthenticationModel
{
    /**
     * Available applications
     */
    public const APP_COURRIER = 'courrier';
    public const APP_E_RECOUVREMENT = 'e_recouvrement';
    public const APP_OTHER = 'other';

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
     * @param string $app
     * @return bool
     */
    public function hasAppAccess(string $app): bool
    {
        if ($this->isAdmin()) {
            return true; // Admin has access to all apps
        }

        $apps = $this->getAppAccessList();
        return in_array($app, $apps);
    }

    /**
     * Check if user has access to courier app
     *
     * @return bool
     */
    public function hasCourierAccess(): bool
    {
        return $this->hasAppAccess(self::APP_COURRIER);
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
            return array_keys(self::getAvailableApps());
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
        return [
            self::APP_COURRIER => 'Courrier',
            self::APP_E_RECOUVREMENT => 'E-Recouvrement',
            self::APP_OTHER => 'Autre Application',
        ];
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

<?php

namespace App\Enums;

enum AppAccess: string
{
    case COURIERS = 'couriers';
    case RECOVERIES = 'recoveries';

    /**
     * Get the label for the app
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::COURIERS => 'Courrier',
            self::RECOVERIES => 'Recouvrement',
        };
    }

    /**
     * Get all available apps as key-value array
     *
     * @return array<string, string>
     */
    public static function toArray(): array
    {
        $apps = [];
        foreach (self::cases() as $case) {
            $apps[$case->value] = $case->label();
        }
        return $apps;
    }

    /**
     * Get all app values
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

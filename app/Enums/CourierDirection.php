<?php

namespace App\Enums;

enum CourierDirection: string
{
    case INCOMING = 'incoming';  // Réception de courrier
    case OUTGOING = 'outgoing';  // Départ de courrier

    /**
     * Get the label for the direction
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::INCOMING => 'Réception',
            self::OUTGOING => 'Départ',
        };
    }

    /**
     * Get the full description
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::INCOMING => 'Réception de courrier',
            self::OUTGOING => 'Départ de courrier',
        };
    }

    /**
     * Get the color class for UI
     *
     * @return string
     */
    public function colorClass(): string
    {
        return match ($this) {
            self::INCOMING => 'bg-green-100 text-green-800',
            self::OUTGOING => 'bg-blue-100 text-blue-800',
        };
    }

    /**
     * Get the icon name
     *
     * @return string
     */
    public function icon(): string
    {
        return match ($this) {
            self::INCOMING => 'arrow-down',
            self::OUTGOING => 'arrow-up',
        };
    }

    /**
     * Get all directions as key-value array
     *
     * @return array<string, string>
     */
    public static function toArray(): array
    {
        $directions = [];
        foreach (self::cases() as $case) {
            $directions[$case->value] = $case->label();
        }
        return $directions;
    }

    /**
     * Get all direction values
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

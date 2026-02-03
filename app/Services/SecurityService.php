<?php

namespace App\Services;

/**
 * Security Service for input sanitization and validation
 */
class SecurityService
{
    /**
     * Sanitize string input
     *
     * @param string|null $input
     * @return string
     */
    public static function sanitizeString(?string $input): string
    {
        if ($input === null) {
            return '';
        }

        // Remove null bytes
        $input = str_replace(chr(0), '', $input);

        // Strip HTML tags
        $input = strip_tags($input);

        // Convert special characters to HTML entities
        $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Trim whitespace
        return trim($input);
    }

    /**
     * Sanitize email
     *
     * @param string|null $email
     * @return string
     */
    public static function sanitizeEmail(?string $email): string
    {
        if ($email === null) {
            return '';
        }

        $email = trim(strtolower($email));
        return filter_var($email, FILTER_SANITIZE_EMAIL) ?: '';
    }

    /**
     * Sanitize phone number
     *
     * @param string|null $phone
     * @return string
     */
    public static function sanitizePhone(?string $phone): string
    {
        if ($phone === null) {
            return '';
        }

        // Keep only digits, plus sign, and spaces
        return preg_replace('/[^0-9+\s\-]/', '', $phone);
    }

    /**
     * Sanitize integer
     *
     * @param mixed $input
     * @return int
     */
    public static function sanitizeInt($input): int
    {
        return (int) filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Sanitize float
     *
     * @param mixed $input
     * @return float
     */
    public static function sanitizeFloat($input): float
    {
        return (float) filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    /**
     * Validate and sanitize tracking number
     *
     * @param string|null $tracking
     * @return string
     */
    public static function sanitizeTrackingNumber(?string $tracking): string
    {
        if ($tracking === null) {
            return '';
        }

        // Allow only alphanumeric and dashes
        return preg_replace('/[^A-Za-z0-9\-]/', '', strtoupper(trim($tracking)));
    }

    /**
     * Generate secure random token
     *
     * @param int $length
     * @return string
     */
    public static function generateSecureToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * Validate status against allowed values
     *
     * @param string $status
     * @param array $allowedStatuses
     * @return bool
     */
    public static function validateStatus(string $status, array $allowedStatuses): bool
    {
        return in_array($status, $allowedStatuses, true);
    }

    /**
     * Escape output for HTML display
     *
     * @param string|null $output
     * @return string
     */
    public static function escapeHtml(?string $output): string
    {
        if ($output === null) {
            return '';
        }

        return htmlspecialchars($output, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

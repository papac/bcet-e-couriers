<?php

namespace App\Configurations;

use Bow\Configuration\Loader;
use Bow\Configuration\Configuration;

class ApplicationConfiguration extends Configuration
{
    /**
     * Launch configuration
     *
     * @param  Loader $config
     * @return void
     */
    public function create(Loader $config): void
    {
        // Set security headers globally
        $this->setSecurityHeaders();
    }

    /**
     * Start the configured package
     *
     * @return void
     */
    public function run(): void
    {
        //
    }

    /**
     * Set security headers for all responses
     *
     * @return void
     */
    protected function setSecurityHeaders(): void
    {
        // Prevent MIME type sniffing
        header('X-Content-Type-Options: nosniff');

        // Enable XSS protection
        header('X-XSS-Protection: 1; mode=block');

        // Prevent clickjacking
        header('X-Frame-Options: SAMEORIGIN');

        // Referrer Policy
        header('Referrer-Policy: strict-origin-when-cross-origin');

        // Permissions Policy
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    }
}

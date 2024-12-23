<?php

namespace App\Traits;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Auth\Authenticatable;

trait AuthenticatesPartners
{
    use Authenticatable;

    /**
     * Get the unique identifier for the user.
     */
    public function getAuthIdentifierName()
    {
        return 'EMAIL'; // Customize this to match your needs (e.g., 'REGISTRATION_NUMBER' if needed).
    }

    /**
     * Get the password for the user.
     */
    public function getAuthPassword()
    {
        return $this->PASSWORD; // The actual hashed password field from your partners table.
    }
}

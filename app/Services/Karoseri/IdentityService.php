<?php

namespace App\Services\Karoseri;

use App\Models\Karoseri\Identity;

class IdentityService
{
    public function createIdentity(array $data)
    {
        // Create a new Identity record with the provided data
        return Identity::create($data);
    }
}
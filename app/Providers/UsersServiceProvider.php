<?php
// app/Providers/UsersServiceProvider.php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Auth;

class UsersServiceProvider extends EloquentUserProvider
{
    
}
?>
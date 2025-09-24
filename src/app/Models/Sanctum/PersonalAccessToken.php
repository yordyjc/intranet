<?php

namespace App\Models\Sanctum;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    // Extend or customize the Sanctum PersonalAccessToken model here
    protected $table = 'personal_access_tokens';
    protected $guarded = [];
}

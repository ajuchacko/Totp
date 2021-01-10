<?php

namespace Ajuchacko\Totp\Tests\Models;

use Ajuchacko\Totp\Traits\TwoFactorAuthenticatable;

class User extends \Illuminate\Foundation\Auth\User
{
    use TwoFactorAuthenticatable;

    protected $fillable = ['uri'];
}

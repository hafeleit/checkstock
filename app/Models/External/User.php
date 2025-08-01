<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    protected $connection = "external_mysql";
    protected $table = "users";
    protected $fillable = [
        "username",
        "email",
        "email_verified_at",
        "password",
        "first_name",
        "last_name",
        "is_active",
        "last_logged_in_at",
        "remember_token",
        "created_at",
        "updated_at",
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_logged_in_at' => 'datetime',
    ];
}

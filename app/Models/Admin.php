<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = "admin";
    protected $fillable = [
        "userName",
        "email",
        "phone",
        "password",
    ];

    protected $hidden = [
        "verify_phone",
    ];

}

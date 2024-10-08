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
        "profile",
        "description",
        "password",
    ];

    protected $hidden = [
        "verify_phone",
        "password"
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}

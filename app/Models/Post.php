<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post';
    protected $fillable = [
        "title",
        "description",
        "photos",
        "slug",
        "categories_id",
        "admin_id",
        "status",
    ];

    protected $hidden = [
        "admin_id",
        "categories_id",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

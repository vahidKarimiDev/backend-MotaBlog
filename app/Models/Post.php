<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = [
        "title",
        "description",
        "photos",
        "slug",
        "category_id",
        "admin_id",
        "status",
        "miniDesc"
    ];

    protected $hidden = [
        "admin_id",
        "categories_id",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}

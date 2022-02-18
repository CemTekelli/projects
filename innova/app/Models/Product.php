<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function specification()
    {
        return $this->hasOne(Specification::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Categories::class);
    }
}

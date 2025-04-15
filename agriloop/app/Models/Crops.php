<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crops extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image'];

    protected $appends = ['image_url']; // 👈 This makes image_url appear in JSON

}

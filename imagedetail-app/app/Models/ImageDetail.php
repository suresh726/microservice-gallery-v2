<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageDetail extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'description', 'views', 'creation_date', 'upload_date', 'tags', 'full_image_url'];
}

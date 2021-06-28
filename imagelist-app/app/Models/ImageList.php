<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageList extends Model
{
    protected $fillable = ['category_id', 'thumbnail_url', 'flickr_image_id'];
}

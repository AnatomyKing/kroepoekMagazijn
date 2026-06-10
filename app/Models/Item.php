<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'description',
        'category',
        'image',
        'quantity_total',
        'quantity_available',
        'status',
        'video_link'
    ];
}

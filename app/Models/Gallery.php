<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image',
        'is_default'
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}

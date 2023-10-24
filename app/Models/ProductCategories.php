<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'products_id',
        'categories_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'products_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'products_id');
    }
}

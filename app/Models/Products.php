<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'published',
        'slug',
        'sale_price',
        'compare_price',
        'description',
        'username',
        'user_phone',
        'location',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(ProductCategories::class, 'product_id');
    }
}

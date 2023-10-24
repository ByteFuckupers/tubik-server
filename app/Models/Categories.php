<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'image',
        'active',
    ];


    public function products(): HasMany
    {
        return $this->hasMany(ProductCategories::class, 'category_id');
    }

    public function category(): HasOne
    {
        return $this->hasOne(self::class, 'category_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(self::class, 'category_id');
    }



    public static function getCategories(): Collection|array
    {
        return self::query()
            ->where('category_id', null,)
            ->with('categories', fn ($query) => $query->where('active', true))
            ->get();
    }
}

<?php

namespace App\Http\Controllers\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\CategoryResource;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function getCategories(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Categories::getCategories());
    }


    public function categoryProduct(Categories $category): AnonymousResourceCollection
    {
        return CategoryResource::collection($category->subcategories);
    }


    public function subcategoryProduct(Categories $subcategory): AnonymousResourceCollection
    {
        return CategoryResource::collection($subcategory->products);
    }
}

<?php

namespace App\Http\Controllers\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Product\Category\CategoryProductRequest;
use App\Http\Resources\Product\CategoryResource;
use App\Models\Categories;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function getCategories(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Categories::getCategories()->get());
    }


    public function categoryProduct(Request $request, string $category)
    {
        return Categories::getCategoryOrFail($category);
    }


    public function subcategoryProduct(Request $request, string $category, string $subcategory)
    {
        return Categories::getCategoryOrFail($category)
            ->getSubcategoryOrFail($subcategory);
    }
}

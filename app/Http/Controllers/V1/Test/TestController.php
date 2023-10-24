<?php

namespace App\Http\Controllers\V1\Test;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\CategoryResource;
use App\Models\Categories;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class TestController extends Controller
{
    public function get()
    {
        return CategoryResource::collection(Categories::getCategories());
    }


    public function post(Request $request)
    {
        return CategoryResource::collection(Categories::getCategories());
    }
}

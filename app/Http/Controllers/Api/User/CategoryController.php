<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\CategoryContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected readonly CategoryContract $category)
    {
        
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $categories = $this->category->getAll();

        return response()->json([
            'records' => CategoryResource::collection($categories),
        ]);
    }
}

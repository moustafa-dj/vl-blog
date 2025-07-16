<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\TagContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function __construct(private readonly TagContract $tag)
    {
        
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $tags = $this->tag->getAll();
        
        return response()->json([
            'records' => TagResource::collection($tags)
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\PostContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;

class PostController extends Controller
{
    
    public function __construct(private readonly PostContract $post)
    {
        
    }

    public function index(Request $request)
    {
        $posts = $this->post->withRelations(['category','tags','comments','user'])
                            ->findWithoutPagination();

        return response()->json([
            'records' => PostResource::collection($posts),
        ]);
    }

    public function myPosts()
    {
        $posts = $this->post->withRelations(['category','tags','comments','user'])
                            ->setScopes(['byUser'=> auth('user-api')->user()->id])
                            ->findByFilter();

        return response()->json([
            'records' => PostResource::collection($posts),
        ]);
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();

        try{

            $post = $this->post->create([
                ...$data,
                'user_id' => auth('user-api')->user()->id,
            ]);

            return response()->json([
                'record' => PostResource::make($post->load('category','tags','comments','user')),
            ]);

        }catch(\Exception $e)
        {
            return response()->json([
                'erros' => $e,
            ]);
        }
    }

    public function show($id)
    {
        $post = $this->post->withRelations(['category','tags','comments','user'])->findById($id);

        return response()->json([
            'record' => PostResource::make($post)
        ]);
    }

    public function update($id,Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string|max:1024',
            'title' => 'required|string|max:256',
            'cover' => 'nullable|file|mimes:png,jpg,jpeg',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'required|exists:tags,id'
        ]);

        try{
            $post = $this->post->update($id , $data);

            return response()->json([
                'record' => PostResource::make($post->load('category','tags','comments','user')),
            ]);
        }catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

    }

    public function destroy($id)
    {
        try{
            $post = $this->post->destroy($id);

            return response()->json([
                'record' => $post,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}

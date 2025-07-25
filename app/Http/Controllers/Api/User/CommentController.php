<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\CommentContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(private readonly CommentContract $comment)
    {
        
    }

    public function index(Request $request)
    {
        $comments = $this->comment->withRelations(['user','post'])
                                  ->setScopes(['byPost'=> $request->input('post_id')])
                                  ->findByFilter();
                                  
        return response()->json([
            'records' => CommentResource::collection($comments),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string|max:1024',
            'post_id' => 'required|exists:posts,id',
        ]);

        $comment = $this->comment->create([
            ...$data,
            'user_id' => auth('user-api')->user()->id,
        ]);

        return response()->json([
            'record' => CommentResource::make($comment->load('user','post')),
        ]);
    }

    public function show($id)
    {
        $comment = $this->comment->withRelations(['user','post'])->findById($id);

        return response()->json([
            'record' => CommentResource::make($comment),
        ]);
    }

    public function update($id,Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string|max:1024',
        ]);
        $post = $this->comment->update($id , $data);

        return response()->json([
            'record' => CommentResource::make($post->load('post','user')),
        ]);
    }
}

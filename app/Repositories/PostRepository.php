<?php

namespace App\Repositories;

use App\Contracts\PostContract;
use App\Models\Post;
use App\Services\FileUploadService;

class PostRepository extends BaseRepository implements PostContract
{
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        $post = $this->model::create($data);

        if(array_key_exists('cover',$data))
        {
            (new FileUploadService())->updloadFile($data['cover'],'/posts/cover',$post);
        }

        if(array_key_exists('tags',$data)){
            foreach($data['tags'] as $tag)
                    $post->tags()->attach($tag);
        }

        return $post;
    }

    public function update($model, $data)
    {
        $post = $model instanceof Post ? $model : $this->findById($model);

        $post->update($data);

        if(array_key_exists('cover',$data))
        {
            (new FileUploadService())->removeFile($post);
            (new FileUploadService())->updloadFile($data['cover'],'/posts/cover',$post);
        }
        
        if(array_key_exists('tags',$data))
        {
            $post->tags()->sync($data['tags']);
        }
        return $post;
    }

}
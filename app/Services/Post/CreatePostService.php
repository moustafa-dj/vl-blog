<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Models\Tag;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;


class CreatePostService {

    public array $data;
    protected Post $post;
    protected array $tags = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function make($data)
    {
        DB::beginTransaction();
        $service = new self($data);
        try{

            $service->createPost();
            $service->extractTags();
            $service->attachTags();
            $service->uploadCover();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return $service->post;
    }

    protected function createPost()
    {
        $this->post = Post::create($this->data);
    }

    protected function extractTags()
    {
        $tags = Tag::all();

        $matched = [];
        foreach($tags as $tag)
        {
            if(str_contains(strtolower($this->post->content) ,strtolower($tag->name))){
                $matched[] = $tag->id;
            }
        }

        $this->tags = $matched;
        
    }

    protected function attachTags()
    {
        $this->post->tags()->attach($this->tags);
    }

    protected function uploadCover()
    {
        if(array_key_exists('cover',$this->data))
        {
            (new FileUploadService())->updloadFile($this->data['cover'],'/posts/cover',$this->post);
        }
    }
}
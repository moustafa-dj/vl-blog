<?php

namespace App\Services;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FileUploadService{


    public function removeFile($model){
        
        if($model->cover != null){

            Storage::delete($model->cover);

            $model->cover = '';

            $model->save();
        }
    }

    public function updloadFile($file ,$directory, $model){

        if($file instanceof UploadedFile){

            if($model->cover != null){
                Storage::delete($model->cover);
            }
            
            $uploadable = $file->store($directory);

            $model->cover = $uploadable;

            $model->save();
        }
        return $model;
    }

    public function uploadAndGetPath($file ,$directory)
    {
        $uploadable = null;

        if($file instanceof UploadedFile){
            $uploadable = $file->store($directory);
        }

        return $uploadable;
    }
}
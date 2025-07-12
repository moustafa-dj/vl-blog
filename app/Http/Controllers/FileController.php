<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function getFile($path)
    {
        if(Storage::disk('private')->exists($path)){
            $file_path = Storage::disk('private')->path($path);
            return response()->download($file_path);
        }else{
            $file_path = Storage::disk('local')->path($path);
            return response()->download($file_path);
        }
        abort(404);
    }
}

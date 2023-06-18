<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{

    public static function upload($imageFile,$folderName) {
        $fileName = Storage::putFile('public/'.$folderName.'/',$imageFile);
        return basename($fileName);
    }
}
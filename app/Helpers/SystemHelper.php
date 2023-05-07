<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

// Get file from storage folder
if (!function_exists('storageLink')) {
    function storageLink($url)
    {
        if ($url && Storage::disk('public')->exists($url)) {
            $url = Storage::disk('public')->url($url);
        }

        return $url;
    }
}


if (!function_exists('generateUniqueValue')) {
    function generateUniqueValue($string, $model, $column, $slug = false)
    {
        if ($slug) {
            $string = Str::slug($string);
        }

        if ($model::where($column, $string)->exists()) {
            $original = $string;

            $count = 0;

            while ($model::where($column, $string)->exists()) {

                $string = "{$original}-" . $count + 1;
            }
        }

        return $string;
    }
}


// Upload image and return the uploaded path
if (!function_exists('imageUploadHandler')) {
    function imageUploadHandler($image, $request_path = 'default', $size = null, $old_image = null)
    {
        if (isset($old_image) && Storage::disk('public')->exists($old_image)) {
            Storage::disk('public')->delete($old_image);
        }

        $path = $image->store($request_path, 'public');

        if (isset($size)) {
            $request_size = explode('x', $size);
            $width        = $request_size[0];
            $height       = $request_size[1];
            $image        = Image::make(Storage::disk('public')->get($path))->fit($width, $height)->encode();
            Storage::disk('public')->put($path, $image);
        }

        return $path;
    }
}

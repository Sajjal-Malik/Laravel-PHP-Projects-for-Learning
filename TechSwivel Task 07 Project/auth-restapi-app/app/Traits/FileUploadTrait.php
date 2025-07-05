<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
     public function uploadImage($file)
    {
        try {
            if ($file && $file->isValid()) {
                return $file->store('post-images', 'public');
            }
            return null;

        } catch (\Exception $e) {

            throw new \Exception('Image upload failed: ' . $e->getMessage());
        }
    }

    public function deleteImage($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            
            Storage::disk('public')->delete($path);
        }
    }
}
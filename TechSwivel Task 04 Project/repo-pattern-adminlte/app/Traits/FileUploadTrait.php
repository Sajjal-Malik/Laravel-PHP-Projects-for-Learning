<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    public function uploadLogo($file)
    {
        try {
            if ($file && $file->isValid()) {
                return $file->store('company-logos', 'public');
            }
            return null;
        } catch (\Exception $e) {

            throw new \Exception('Logo upload failed: ' . $e->getMessage());
        }
    }

    public function deleteLogo($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

     public function uploadPhoto($file)
    {
        try {
            if ($file && $file->isValid()) {
                return $file->store('employee-photos', 'public');
            }
            return null;
        } catch (\Exception $e) {

            throw new \Exception('Employee Photo upload failed: ' . $e->getMessage());
        }
    }

    public function deletePhoto($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

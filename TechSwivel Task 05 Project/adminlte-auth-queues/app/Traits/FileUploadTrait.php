<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * One-stop helper for all image uploads in the project.
 *
 * ─ uploadLogo()      : store company logo   → returns filename
 * ─ uploadPhoto()     : store employee photo → returns filename
 * ─ deleteLogo() / deletePhoto() : remove files from disk
 * ─ uploadFileFromFactory()       : copy stub images when seeding
 *
 * All files live in storage/app/public/{folder}.  Make sure you have run
 *   php artisan storage:link
 * so the browser can reach them at  /storage/{folder}/{filename}
 */
trait FileUploadTrait
{
    public function uploadLogo(?UploadedFile $file): ?string
    {
        return $this->storePublicFile($file, 'company-logos');
    }

    
    public function deleteLogo(?string $path): void
    {
        $this->deletePublicFile($path);
    }

   
    public function uploadPhoto(?UploadedFile $file): ?string
    {
        return $this->storePublicFile($file, 'employee-photos');
    }

    
    public function deletePhoto(?string $path): void
    {
        $this->deletePublicFile($path);
    }

    
    public function uploadFileFromFactory(string $stubName, string $folder): string
    {
        $source = database_path("factories/images/{$stubName}");
        
        $filename = Str::uuid() . '_' . $stubName;

        Storage::put("public/{$folder}/{$filename}", file_get_contents($source));

        return $filename;
    }

   
    private function storePublicFile(?UploadedFile $file, string $folder): ?string
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        try {
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $file->storeAs("public/{$folder}", $filename);

            return $filename; 

        } catch (\Exception $e) {

            throw new \Exception("File upload failed: {$e->getMessage()}");
        }
    }

    private function deletePublicFile(?string $path): void
    {
        
        if ($path && Storage::disk('public')->exists($path)) {

            Storage::disk('public')->delete($path);
        }
    }
}

<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function uploadImage(UploadedFile $file, string $path = 'profil_sayas'): string
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs($path, $filename, 'public');
    }

    public function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}

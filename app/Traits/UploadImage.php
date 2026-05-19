<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait UploadImage
{
    /**
     * Upload an image to the specified folder.
     */
    public function uploadImage(UploadedFile $file, string $folder = 'uploads'): string
    {
        $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($folder), $fileName);
        return $fileName;
    }

    /**
     * Delete an image from the specified folder.
     */
    public function deleteImage(?string $fileName, string $folder = 'uploads'): void
    {
        if ($fileName) {
            $path = public_path($folder . '/' . $fileName);
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    /**
     * Replace an existing image with a new upload.
     */
    public function replaceImage(UploadedFile $newFile, ?string $oldFileName, string $folder = 'uploads'): string
    {
        $this->deleteImage($oldFileName, $folder);
        return $this->uploadImage($newFile, $folder);
    }
}

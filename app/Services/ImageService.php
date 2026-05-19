<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function upload($image, $path, $width = null, $height = null)
    {
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        
        $img = $this->manager->read($image);
        
        if ($width && $height) {
            $img->resize($width, $height);
        } elseif ($width) {
            $img->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $img->save(public_path($path . '/' . $imageName), 80);

        return $imageName;
    }

    public function delete($image, $path)
    {
        $imagePath = public_path($path . '/' . $image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
            return true;
        }
        return false;
    }
}

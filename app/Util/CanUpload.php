<?php


namespace App\Util;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait CanUpload
{
    public function uploadFile(UploadedFile $file, string $directory, string $fileName) :string
    {
        $fileNameWithTime = $fileName . time() . '.' . $file->getClientOriginalExtension();
        return Storage::disk('public')->putFileAs($directory, $file, $fileNameWithTime);
    }
}
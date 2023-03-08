<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadFileTrait
{
    public function uploadFile($requestFile, $folder, $disk = 'public', $filename = null)
    {
        try {
            $FileName = !is_null($filename) ? $filename : Str::random(10);
            return $requestFile->storeAs(
                $folder,
                $FileName . "." . $requestFile->getClientOriginalExtension(),
                $disk
            );

        } catch (\Exception $e) {
            report($e);
            return $e->getMessage();
        }
    }

    // delete file
    public function deleteFile($fileName, $disk = 'public')
    {
        try {
            if ($fileName) {
                    Storage::delete($disk . '/' . $fileName);
            }
            return true;
        } catch (\Exception $e) {
            report($e);
            return $e->getMessage();
        }
    }
}

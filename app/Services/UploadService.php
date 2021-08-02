<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Storage;

class UploadService
{

    public static $root_directory = 'uploads';

    public static function uploadSingleFile($file)
    {
        $fileName = static::sanitizeFileName($file->getClientOriginalName());
        $uniqueFolderId = uniqid() . '-' . now()->timestamp;
        if (Storage::disk('public')->put(
            self::$root_directory . '/' . $uniqueFolderId . '/' . $fileName,
            file_get_contents($file)
        )) {
            // return;
            return [
                'filename' => $fileName,
                'unique_folder_id' => $uniqueFolderId,
                'url' => Storage::disk('public')->url(self::$root_directory . '/' . $uniqueFolderId . '/' . $fileName)
            ];
        }
        throw new Exception('Could not upload file');
    }

    public static function sanitizeFileName($fileName)
    {
        $newFileName = str_replace(' ', '', $fileName);
        // remove all characters that's not a letter (a-z), a number (0-9) or a dash, or dot (we want to keep the file extension)s
        return preg_replace("/[^a-z0-9\-\.]/i", '', $newFileName);
    }

    public static function deleteFile($uniqueFolderId, $fileName)
    {
        $uploadedFilePath = $uniqueFolderId . '/' . $fileName;
        if (Storage::disk('public')->exists(self::$root_directory  . '/' . $uploadedFilePath)) {
            Storage::disk('public')->deleteDirectory(self::$root_directory  . '/' . $uniqueFolderId);
        }
        return;
    }
}
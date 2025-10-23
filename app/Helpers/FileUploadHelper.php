<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class FileUploadHelper
{
    /**
     * Upload file ke storage
     * 
     * @param UploadedFile $file
     * @param string $folder
     * @param string|null $oldFile
     * @return string|null
     */
    public static function uploadFile(UploadedFile $file, string $folder, ?string $oldFile = null): ?string
    {
        try {
            // Hapus file lama jika ada
            if ($oldFile) {
                self::deleteFile($oldFile);
            }

            // Generate nama file unik
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Upload file ke storage/app/public/{folder}
            $path = $file->storeAs($folder, $fileName, 'public');
            
            return $path;
        } catch (\Exception $e) {
            \Log::error('File upload error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Hapus file dari storage
     * 
     * @param string $filePath
     * @return bool
     */
    public static function deleteFile(string $filePath): bool
    {
        try {
            if (Storage::disk('public')->exists($filePath)) {
                return Storage::disk('public')->delete($filePath);
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('File delete error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get file URL
     * 
     * @param string|null $filePath
     * @param string $default
     * @return string
     */
    public static function getFileUrl(?string $filePath, string $default = 'images/no-image.png'): string
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return asset('storage/' . $filePath);
        }
        return asset($default);
    }

    /**
     * Validate file upload
     * 
     * @param UploadedFile $file
     * @param array $allowedExtensions
     * @param int $maxSize (in MB)
     * @return array
     */
    public static function validateFile(UploadedFile $file, array $allowedExtensions = [], int $maxSize = 5): array
    {
        $errors = [];

        // Check file size
        if ($file->getSize() > ($maxSize * 1024 * 1024)) {
            $errors[] = "Ukuran file maksimal {$maxSize}MB";
        }

        // Check extension
        if (!empty($allowedExtensions)) {
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $allowedExtensions)) {
                $errors[] = "Format file harus: " . implode(', ', $allowedExtensions);
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
}
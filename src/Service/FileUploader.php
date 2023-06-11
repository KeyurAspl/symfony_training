<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

    public function __construct(private string $uploadDirectory)
    {

    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->uploadDirectory, $newFilename);
        } catch (FileException $e) {
            // Handle the exception
        }

        return $newFilename;
    }

    public function isValid(UploadedFile $file, array $allowedExtensions): bool
    {
        $fileExtension = $file->guessExtension();

        // Perform validation logic
        // For example, check file size, allowed extensions, etc.

        return in_array($fileExtension, $allowedExtensions, true);
    }
}
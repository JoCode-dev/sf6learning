<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploaderService
{
    public function __construct(
        private SluggerInterface $slugger
    ) {
    }
    public function uploadImage(
        UploadedFile $file,
        string $directoryFolder
    ) {
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFileName);
        $newFilename = $safeFilename . '-' . uniqid() . '-' . $file->guessExtension();

        try {
            $file->move(
                $directoryFolder,
                $newFilename,
            );
        } catch (FileException $e) {
        }

        return $newFilename;
    }
}

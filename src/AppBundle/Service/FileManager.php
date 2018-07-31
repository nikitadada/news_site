<?php

namespace AppBundle\Service;

use Symfony\Component\Filesystem\Filesystem;

class FileManager
{
    const DEFAULT_FILE_NAME = "news.jpg";

    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload($file)
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        $file->move($this->getTargetDirectory(), $fileName);

        return $fileName;
    }

    public function removeFile($fileName)
    {
        $fs = new Filesystem();
        $file = $this->getTargetDirectory() . '/' . $fileName;

        if ($fileName == $this::DEFAULT_FILE_NAME) return false;

        if ($fs->exists($file)) {
            $fs->remove($file);
            return true;
        }
        return false;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
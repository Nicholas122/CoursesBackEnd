<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PhotoService
{
    /** @var string */
    private $webDir;

    /** @var string */
    private $baseDir;

    /**
     * ImageService constructor.
     *
     * @param string $webDir
     * @param string $baseDir
     */
    public function __construct($webDir, $baseDir)
    {
        $this->webDir = $webDir;
        $this->baseDir = $baseDir;
    }

    /**
     * @param string $linkedEntityType
     * @param int    $linkedEntityId
     * @param string $name
     * @param string $width
     * @param string $height
     * @param string $format
     * @param int    $zoomCrop
     *
     * @return string
     */
    public function resize(
        $linkedEntityType,
        $linkedEntityId,
        $name,
        $width,
        $height,
        $format
    ) {
        $fullPath = $this->webDir.'/'.$this->baseDir.'/'.
            $linkedEntityType.'/'.
            (string) $linkedEntityId.'/'.
            $name;
        if (!file_exists($fullPath.'.'.$format)) {
            throw new NotFoundHttpException();
        }

        $resizedPath = $fullPath.'-'.$width.'x'.$height.'.'.$format;

        if (!file_exists($resizedPath)) {
            $this->createResize($fullPath.'.'.$format, $resizedPath, $width, $height);
        }

        return $resizedPath;
    }

    public function upload(UploadedFile $file, $targetDir)
    {
        $fullPath = $this->webDir.'/'.$this->baseDir.'/'.$targetDir.'/'.'photos';

        $format = $file->getClientOriginalExtension();
        $fileName = uniqid().'.'.$format;
        $file->move($fullPath, $fileName);

        return $this->convertToJPG($this->baseDir.'/'.$targetDir.'/'.'photos'.'/'.$fileName);
    }

    private function createResize($imagePath, $resizedPath, $width, $height)
    {
        $image = new \Imagick(realpath($imagePath));

        if ('auto' === $height) {
            $info = getimagesize($imagePath);
            list($width_old, $height_old) = $info;

            $factor = $width / $width_old;

            $final_width = $width;
            $final_height = round($height_old * $factor);

            $image->resizeImage($final_width, $final_height, \Imagick::FILTER_LANCZOS, 1);
        } else {
            $image->cropThumbnailImage($width, $height);
        }
        $image->writeImage($resizedPath);
    }

    private function convertToJPG($imagePath)
    {
        $image = new \Imagick(realpath($imagePath));
        $currentFormat = $ext = pathinfo($imagePath, PATHINFO_EXTENSION);
        $newImagePath = $imagePath;
        if ('jpg' != $currentFormat) {
            $newImagePath = str_ireplace($currentFormat, 'jpg', $imagePath);
            unlink($imagePath);
        }

        $image->setImageFormat('jpg');
        $image->writeImage($newImagePath);

        return $newImagePath;
    }
}

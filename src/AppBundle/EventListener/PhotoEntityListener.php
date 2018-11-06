<?php

namespace AppBundle\EventListener;

use AppBundle\Service\Google\GoogleGeocodeService;
use AppBundle\Service\PhotoService;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Entity\PhotoInterface;

class PhotoEntityListener
{
    private $photoService;


    /**
     * @param PhotoService $photoService
     */
    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;

    }

    /**
     * Upload photo.
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @param LifecycleEventArgs $args
     */
    public function upload(PhotoInterface $entity, LifecycleEventArgs $args)
    {
        $file = $entity->getPhoto();
        if (!$file instanceof UploadedFile) {
            return;
        }

        $path = $this->photoService->upload($file, $entity->getUser()->getId());


        $entity->setPhoto($path);
    }


    /**
     * Remove photos.
     *
     * @ORM\PreRemove()
     *
     * @param LifecycleEventArgs $args
     */
    public function removePhotos(PhotoInterface $entity, LifecycleEventArgs $args)
    {
        $path = $entity->getPhoto();

        $this->deleteResizePhoto($path);
    }

    private function deleteResizePhoto($photo)
    {
        $photoDir = pathinfo($photo, PATHINFO_DIRNAME);
        $fileName = pathinfo($photo, PATHINFO_FILENAME);

        if ($photoDir) {
            $files = scandir($photoDir);
            foreach ($files as $file) {
                if (0 === strpos($file, $fileName)) {
                    unlink($photoDir . '/' . $file);
                }
            }
        }
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Service\PhotoService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class FileController extends BaseController
{
    /**
     * Resize an image.
     *
     *
     * @param $linkedEntityType
     * @param $linkedEntityId
     * @param $name
     * @param $width
     * @param $height
     * @param $format
     * @param int $zoomCrop
     *
     *
     * @return BinaryFileResponse|JsonResponse
     */
    public function resizeFileImageAction(
        $linkedEntityType,
        $linkedEntityId,
        $name,
        $width,
        $height,
        $format
    ) {
        $imageService = $this->getPhotoService();
        try {
            $resized = $imageService->resize(
                $linkedEntityType,
                $linkedEntityId,
                $name,
                $width,
                $height,
                $format
            );
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 422);
        }

        return new BinaryFileResponse($resized);
    }

    /**
     * @return PhotoService
     */
    protected function getPhotoService()
    {
        /**
         * @var PhotoService $photoService
         */
        $photoService = $this->get('app.photo.service');

        return $photoService;
    }
}
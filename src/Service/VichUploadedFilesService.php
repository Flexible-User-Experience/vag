<?php

namespace App\Service;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Class VichUploadedFilesService
 */
class VichUploadedFilesService
{
    const JPEG_EXTENSION = 'jpeg';
    const JPG_EXTENSION = 'jpg';
    const PNG_EXTENSION = 'png';
    const GIF_EXTENSION = 'gif';

    /**
     * @var UploaderHelper
     */
    private $vus;

    /**
     * @var CacheManager
     */
    private $lis;

    /**
     * EmailSendingService constructor.
     *
     * @param UploaderHelper $vus
     * @param CacheManager   $lis
     */
    public function __construct(UploaderHelper $vus, CacheManager $lis)
    {
        $this->vus = $vus;
        $this->lis = $lis;
    }

    /**
     * @param array|object $object
     * @param string $fieldName
     *
     * @return string
     */
    public function getFileSrc($object, $fieldName): string
    {
        $result = '';
        if ($object->getImageName()) {
            $result = $this->vus->asset($object, $fieldName);
        }

        return $result;
    }

    /**
     * @param array|object $object
     * @param string $fieldName
     *
     * @return string
     */
    public function getFileExtension($object, $fieldName): string
    {
        $result = '';
        $filePath = $this->getFileSrc($object, $fieldName);
        if ($filePath) {
            $result = pathinfo($this->vus->asset($object, $fieldName), PATHINFO_EXTENSION);
        }

        return $result;
    }

    /**
     * @param string $extension
     *
     * @return bool
     */
    public function isImageFileExtension(string $extension): bool
    {
        $result = false;
        $extension = strtolower($extension);
        if ($extension == self::JPEG_EXTENSION || $extension == self::JPG_EXTENSION || $extension == self::PNG_EXTENSION || $extension == self::GIF_EXTENSION) {
            $result = true;
        }

        return $result;
    }

    /**
     * @param array|object $object
     * @param string $fieldName
     * @param string $filter
     *
     * @return string
     */
    public function getImageFileSrcWithLiipFilter($object, $fieldName, $filter): string
    {
        return $this->lis->getBrowserPath($this->vus->asset($object, $fieldName), $filter);
    }
}

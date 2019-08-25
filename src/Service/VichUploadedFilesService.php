<?php

namespace App\Service;

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
     * EmailSendingService constructor.
     *
     * @param UploaderHelper $vus
     */
    public function __construct(UploaderHelper $vus)
    {
        $this->vus = $vus;
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
        $filePath = $this->vus->asset($object, $fieldName);
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
}

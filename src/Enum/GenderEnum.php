<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class GenderEnum
 */
class GenderEnum
{
    const MALE = 0;
    const FEMALE = 1;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Methods
     */

    /**
     * GenderEnum constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return array
     */
    public function getChoices()
    {
        return [
            $this->translator->trans('admin.label.gender.male') => self::MALE,
            $this->translator->trans('admin.label.gender.female') => self::FEMALE,
        ];
    }

    /**
     * @return array
     */
    public static function getStaticChoices()
    {
        return [
            'admin.label.gender.male' => self::MALE,
            'admin.label.gender.female' => self::FEMALE,
        ];
    }
}

<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class LanguageEnum
 */
class LanguageEnum
{
    const CATALAN = 'ca';
    const SPANISH = 'es';
    const ENGLISH = 'en';

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
            $this->translator->trans('admin.label.language.'.self::CATALAN) => self::CATALAN,
            $this->translator->trans('admin.label.language.'.self::SPANISH) => self::SPANISH,
            $this->translator->trans('admin.label.language.'.self::ENGLISH) => self::ENGLISH,
        ];
    }

    /**
     * @return array
     */
    public static function getStaticChoices()
    {
        return [
            'admin.label.language.'.self::CATALAN => self::CATALAN,
            'admin.label.language.'.self::SPANISH => self::SPANISH,
            'admin.label.language.'.self::ENGLISH => self::ENGLISH,
        ];
    }
}

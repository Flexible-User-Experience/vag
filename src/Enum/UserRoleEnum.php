<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class UserRoleEnum
 */
class UserRoleEnum
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_CMS = 'ROLE_CMS';
    const ROLE_ADMIN = 'ROLE_ADMIN';

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
            $this->translator->trans('admin.label.role.'.self::ROLE_USER) => self::ROLE_USER,
            $this->translator->trans('admin.label.role.'.self::ROLE_CMS) => self::ROLE_CMS,
            $this->translator->trans('admin.label.role.'.self::ROLE_ADMIN) => self::ROLE_ADMIN,
        ];
    }

    /**
     * @return array
     */
    public static function getStaticChoices()
    {
        return [
            'admin.label.role.'.self::ROLE_USER => self::ROLE_USER,
            'admin.label.role.'.self::ROLE_CMS => self::ROLE_CMS,
            'admin.label.role.'.self::ROLE_ADMIN => self::ROLE_ADMIN,
        ];
    }
}

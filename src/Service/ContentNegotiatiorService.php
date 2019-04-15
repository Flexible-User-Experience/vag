<?php

namespace App\Service;

use Negotiation\AcceptLanguage;
use Negotiation\LanguageNegotiator;

/**
 * Class ContentNegotiatiorService
 */
class ContentNegotiatiorService
{
    /**
     * @var LanguageNegotiator
     */
    private $lns;

    /**
     * @var string
     */
    private $acceptLanguageHeader = 'en; q=0.1, es; q=0.4, ca; q=0.9';

    /**
     * @var array
     */
    private $locales;

    /**
     * Methods
     */

    /**
     * ContentNegotiatiorService constructor.
     *
     * @param string $locales
     */
    public function __construct($locales)
    {
        $this->lns = new LanguageNegotiator();
        $this->locales = explode('|', $locales);
    }

    /**
     * @return string
     */
    public function getBestLanguage()
    {
        /** @var AcceptLanguage $bestLanguage */
        $bestLanguage = $this->lns->getBest($this->acceptLanguageHeader, $this->locales);

        return $bestLanguage->getType();
    }
}

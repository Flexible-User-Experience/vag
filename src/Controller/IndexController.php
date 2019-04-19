<?php

namespace App\Controller;

use App\Service\ContentNegotiatiorService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class IndexController
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="front_start_index")
     *
     * @param ContentNegotiatiorService $cns
     * @param string $defaultLocale
     *
     * @return RedirectResponse
     */
    public function index(ContentNegotiatiorService $cns, string $defaultLocale)
    {
        $bestLocale = $cns->getBestLanguage();

        return $this->redirectToRoute('front_homepage', ['_locale' => $bestLocale ? $bestLocale : $defaultLocale]);
    }
}

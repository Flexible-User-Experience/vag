<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function index(Request $request)
    {
        $bestLocale = $request->getPreferredLanguage($this->getParameter('app_array_locales'));

        return $this->redirectToRoute('front_homepage', ['_locale' => $bestLocale]);
    }
}

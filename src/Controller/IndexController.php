<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="front_start_index")
     *
     * @return RedirectResponse
     */
    public function index()
    {
        return $this->redirectToRoute('front_homepage', ['_locale' => $this->getParameter('locale')]);
    }
}

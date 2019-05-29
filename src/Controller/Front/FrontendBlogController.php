<?php

namespace App\Controller\Front;

use App\Entity\BlogCategory;
use App\Entity\BlogPost;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/blog", requirements={"_locale"="%app_locales%"})
 */
class FrontendBlogController extends AbstractController
{
    /**
     * @Route({"ca": "/noticies/{page}", "es": "/noticias/{page}", "en": "/news/{page}"}, name="front_blog")
     *
     * @param int $page
     *
     * @return Response|AccessDeniedException
     */
    public function index($page = 1)
    {
        $tags = $this->getDoctrine()->getRepository(BlogCategory::class)->findAll();
        $posts = $this->getDoctrine()->getRepository(BlogPost::class)->findAll();
//        $posts = $this->getDoctrine()->getRepository(BlogPost::class)->getAllEnabledSortedByPublishedDateWithJoinUntilNow();

//        $paginator = $this->get('knp_paginator');
//        $pagination = $paginator->paginate($posts, $page, 9);

        return $this->render('frontend/blog/list.html.twig', [
            'tags' => $tags,
            'posts' => $posts,
//            'pagination' => $pagination,
        ]);
    }
}

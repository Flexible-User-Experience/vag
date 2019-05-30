<?php

namespace App\Controller\Front;

use App\Entity\BlogCategory;
use App\Entity\BlogPost;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @Route({"ca": "/noticies/{page}", "es": "/noticias/{page}", "en": "/news/{page}"}, name="front_blog", requirements={"page"="\d+"})
     *
     * @param int $page
     *
     * @return Response|AccessDeniedException
     * @throws \Exception
     */
    public function index($page = 1)
    {
        $tags = $this->getDoctrine()->getRepository(BlogCategory::class)->findAvailableSortedByName()->getQuery()->getResult();
        $posts = $this->getDoctrine()->getRepository(BlogPost::class)->findUpTodayAvailableSortedByPublishedDateAndName()->getQuery()->getResult();

//        $posts = $this->getDoctrine()->getRepository(BlogPost::class)->getAllEnabledSortedByPublishedDateWithJoinUntilNow();

//        $paginator = $this->get('knp_paginator');
//        $pagination = $paginator->paginate($posts, $page, 9);

        return $this->render('frontend/blog/list.html.twig', [
            'tags' => $tags,
            'posts' => $posts,
//            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route({"ca": "/{year}/{month}/{day}/{slug}", "es": "/{year}/{month}/{day}/{slug}", "en": "/{year}/{month}/{day}/{slug}"}, name="front_blog_post_detail", requirements={"year"="\d{4}", "month"="\d{2}", "day"="\d{2}"})
     *
     * @param string $year
     * @param string $month
     * @param string $day
     * @param string $slug
     *
     * @return Response|AccessDeniedException
     *
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function postDetail($year, $month, $day, $slug)
    {
        $published = new \DateTime();
        $published->setDate($year, $month, $day);
        $tags = $this->getDoctrine()->getRepository(BlogCategory::class)->findAvailableSortedByName()->getQuery()->getResult();
        $post = $this->getDoctrine()->getRepository(BlogPost::class)->findByPublishedAndSlug($published, $slug)->getQuery()->getOneOrNullResult();

        if (!$post) {
            $this->createNotFoundException();
        }

        // TODO throw exception if today is before the post publish date
        // TODO throw exception post is unavailable only for anonymous users

        return $this->render('frontend/blog/detail.html.twig', [
            'tags' => $tags,
            'post' => $post,
        ]);
    }
}

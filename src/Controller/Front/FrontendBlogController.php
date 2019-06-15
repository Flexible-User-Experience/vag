<?php

namespace App\Controller\Front;

use App\Entity\BlogCategory;
use App\Entity\BlogPost;
use App\Enum\UserRoleEnum;
use App\Manager\BlogCategoryManager;
use DateTime;
use DateTimeImmutable;
use Exception;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @return Response
     * @throws Exception
     */
    public function index($page = 1)
    {
        $tags = $this->getDoctrine()->getRepository(BlogCategory::class)->findAvailableSortedByName()->getQuery()->getResult();
        $posts = $this->getDoctrine()->getRepository(BlogPost::class)->findUpTodayAvailableSortedByPublishedDateAndName()->getQuery()->getResult();

        // TODO add pagination
        // $posts = $this->getDoctrine()->getRepository(BlogPost::class)->getAllEnabledSortedByPublishedDateWithJoinUntilNow();

        // $paginator = $this->get('knp_paginator');
        // $pagination = $paginator->paginate($posts, $page, 9);

        return $this->render('frontend/blog/list.html.twig', [
            'tags' => $tags,
            'posts' => $posts,
//            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route({"ca": "/etiqueta/{slug}/{page}", "es": "/etiqueta/{slug}/{page}", "en": "/tag/{slug}/{page}"}, name="front_blog_tag", requirements={"page"="\d+"})
     *
     * @param string $slug
     * @param int $page
     * @param BlogCategoryManager $bcm
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function tagDetail(string $slug, $page = 1, BlogCategoryManager $bcm)
    {
        $selectedTag = $bcm->getTagByTranslatedSlug($slug);
        if (!$selectedTag) {
            throw $this->createNotFoundException();
        }

        $tags = $this->getDoctrine()->getRepository(BlogCategory::class)->findAvailableSortedByName()->getQuery()->getResult();
        $posts = $this->getDoctrine()->getRepository(BlogPost::class)->findUpTodayAvailableSortedByPublishedDateNameAndTag($selectedTag)->getQuery()->getResult();

        // TODO add pagination
        // $posts = $this->getDoctrine()->getRepository(BlogPost::class)->getAllEnabledSortedByPublishedDateWithJoinUntilNow();

        // $paginator = $this->get('knp_paginator');
        // $pagination = $paginator->paginate($posts, $page, 9);

        return $this->render('frontend/blog/tag.html.twig', [
            'selected_tag' => $selectedTag,
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
     * @return Response
     *
     * @throws NotFoundHttpException
     * @throws AccessDeniedHttpException
     * @throws Exception
     */
    public function postDetail($year, $month, $day, $slug)
    {
        $published = new DateTime();
        $published->setDate($year, $month, $day);
        $tags = $this->getDoctrine()->getRepository(BlogCategory::class)->findAvailableSortedByName()->getQuery()->getResult();
        /** @var BlogPost $post */
        $post = $this->getDoctrine()->getRepository(BlogPost::class)->findByPublishedAndSlug($published, $slug)->getQuery()->getOneOrNullResult();

        if (!$post) {
            throw $this->createNotFoundException();
        }

        $today = new DateTimeImmutable();
        if ($today->format('Y-m-d') < $published->format('Y-m-d')) {
            throw $this->createNotFoundException();
        }

        if (!$post->isAvailable() && !$this->get('security.authorization_checker')->isGranted(UserRoleEnum::ROLE_CMS)) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('frontend/blog/detail.html.twig', [
            'tags' => $tags,
            'post' => $post,
        ]);
    }
}

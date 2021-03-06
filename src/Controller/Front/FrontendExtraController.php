<?php

namespace App\Controller\Front;

use App\Entity\ContactMessage;
use App\Entity\TeamMember;
use App\Entity\TeamPartner;
use App\Enum\UserRoleEnum;
use App\Form\ContactMessageType;
use App\Service\EmailSendingService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/", requirements={"_locale"="%app_locales%"})
 */
class FrontendExtraController extends AbstractController
{
    /**
     * @Route("/test", name="front_test")
     *
     * @return Response|AccessDeniedException
     */
    public function homepageTest()
    {
        return !$this->get('security.authorization_checker')->isGranted(UserRoleEnum::ROLE_CMS) ? $this->createAccessDeniedException() : $this->render('frontend/homepage_test.html.twig', []);
    }

    /**
     * @Route({"ca": "/politica-de-privacitat", "es": "/politica-de-privacidad", "en": "/privacy-policy"}, name="front_privacy_policy")
     *
     * @return Response
     */
    public function privacyPolicy()
    {
        return $this->render('frontend/privacy_policy.html.twig', []);
    }

    /**
     * @Route({"ca": "/avis-legal", "es": "/aviso-legal", "en": "/legal-warning"}, name="front_legal_warning")
     *
     * @return Response
     */
    public function legalWarningPolicy()
    {
        return $this->render('frontend/legal_warning.html.twig', []);
    }

    /**
     * @Route({"ca": "/contacte", "es": "/contacto", "en": "/contact"}, name="front_contact")
     *
     * @param Request             $request
     * @param TranslatorInterface $translator
     * @param EmailSendingService $ess
     *
     * @return Response
     */
    public function contact(Request $request, TranslatorInterface $translator, EmailSendingService $ess)
    {
        $hideForm = false;
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactMessage
                ->setLegalTermsHasBeenAccepted(true)
                ->setHasBeenReaded(false)
                ->setHasBeenAnswered(false)
                ->setSubject('front_contact')
            ;
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactMessage);
            $em->flush();
            $this->addFlash(
                'success',
                $translator->trans('front.flash.contact_message_send')
            );
            $ess->sendFrontendContactMessageNotificationToAdmin($contactMessage);
            $hideForm = true;
        }

        return $this->render('frontend/contact.html.twig', [
            'form' => $form->createView(),
            'hideForm' => $hideForm,
        ]);
    }

    /**
     * @Route({"ca": "/qui-som", "es": "/quienes-somos", "en": "/who-we-are"}, name="front_team")
     *
     * @return Response
     */
    public function team()
    {
        $members = $this->getDoctrine()->getRepository(TeamMember::class)->findShowInFrontendSortedBySurnameAndName()->getQuery()->getResult();

        return $this->render('frontend/team.html.twig', [
            'members' => $members,

        ]);
    }

    /**
     * @Route({"ca": "/patrocinadors", "es": "/patrocinadores", "en": "/partners"}, name="front_partners")
     *
     * @return Response
     */
    public function partners()
    {
        $partners = $this->getDoctrine()->getRepository(TeamPartner::class)->findOnlyPartnersShowInFrontendSortedByName()->getQuery()->getResult();
        $collaborators = $this->getDoctrine()->getRepository(TeamPartner::class)->findOnlyCollaboratorsShowInFrontendSortedByName()->getQuery()->getResult();

        return $this->render('frontend/partners.html.twig', [
            'partners' => $partners,
            'collaborators' => $collaborators,
        ]);
    }
}

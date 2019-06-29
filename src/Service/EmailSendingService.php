<?php

namespace App\Service;

use App\Entity\ContactMessage;
use Swift_Mailer;
use Swift_Message;

/**
 * Class EmailSendingService
 */
class EmailSendingService
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $mailerSenderAddress;

    /**
     * EmailSendingService constructor.
     *
     * @param Swift_Mailer $mailer
     * @param string       $mailerSenderAddress
     */
    public function __construct(Swift_Mailer $mailer, string $mailerSenderAddress)
    {
        $this->mailer = $mailer;
        $this->mailerSenderAddress = $mailerSenderAddress;
    }

    /**
     * @param ContactMessage $contactMessage
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure
     */
    public function sendFrontendContactMessageNotificationToAdmin(ContactMessage $contactMessage)
    {
        $message = (new Swift_Message('VAG contact message recived from webpage'))
            ->setFrom($this->mailerSenderAddress)
            ->setTo($this->mailerSenderAddress)
            ->setBody(
                '<p>Name: '.$contactMessage->getName().'</p>'.
                '<p>Email: '.$contactMessage->getEmail().'</p>'.
                '<p>Phone: '.$contactMessage->getPhone().'</p>'.
                '<p>Message: '.$contactMessage->getMessage().'</p>'
                ,
                'text/html'
            )
        ;

        return $this->mailer->send($message);
    }
}

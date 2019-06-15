<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactMessageRepository")
 * @ORM\Table()
 */
class ContactMessage extends AbstractContactPerson
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $subject;

    /**
     * @ORM\Column(type="text", length=4000)
     *
     * @var string
     */
    private $message;

    /**
     * @ORM\Column(type="text", length=4000, nullable=true)
     *
     * @var string
     */
    private $answer;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTime
     */
    protected $answered;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=0})
     *
     * @var bool
     */
    private $legalTermsHasBeenAccepted;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=0})
     *
     * @var bool
     */
    private $hasBeenReaded;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=0})
     *
     * @var bool
     */
    private $hasBeenAnswered;

    /**
     * @Recaptcha\IsTrue
     *
     * @var string
     */
    private $recaptcha;

    /**
     * Methods.
     */

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string|null $subject
     *
     * @return ContactMessage
     */
    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     *
     * @return ContactMessage
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    /**
     * @param string|null $answer
     *
     * @return ContactMessage
     */
    public function setAnswer(?string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getAnswered(): ?DateTimeInterface
    {
        return $this->answered;
    }

    /**
     * @return string
     */
    public function getAnsweredString(): string
    {
        return $this->getAnswered() ? $this->getAnswered()->format('d/m/Y H:i') : '---';
    }

    /**
     * @param DateTimeInterface|null $answered
     *
     * @return ContactMessage
     */
    public function setAnswered(?DateTimeInterface $answered): self
    {
        $this->answered = $answered;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function legalTermsHasBeenAccepted(): ?bool
    {
        return $this->legalTermsHasBeenAccepted;
    }

    /**
     * @return bool|null
     */
    public function getLegalTermsHasBeenAccepted(): ?bool
    {
        return $this->legalTermsHasBeenAccepted();
    }

    /**
     * @param bool|null $legalTermsHasBeenAccepted
     *
     * @return ContactMessage
     */
    public function setLegalTermsHasBeenAccepted(?bool $legalTermsHasBeenAccepted): self
    {
        $this->legalTermsHasBeenAccepted = $legalTermsHasBeenAccepted;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function hasBeenReaded(): ?bool
    {
        return $this->hasBeenReaded;
    }

    /**
     * @return bool|null
     */
    public function getHasBeenReaded(): ?bool
    {
        return $this->hasBeenReaded();
    }

    /**
     * @param bool|null $hasBeenReaded
     *
     * @return ContactMessage
     */
    public function setHasBeenReaded(?bool $hasBeenReaded): self
    {
        $this->hasBeenReaded = $hasBeenReaded;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function hasBeenAnswered(): ?bool
    {
        return $this->hasBeenAnswered;
    }

    /**
     * @return bool|null
     */
    public function getHasBeenAnswered(): ?bool
    {
        return $this->hasBeenAnswered();
    }

    /**
     * @param bool|null $hasBeenAnswered
     *
     * @return ContactMessage
     */
    public function setHasBeenAnswered(?bool $hasBeenAnswered): self
    {
        $this->hasBeenAnswered = $hasBeenAnswered;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRecaptcha(): ?string
    {
        return $this->recaptcha;
    }

    /**
     * @param string|null $recaptcha
     *
     * @return ContactMessage
     */
    public function setRecaptcha(?string $recaptcha)
    {
        $this->recaptcha = $recaptcha;

        return $this;
    }
}

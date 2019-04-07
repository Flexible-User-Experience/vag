<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamMemberRepository")
 * @ORM\Table()
 */
class ContactMessage extends AbstractEntity
{
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $subject;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $phone;

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
     * Methods.
     */

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return ContactMessage
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @return ContactMessage
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return ContactMessage
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     *
     * @return ContactMessage
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

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
     * @param string $message
     *
     * @return ContactMessage
     */
    public function setMessage(string $message): self
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
     * @param string $answer
     *
     * @return ContactMessage
     */
    public function setAnswer(string $answer): self
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
     * @param DateTimeInterface $answered
     *
     * @return ContactMessage
     */
    public function setAnswered(DateTimeInterface $answered): self
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
     * @param bool $legalTermsHasBeenAccepted
     *
     * @return ContactMessage
     */
    public function setLegalTermsHasBeenAccepted(bool $legalTermsHasBeenAccepted): self
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
     * @param bool $hasBeenReaded
     *
     * @return ContactMessage
     */
    public function setHasBeenReaded(bool $hasBeenReaded): self
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
     * @param bool $hasBeenAnswered
     *
     * @return ContactMessage
     */
    public function setHasBeenAnswered(bool $hasBeenAnswered): self
    {
        $this->hasBeenAnswered = $hasBeenAnswered;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getName() : '---';
    }
}

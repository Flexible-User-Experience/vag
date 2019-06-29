<?php

namespace App\Entity;

use App\Entity\Traits\IsAvailableTrait;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventTicketRepository")
 */
class EventTicket extends AbstractEntity
{
    use IsAvailableTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EventActivity")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var EventActivity
     */
    private $activity;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $code;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTime
     */
    private $purchaseDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTime
     */
    private $checkinDate;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=1})
     *
     * @var bool
     */
    private $isAvailable;

    /**
     * Methods.
     */

    /**
     * @return EventActivity|null
     */
    public function getActivity(): ?EventActivity
    {
        return $this->activity;
    }

    /**
     * @param EventActivity|null $activity
     *
     * @return EventTicket
     */
    public function setActivity(?EventActivity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     *
     * @return EventTicket
     */
    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getPurchaseDate(): ?DateTimeInterface
    {
        return $this->purchaseDate;
    }

    /**
     * @return string
     */
    public function getPurchaseDateString(): string
    {
        return $this->getPurchaseDate() ? $this->getPurchaseDate()->format('d/m/Y H:i') : '---';
    }

    /**
     * @param DateTimeInterface|null $purchaseDate
     *
     * @return EventTicket
     */
    public function setPurchaseDate(?DateTimeInterface $purchaseDate): self
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCheckinDate(): ?DateTimeInterface
    {
        return $this->checkinDate;
    }

    /**
     * @return string
     */
    public function getCheckinDateString(): string
    {
        return $this->getCheckinDate() ? $this->getCheckinDate()->format('d/m/Y H:i') : '---';
    }

    /**
     * @param DateTimeInterface|null $checkinDate
     *
     * @return EventTicket
     */
    public function setCheckinDate(?DateTimeInterface $checkinDate): self
    {
        $this->checkinDate = $checkinDate;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getPurchaseDateString().' · '.$this->getActivity() : '---';
    }
}

<?php

namespace App\Entity;

use App\Entity\Traits\IsAvailableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactNewsletterRepository")
 * @ORM\Table()
 */
class ContactNewsletter extends AbstractContactPerson
{
    use IsAvailableTrait;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=1})
     *
     * @var bool
     */
    private $isAvailable;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=0})
     *
     * @var bool
     */
    private $legalTermsHasBeenAccepted;

    /**
     * Methods.
     */

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
     * @return ContactNewsletter
     */
    public function setLegalTermsHasBeenAccepted(?bool $legalTermsHasBeenAccepted): self
    {
        $this->legalTermsHasBeenAccepted = $legalTermsHasBeenAccepted;

        return $this;
    }
}

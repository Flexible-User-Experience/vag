<?php

namespace App\Entity\Traits;

use App\Entity\EventActivity;

/**
 * Trait ShortDescriptionTrait
 */
trait ShortDescriptionTrait
{
    /**
     * @return string|null
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     *
     * @return EventActivity
     */
    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }
}

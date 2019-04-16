<?php

namespace App\Entity\Traits;

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
     * @param string|null $shortDescription
     *
     * @return $this
     */
    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }
}

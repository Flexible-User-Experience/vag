<?php

namespace App\Entity\Traits;

use App\Entity\EventActivity;

/**
 * Trait DescriptionTrait
 */
trait DescriptionTrait
{
    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return EventActivity
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}

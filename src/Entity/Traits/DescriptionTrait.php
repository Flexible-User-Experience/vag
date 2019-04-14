<?php

namespace App\Entity\Traits;

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
     * @param string|null $description
     *
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}

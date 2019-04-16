<?php

namespace App\Entity\Traits;

/**
 * Trait IsAvailableTrait
 */
trait IsAvailableTrait
{
    /**
     * @return bool|null
     */
    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    /**
     * @return bool|null
     */
    public function isAvailable(): ?bool
    {
        return $this->getIsAvailable();
    }

    /**
     * @param bool|null $isAvailable
     *
     * @return $this
     */
    public function setIsAvailable(?bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }
}

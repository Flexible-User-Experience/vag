<?php

namespace App\Entity\Traits;

/**
 * Trait JobTrait
 */
trait JobTrait
{
    /**
     * @return string|null
     */
    public function getJob(): ?string
    {
        return $this->job;
    }

    /**
     * @param string|null $job
     *
     * @return $this
     */
    public function setJob(?string $job): self
    {
        $this->job = $job;

        return $this;
    }
}

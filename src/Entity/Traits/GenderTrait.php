<?php

namespace App\Entity\Traits;

/**
 * Trait GenderTrait
 */
trait GenderTrait
{
    /**
     * @return int|null
     */
    public function getGender(): ?int
    {
        return $this->gender;
    }

    /**
     * @param int|null $gender
     *
     * @return $this
     */
    public function setGender(?int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }
}

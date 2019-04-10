<?php

namespace App\Entity\Traits;

/**
 * Trait SurnameTrait
 */
trait SurnameTrait
{
    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     *
     * @return $this
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFullname(): ?string
    {
        return $this->name.' '.$this->surname;
    }
}

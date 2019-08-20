<?php

namespace App\Entity\Traits;

/**
 * Trait LinkNameTrait
 */
trait LinkNameTrait
{
    /**
     * @return string|null
     */
    public function getLinkName(): ?string
    {
        return $this->linkName;
    }

    /**
     * @param string|null $linkName
     *
     * @return $this
     */
    public function setLinkName(?string $linkName): self
    {
        $this->linkName = $linkName;

        return $this;
    }
}

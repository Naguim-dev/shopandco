<?php

namespace App\Entity\Traits;

trait Slug
{
    /**
     * @ORM\Column(type="string", length= 255 )
     */
    private $slug;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}

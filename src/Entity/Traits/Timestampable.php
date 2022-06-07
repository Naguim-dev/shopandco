<?php

namespace App\Entity\Traits;


trait Timestampable
{
    /**
     * @ORM\Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    private $updated_at;


    public function getCreated_at(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreated_at(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdated_at(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdated_at(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */

    public function updateTimestamps()
    {
        if ($this->getCreated_at() === null) {
            $this->setCreated_at(new \DateTime());
        }

        $this->setUpdated_at(new \DateTime());
    }
}

<?php

namespace App;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TimestampableEntity
 * @package App
 */
trait TimestampableEntity
{
    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $date = new \DateTime();
        $this->createdAt = $date;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAt()
    {
        $date = new \DateTime();
        $this->updatedAt = $date;
    }
}

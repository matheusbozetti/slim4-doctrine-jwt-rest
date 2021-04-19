<?php

namespace App\Models\Traits;

trait TimestampableModel
{
    /**
     * @var \DateTime
     *
     * @Column(type="datetime", nullable=true)
     */
    protected $created_at;

    /**
     * @var \DateTime
     *
     * @Column(type="datetime", nullable=true)
     */
    protected $updated_at;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTime $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @PrePersist
     * @PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime('now'));

        if (null == $this->getCreatedAt()) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }
}

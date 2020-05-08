<?php

namespace App\Core\Traits;

use App\Core\DatesService;
use Carbon\Carbon;

trait TimeRecordsTrait
{
    /**
     * @ORM\Column(name="createdAt", type="date", nullable=true)
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updatedAt", type="date", nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\Column(name="deletedAt", type="date", nullable=true)
     */
    protected $deletedAt;

    public function getCreatedAt($timezone = 'GMT'): ?\DateTime
    {
        if ($this->createdAt) {
            return Carbon::parse($this->createdAt)->setTimezone($timezone);
        }

        return null;
    }

    public function setCreatedAt($date): self
    {
        $this->createdAt = $this->dateOrNull($date);
        return $this;
    }

    public function getUpdatedAt($timezone = 'GMT'): ?\DateTime
    {
        if ($this->updatedAt) {
            return $this->updatedAt->setTimezone(new \DateTimeZone($timezone));
        }

        return null;
    }

    public function setUpdatedAt($date): self
    {
        $this->updatedAt = $this->dateOrNull($date);
        return $this;
    }

    public function getDeletedAt($timezone = 'GMT'): ?\DateTime
    {
        if ($this->deletedAt) {
            return $this->deletedAt->setTimezone(new \DateTimeZone($timezone));
        }

        return null;

    }

    public function setDeletedAt($date): self
    {
        $this->deletedAt = $this->dateOrNull($date);
        return $this;
    }

    public function isDeleted()
    {
        return $this->deletedAt != null;
    }

    public function populateDates(array $data = []): self
    {
        $currentDate = new Carbon();

        $this->setCreatedAt($currentDate)
            ->setUpdatedAt($currentDate);

        if (array_key_exists('created_at', $data)) {
            $this->setCreatedAt($data['created_at']);
        }

        if (array_key_exists('updated_at', $data)) {
            $this->setUpdatedAt($data['updated_at']);
        }

        if (array_key_exists('deleted_at', $data)) {
            $this->setDeletedAt($data['deleted_at']);
        }

        return $this;
    }

    protected function dateOrNull($date): ?\DateTime
    {
        if (is_a($date, \DateTime::class)) {
            return $date;
        }

        return $date ? Carbon::parse($date) : null;
    }
}

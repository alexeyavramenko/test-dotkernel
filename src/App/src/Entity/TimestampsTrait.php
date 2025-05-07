<?php

declare(strict_types=1);

namespace Api\App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
trait TimestampsTrait
{
    #[ORM\Column(name: "created_at", type: "datetime_immutable")]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(name: "changed_at", type: "datetime_immutable", nullable: true)]
    protected ?DateTimeImmutable $updatedAt = null;

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCreatedAtFormatted(string $dateFormat = 'Y-m-d H:i:s'): string
    {
        return $this->createdAt->format($dateFormat);
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getUpdatedAtFormatted(string $dateFormat = 'Y-m-d H:i:s'): ?string
    {
        if ($this->updatedAt instanceof DateTimeImmutable) {
            return $this->updatedAt->format($dateFormat);
        }

        return null;
    }

    #[ORM\PrePersist]
    public function createdAt(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function touch(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}

<?php

declare(strict_types=1);

namespace Api\Project\Entity;

use Api\App\Entity\AbstractEntity;
use Api\App\Entity\EntityInterface;
use Api\App\Entity\TimestampsTrait;
use Api\Project\Repository\ProjectRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Stdlib\ArraySerializableInterface;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ORM\Table("project")]
#[ORM\HasLifecycleCallbacks]
class Project extends AbstractEntity implements EntityInterface
{
    use TimestampsTrait;

    #[ORM\Id]
    #[ORM\Column(name: "project_id", type: "integer", unique: true)]
    protected int $projectId;

    #[ORM\Column(name: "title", type: "string", length: 100)]
    protected string $title;

    #[ORM\Column(name: "alias", type: "string", length: 100)]
    protected string $alias;

    public function __construct(string $title, string $alias, DateTimeImmutable $createdAt)
    {
        parent::__construct();

        $this->setTitle($title);
        $this->setAlias($alias);
        $this->createdAt($createdAt);
    }

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getArrayCopy(): array
    {
        return [
            'title' => $this->getTitle(),
            'alias' => $this->getAlias(),
            'createdAt' => $this->getCreatedAt(),
        ];
    }
}
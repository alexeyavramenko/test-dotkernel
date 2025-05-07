<?php

declare(strict_types=1);

namespace Api\Project\Service;

use Api\Project\Entity\Project;
use Api\Project\Repository\ProjectRepository;
use Dot\DependencyInjection\Attribute\Inject;
use DateTimeImmutable;

class ProjectService implements ProjectServiceInterface
{
    #[Inject(ProjectRepository::class)]
    public function __construct(protected ProjectRepository $projectRepository)
    {
    }

    public function getRepository(): ProjectRepository
    {
        return $this->projectRepository;
    }

    public function createProject(array $data): Project
    {
        $project = new Project(
            $data['title'],
            $data['alias'],
            new DateTimeImmutable($data['createdAt'])
        );

        return $this->projectRepository->saveProject($project);
    }

    public function getProjects(array $filters = [])
    {
        return $this->projectRepository->getProjects($filters);
    }
}
<?php

declare(strict_types=1);

namespace Api\Project\Repository;

use Api\App\Helper\PaginationHelper;
use Api\Project\Collection\ProjectCollection;
use Api\Project\Entity\Project;
use Doctrine\ORM\EntityRepository;
use Dot\DependencyInjection\Attribute\Entity;

/**
 * @extends EntityRepository<object>
 */
#[Entity(name: Project::class)]
class ProjectRepository extends EntityRepository
{
    public function saveProject(Project $project): Project
    {
        $this->getEntityManager()->persist($project);
        $this->getEntityManager()->flush();

        return $project;
    }

    public function getProjects(array $filters = []): ProjectCollection
    {
        $page = PaginationHelper::getOffsetAndLimit($filters);

        $qb = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('project')
            ->from(Project::class, 'project')
            ->orderBy($filters['order'] ?? 'project.createdAt', $filters['dir'] ?? 'desc')
            ->setFirstResult($page['offset'])
            ->setMaxResults($page['limit']);

        $qb->getQuery()->useQueryCache(true);

        return new ProjectCollection($qb, false);
    }
}
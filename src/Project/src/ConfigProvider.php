<?php

declare(strict_types=1);

namespace Api\Project;

use Api\Project\Collection\ProjectCollection;
use Api\Project\Entity\Project;
use Api\Project\Handler\ProjectHandler;
use Api\Project\Repository\ProjectRepository;
use Api\Project\Service\ProjectService;
use Api\Project\Service\ProjectServiceInterface;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Dot\DependencyInjection\Factory\AttributedRepositoryFactory;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;
use Mezzio\Application;
use Mezzio\Hal\Metadata\MetadataMap;
use Api\App\ConfigProvider as AppConfigProvider;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine' => $this->getDoctrineConfig(),
            MetadataMap::class => $this->getHalConfig(),
        ];
    }

    private function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class
                ]
            ],
            'factories' => [
                ProjectHandler::class    => AttributedServiceFactory::class,
                ProjectService::class    => AttributedServiceFactory::class,
                ProjectRepository::class => AttributedRepositoryFactory::class,
            ],
            'aliases'   => [
                ProjectServiceInterface::class     => ProjectService::class,
            ],
        ];
    }

    private function getDoctrineConfig(): array
    {
        return [
            'driver' => [
                'orm_default'   => [
                    'drivers' => [
                        'Api\Project\Entity' => 'ProjectEntities'
                    ],
                ],
                'ProjectEntities'  => [
                    'class' => AttributeDriver::class,
                    'cache' => 'array',
                    'paths' => __DIR__ . '/Entity',
                ],
            ],
        ];
    }

    private function getHalConfig(): array
    {
        return [
            AppConfigProvider::getCollection(ProjectCollection::class, 'projects.list', 'projects'),
            AppConfigProvider::getResource(Project::class, 'project.show', 'projectId', 'projectId'),
        ];
    }

}
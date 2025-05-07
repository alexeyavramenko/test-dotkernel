<?php

namespace Api\Project;

use Api\Project\Handler\ProjectHandler;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->get(
            '/projects',
            ProjectHandler::class,
            'projects.list'
        );

        $app->get(
            '/project/{projectId:\d+}',
            ProjectHandler::class,
            'project.show'
        );

        $app->post(
            '/project',
            ProjectHandler::class,
            'project.create'
        );

        return $app;
    }
}
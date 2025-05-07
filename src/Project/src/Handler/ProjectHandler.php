<?php

declare(strict_types=1);

namespace Api\Project\Handler;

use Api\App\Handler\AbstractHandler;
use Api\Project\Entity\Project;
use Api\Project\InputFilter\ProjectInputFilter;
use Api\Project\Service\ProjectServiceInterface;
use Dot\DependencyInjection\Attribute\Inject;
use Fig\Http\Message\StatusCodeInterface;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProjectHandler extends AbstractHandler implements RequestHandlerInterface
{
    #[Inject(
        ProjectServiceInterface::class,
        "config",
        HalResponseFactory::class,
        ResourceGenerator::class,
    )]
    public function __construct(
        protected ProjectServiceInterface $projectService,
        protected array $config,
        protected ?HalResponseFactory $responseFactory = null,
        protected ?ResourceGenerator $resourceGenerator = null,
    ) {
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $routeName = $request->getAttribute('Mezzio\Router\RouteResult')->getMatchedRouteName();

        if ($routeName === 'projects.list') {
            return $this->getCollection($request);
        }

        $project = $this->projectService->getRepository()->findOneBy(['projectId' => $request->getAttribute('projectId')]);

        if (! $project instanceof Project){
            return $this->notFoundResponse();
        }

        return $this->createResponse($request, $project);
    }

    public function getCollection(ServerRequestInterface $request): ResponseInterface
    {
        $projects = $this->projectService->getRepository()->getProjects($request->getQueryParams());

        return $this->createResponse($request, $projects);
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        $inputFilter = (new ProjectInputFilter())->setData($request->getParsedBody());
        if (! $inputFilter->isValid()) {
            return $this->errorResponse($inputFilter->getMessages(), StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY);
        }

        $project = $this->projectService->createProject($inputFilter->getValues());

        return $this->createResponse($request, $project);
    }
}
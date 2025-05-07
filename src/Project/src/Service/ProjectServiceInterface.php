<?php

declare(strict_types=1);

namespace Api\Project\Service;

use Api\Project\Repository\ProjectRepository;

interface ProjectServiceInterface
{
    public function getRepository(): ProjectRepository;
}
<?php

declare(strict_types=1);

namespace Api\Project\InputFilter;

use Api\Project\InputFilter\Input\AliasInput;
use Api\Project\InputFilter\Input\TitleInput;
use Api\Project\InputFilter\Input\CreatedAtInput;
use Laminas\InputFilter\InputFilter;

class ProjectInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(new TitleInput('title'));
        $this->add(new AliasInput('alias'));
        $this->add(new CreatedAtInput('createdAt'));
    }
}
<?php

declare(strict_types=1);

namespace Api\Project\InputFilter\Input;

use Api\App\Message;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\Input;
use Laminas\Validator\Date;
use Laminas\Validator\NotEmpty;

class CreatedAtInput extends Input
{
    public function __construct(?string $name = null, bool $isRequired = true)
    {
        parent::__construct($name);

        $this->setRequired($isRequired);

        $this->getFilterChain()
            ->attachByName(StringTrim::class)
            ->attachByName(StripTags::class);

        $this->getValidatorChain()
            ->attachByName(Date::class, [
                'message' => sprintf(Message::INVALID_VALUE, 'createdAt'),
            ], true);
    }
}
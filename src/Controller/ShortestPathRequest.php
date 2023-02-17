<?php

namespace App\Controller;

use App\Domain\Chess\Desk\Figure;
use OpenApi\Attributes\Property;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ShortestPathRequest
{
    #[Property(type: 'string', example: 'knight')]
    public mixed $figure = null;

    #[Property(type: 'string', example: 'a1')]
    #[Assert\Type(type: 'string')]
    #[Assert\Length(exactly: 2)]
    public mixed $startPosition = null;

    #[Property(type: 'string', example: 'd5')]
    #[Assert\Type(type: 'string')]
    #[Assert\Length(exactly: 2)]
    public mixed $finisPosition = null;

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context): void
    {
        if ($this->figure !== null && Figure::tryFrom($this->figure) === null) {
            $context->buildViolation('Not a valid figure. Taken: (' . $this->figure . ').')
                ->atPath('figure')
                ->addViolation();
        }
    }
}

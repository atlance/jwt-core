<?php

declare(strict_types=1);

namespace Atlance\JwtCore\Token\Validation\Constraint;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\Validation\Constraint as ConstraintInterface;
use Lcobucci\JWT\Validation\ConstraintViolation;

final class HasClaim implements ConstraintInterface
{
    private string $claim;

    public function __construct(string $claim)
    {
        $this->claim = $claim;
    }

    public function assert(Token $token): void
    {
        if (!$token->claims()->has($this->claim)) {
            throw new ConstraintViolation('The token does not have the claim "' . $this->claim . '"');
        }
    }
}
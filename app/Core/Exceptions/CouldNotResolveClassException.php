<?php

namespace App\Core\Exceptions;

use RuntimeException;
use Psr\Container\NotFoundExceptionInterface;

class CouldNotResolveClassException extends RuntimeException implements NotFoundExceptionInterface
{
}

<?php

namespace FOS\RestBundle\Tests\Fixtures\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Fixture for testing whether type-hinted parameters will be dealt with correctly
 */
class TypeHintedController
{

    /**
     * $method is a random type-hint
     */
    public function parametersAction(
        Request $request,
        ParamFetcherInterface $paramFetcherImplementation,
        ParamFetcher $paramFetcher,
        ConstraintViolationListInterface $constraint,
        \ReflectionMethod $method,
        $parameter
    )
    {}

}
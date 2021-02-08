<?php

namespace Knojector\SteamAuthenticationBundle\ArgumentResolver;

use Knojector\SteamAuthenticationBundle\DTO\SteamCallback;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author knojector <dev@knojector.xyz>
 */
class SteamCallbackResolver implements ArgumentValueResolverInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === SteamCallback::class;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $steamCallback = SteamCallback::fromRequest($request);

        $errors = $this->validator->validate($steamCallback);
        if (count($errors) > 0) {
            throw new BadRequestHttpException((string) $errors);
        }

        yield $steamCallback;
    }
}
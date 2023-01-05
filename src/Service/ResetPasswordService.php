<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Utils\FormModel\ResetPasswordRequestValidate;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ResetPasswordService extends JsonService
{
    private ValidatorInterface $validator;
    private UserRepository $userRepository;

    public function __construct(ValidatorInterface $validator, UserRepository $userRepository)
    {
        $this->validator = $validator;
        $this->userRepository = $userRepository;
    }
    
    public function validateParameters(ResetPasswordRequestValidate $object): void
    {
        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors[0]);
        }
    }

    public function checkUser($email)
    {
        if(!$user = $this->userRepository->findOneBy(['email' => $email])) {
            throw new BadRequestHttpException("user not found");
        }
    }
}
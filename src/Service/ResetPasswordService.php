<?php

namespace App\Service;

use App\Entity\User;
use App\Utility\ErrorList;
use App\Repository\UserRepository;
use App\Entity\ResetPasswordRequest;
use App\Repository\ResetPasswordRequestRepository;
use App\Utils\FormModel\ResetPasswordRequestValidate;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ResetPasswordService extends JsonService
{
    private ValidatorInterface $validator;
    private UserRepository $userRepository;
    private ResetPasswordRequestRepository $resetPasswordRequestRepository;

    public function __construct(
        ValidatorInterface $validator, 
        UserRepository $userRepository,
        ResetPasswordRequestRepository $resetPasswordRequestRepository
    ) {
        $this->validator = $validator;
        $this->userRepository = $userRepository;
        $this->resetPasswordRequestRepository = $resetPasswordRequestRepository;
    }
    
    public function validateParameters($object): void
    {
        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors[0]);
        }
    }

    public function checkUser(string $email): User
    {
        if(!$user = $this->userRepository->findOneBy(['email' => $email])) {
            throw new BadRequestHttpException(ErrorList::USER_NOT_FOUND);
        }

        if(count($reset = $user->getResetPasswordRequest())>0) {
            $this->resetPasswordRequestRepository->remove($reset[0]);
        }

        return $user;
    }

    public function createRequest(User $user, string $selector, string $token): void
    {
        $resetPasswordRequest = new ResetPasswordRequest();
        $resetPasswordRequest->setUserId($user);
        $resetPasswordRequest->setSelector($selector);
        $resetPasswordRequest->setHashedToken(hash('sha384', $token));

        $this->resetPasswordRequestRepository->save($resetPasswordRequest);
    }

    public function getResetRequest(string $selector, string $token): ResetPasswordRequest
    {
        if(!$resetRequest = $this->resetPasswordRequestRepository->findOneBy(['selector' => $selector])){
            throw new BadRequestHttpException(ErrorList::INVALID_TOKEN);
        }

        $token = hash('sha384', hex2bin($token));

        if (strcmp($token, $resetRequest->getHashedToken()) !== 0) {
            throw new BadRequestHttpException(ErrorList::INVALID_TOKEN);
        }

        return $resetRequest;
    }

    public function remove(ResetPasswordRequest $request): void
    {
        $this->resetPasswordRequestRepository->remove($request);
    }
}
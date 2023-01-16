<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use App\Service\ResetPasswordService;
use App\Form\ResetPasswordExecuteType;
use App\Form\ResetPasswordRequestType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Utility\FormModel\ResetPasswordExecuteValidate;
use App\Utility\FormModel\ResetPasswordRequestValidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/api/reset', name: 'app_reset_', format: 'json')]
class ResetPasswordController extends AbstractController
{
    #[Route('', name: 'request', methods: ['POST'])]
    public function request(Request $request, ResetPasswordService $resetPasswordService, MailerInterface $mailer): JsonResponse
    {
        $parameters = $resetPasswordService->validateJson($request->getContent());

        $resetRequestValidate = new ResetPasswordRequestValidate();
        $form = $this->createForm(ResetPasswordRequestType::class, $resetRequestValidate);
        $form->submit($parameters);

        $resetPasswordService->validateParameters($resetRequestValidate);
        $user = $resetPasswordService->checkUser($parameters['email']);

        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        $resetPasswordService->createRequest($user, $selector, $token);

        $link = sprintf('%s?token=%s%s', trim($parameters['link']), $selector, bin2hex($token));

        $email = (new Email())
            ->to($parameters['email'])
            ->subject('School - reset password link')
            ->text("Here is your reset password link: $link")
            ->html("<p>Here is your reset password link: <a href='$link'>$link</a></p>");

        $mailer->send($email);

        return $this->json([
            'status' => 'success'
        ]);
    }

    #[Route('/{token}', name: 'execute', methods: ['POST'])]
    public function execute(
        Request $request, 
        string $token, 
        ResetPasswordService $resetPasswordService,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        $parameters = $resetPasswordService->validateJson($request->getContent());

        $parameters['selector'] = substr($token, 0, 16);
        $parameters['token'] = substr($token, 16, strlen($token));

        $resetRequestExecute = new ResetPasswordExecuteValidate();
        $form = $this->createForm(ResetPasswordExecuteType::class, $resetRequestExecute);
        $form->submit($parameters);

        $resetPasswordService->validateParameters($resetRequestExecute);
        $resetRequest = $resetPasswordService->getResetRequest($parameters['selector'], $parameters['token']);

        if($resetRequest->isExpired()) {
             $resetPasswordService->remove($resetRequest);
            return $this->json([
                'status' => 'Token expired.',
            ]);
        }

        $user = $resetRequest->getUserId();
        $hashedPassword = $passwordHasher->hashPassword($user, $parameters['password']);
        $user->setPassword($hashedPassword);

        $resetPasswordService->remove($resetRequest);

        return $this->json([
            'status' => 'success'
        ]);
    }
}
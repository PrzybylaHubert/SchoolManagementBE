<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use App\Service\ResetPasswordService;
use App\Form\ResetPasswordRequestType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Utils\FormModel\ResetPasswordRequestValidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        return $this->json([
            'request' => $link
        ]);
    }

    #[Route('{token}', name: 'execute', methods: ['POST'])]
    public function execute(Request $request, string $token): JsonResponse
    {

    }
}
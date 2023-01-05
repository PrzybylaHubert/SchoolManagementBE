<?php

namespace App\Controller;

use App\Service\ResetPasswordService;
use App\Form\ResetPasswordRequestType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Utils\FormModel\ResetPasswordRequestValidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/reset', name: 'app_reset_', format: 'json')]
class ResetPasswordController extends AbstractController
{
    #[Route('', name: 'request', methods: ['POST'])]
    public function request(Request $request, ResetPasswordService $resetPasswordService): JsonResponse
    {
        $parameters = $resetPasswordService->validateJson($request->getContent());

        $resetRequestValidate = new ResetPasswordRequestValidate();
        $form = $this->createForm(ResetPasswordRequestType::class, $resetRequestValidate);
        $form->submit($parameters);

        $resetPasswordService->validateParameters($resetRequestValidate);
        $resetPasswordService->checkUser($parameters['email']);

        return $this->json([
            'request' => "test"
        ]);
    }
}
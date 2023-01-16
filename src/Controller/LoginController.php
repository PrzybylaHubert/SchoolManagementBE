<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginController extends AbstractController
{
    #[Route('/api/login', name: 'app_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        $user = $this->getUser();

        return $this->json([
            'user' => $user->getUserIdentifier()
        ]);
    }

    #[Route('/api/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
    }
}
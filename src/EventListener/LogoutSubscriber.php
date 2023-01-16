<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LogoutSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [LogoutEvent::class => 'onLogout'];
    }

    public function onLogout(LogoutEvent $event): void
    {
        $response = new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
        $event->setResponse($response);
    }
}
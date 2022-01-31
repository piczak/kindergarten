<?php

namespace App\EventSubscriber;

use App\Entity\Redirect;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ExceptionSubscriber
 * @package App\EventSubscriber
 */
class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * ExceptionSubscriber constructor.
     * @param EntityManagerInterface $entityManager
     * @param RequestStack $requestStack
     */
    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;

        $this->requestStack = $requestStack;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => ['onException', 100]
        ];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onException(ExceptionEvent $event)
    {
        if ($event->getThrowable() instanceof NotFoundHttpException) {
            $item = $this->entityManager
                ->getRepository(Redirect::class)
                ->findOneBy([
                    'fromLink' => trim($this->requestStack->getCurrentRequest()->getRequestUri(), '/'),
                    'isActive' => true
                ]);

            if ($item) {
                $response = new RedirectResponse($item->getToLink());
                $event->setResponse($response);
            } else {
                if (preg_match('/\/([0-9]+)\/(.*?)\/reviews\//', $event->getRequest()->getUri(), $matches)) {

                    $response = new RedirectResponse('/' . $matches[1] . '/' . $matches[2] . '/');
                    $event->setResponse($response);
                } else {
                    $response = new RedirectResponse('/');
                    $event->setResponse($response);
                }
            }
        }
    }
}

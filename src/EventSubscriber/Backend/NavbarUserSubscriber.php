<?php

namespace App\EventSubscriber\Backend;

use App\Entity\User;
use KevinPapst\AdminLTEBundle\Event\ShowUserEvent;
use KevinPapst\AdminLTEBundle\Event\ThemeEvents;
use KevinPapst\AdminLTEBundle\Model\NavBarUserLink;
use KevinPapst\AdminLTEBundle\Model\UserModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class NavbarUserSubscriber
 * @package App\EventSubscriber
 */
class NavbarUserSubscriber implements EventSubscriberInterface
{
    /**
     * @var Security
     */
    protected $security;

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * NavbarUserSubscriber constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ThemeEvents::THEME_NAVBAR_USER => ['onShowUser', 100],
            ThemeEvents::THEME_SIDEBAR_USER => ['onShowUser', 100],
        ];
    }

    /**
     * @param ShowUserEvent $event
     */
    public function onShowUser(ShowUserEvent $event)
    {
        if (null === $this->security->getUser()) {
            return;
        }

        /* @var $myUser User */
        $myUser = $this->security->getUser();

        $user = new UserModel();
        $user
            ->setId($myUser->getId())
            ->setName($myUser->getUsername())
            ->setUsername($myUser->getUsername())
            ->setIsOnline(true)
            ->setTitle('Administrator')
            ->setMemberSince($myUser->getMemberSince())
        ;

        $event->setUser($user);
        $event->addLink(new NavBarUserLink('Zmień hasło', 'admin.profile.password'));
    }
}

<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\ORM\EntityManagerInterface;

class LocaleSubscriber implements EventSubscriberInterface
{
    private $container;
    private $defaultLocale;
    private $em;
    private $session;
    public function __construct($defaultLocale = 'en', EntityManagerInterface $em, SessionInterface $session)
    {
        $this->defaultLocale = $defaultLocale;
        $this->em = $em;
        $this->session = $session;
    }

    /**
     * when the request come from the app
     *
     * @param GetResponseEvent $event
     * @return void
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            //return;
        }
        // try to see if the locale has been set as a _locale or lang routing or query parameter
        if ($locale = $request->query->get('lang')) {
            $request->getSession()->set('_locale', $locale);
            $request->setLocale($locale);
        } else {
            // if no explicit locale has been set on this request, use one from the session
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        $login = $event->getAuthenticationToken()->getUser();
        $user_repo = $this->em->getRepository('App:User');
        $user = $user_repo->findByUsername($login->getUsername())[0];
        $this->session->set('user_fullname', $user->getFirstname().' '.$user->getLastname());
        $this->session->set('user_email', $user->getEmail());
        $this->session->set('user_avatar', $user->getImage());
        if (null !== $user->getLocale()) {
            $this->session->set('_locale', $user->getLocale());
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 15)),
            SecurityEvents::INTERACTIVE_LOGIN => array(array('onInteractiveLogin', 15)),
        );
    }
}
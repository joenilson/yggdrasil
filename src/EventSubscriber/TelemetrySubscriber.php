<?php

namespace App\EventSubscriber;

use App\Functions\UserUtils;
use App\Functions\BaseConfig;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


class TelemetrySubscriber implements EventSubscriberInterface
{
    public $baseConfig;
    public $container;
    public $session;
    public $em;
    public $encoder;
    public function __construct(EntityManagerInterface $em, EncoderFactoryInterface $encoder, BaseConfig $baseConfig, ContainerInterface $container, RouterInterface $routerInterface, SessionInterface $session)
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->container = $container;
        $this->session = $session;
        $this->baseConfig = $baseConfig;
        $this->routerInterface = $routerInterface;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 10)),
            SecurityEvents::INTERACTIVE_LOGIN => array(array('onInteractiveLogin', 10)),
        );
    }

    public function initDatabase()
    {

        $this->databaseConfig = [
            'dbport'=> $_SERVER['database_port'],
            'dbhost'=> $_SERVER['database_host'],
            'dbname'=> $_SERVER['database_name'],
            'dbuser'=> $_SERVER['database_user'],
            'dbpass'=> $_SERVER['database_password'],
            'dbtype'=> $_SERVER['database_driver']
        ];
        $conn = new BaseConfig();
        return $conn->verifyDatabase($_SERVER['DATABASE_URL']);
    }

    public function verifyDatabase()
    {
        $verifyDatabase = $this->initDatabase();
        if($verifyDatabase == 'app-db-non-exists'){
            return false;
        }
        return true;
    }

    public function verifyAdminPassword(){
        $userUtils = new UserUtils();
        $verifyDatabase = $this->initDatabase();
        if($verifyDatabase !== 'app-db-non-exists'){
            $users = $this->em->getRepository('App:Login');
            $user = $users->findByUsername('admin')[0];
            if($user){
                $encoder = $this->encoder->getEncoder($user);
                $status = $userUtils->verifyFirstPassword($encoder, $user, $this->em);
                if($status == 'admin-password-is-not-default'){
                   return true;
                }
                return false;
            }
            return false;
        }
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $response = $event->getResponse();
        $request = $event->getRequest();
        if($this->verifyDatabase()){
            if($response instanceof RedirectResponse) {
                try {
                    $this->matchResponseWithRouter($response);
                }catch(ResourceNotFoundException $e) {
                    $this->redirectToSafePage($response);
                }
            }
        }else{
            if($request->get('_route') !== 'config_system' && $request->get('_route') !== null && $request->get('_route') !== '_wdt'){
                return $event->setResponse(
                    new RedirectResponse(
                        $this->routerInterface->generate('config_system')
                    )
                );
            }
        }
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        if($this->verifyAdminPassword()){
            $this->app_configured = true;
        }
    }

    /**
     * @param $response
     * @throws ResourceNotFoundException
     */
    protected function matchResponseWithRouter($response) {
        $url = $response->getTargetUrl();
        $this->router->match($url);
    }

    protected function redirectToSafePage($response) {
        $response->setTargetUrl('/');
    }
}
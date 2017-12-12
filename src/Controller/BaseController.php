<?php

namespace App\Controller;

use App\Entity\User;
use App\Functions\UserUtils;
use App\Functions\BaseConfig;
use Doctrine\ORM\EntityManagerInterface;
use App\EventSubscriber\TelemetrySubscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class BaseController extends Controller 
{
    public $baseConfig;
    public $i18n;
    public $databaseConfig;
    /**
     * EntityManager variable for all Controllers behind BaseController
     *
     * @var object \Doctrine\EntityManagerInterface
     */
    public $em;
    /**
     * Information about the app configuration process
     *
     * @var boolean
     */
    public $app_configured = false;

    public $encoder;
    public $request;
    public $session;
    public $container;
    public function __construct(EntityManagerInterface $em, EncoderFactoryInterface $encoder, RequestStack $requestStack, SessionInterface $session, ContainerInterface $container, TelemetrySubscriber $telemetry)
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->app_configured = $telemetry->verifyAdminPassword();
        $this->request = $requestStack->getCurrentRequest();
        $this->session = $session;
        $this->container = $container;
    }

    public function initDatabase()
    {
        /*
        $this->databaseConfig = [
            'dbport'=> $this->getParameter('database_port'),
            'dbhost'=> $this->container->getParameter('database_host'),
            'dbname'=> $this->container->getParameter('database_name'),
            'dbuser'=> $this->container->getParameter('database_user'),
            'dbpass'=> $this->container->getParameter('database_password'),
            'dbtype'=> $this->container->getParameter('database_driver')
        ];
        */
        dump($this->getParameter('DATABASE_URL'));
        $conn = new BaseConfig();
        return $conn->verifyDatabase($this->databaseConfig);
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
            $users = $this->em->getRepository('App:User');
            $user = $users->findByUsername('admin')[0];
            if($user){
                $encoder = $this->encoder->getEncoder($user);
                $status = $userUtils->verifyFirstPassword($encoder, $user, $this->em);
                if($status == 'admin-password-is-not-default'){
                    $this->app_congurated = true;
                }
            }
        }
    }
}
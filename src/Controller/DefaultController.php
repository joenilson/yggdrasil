<?php

namespace App\Controller;

use App\Form\ChangePassword;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use App\Functions\UserUtils;

class DefaultController extends BaseController
{
    public function index(Request $request)
    {
        $dataResponse = [];
        $userUtils = new UserUtils();
        $user = $this->getUser();
        if($user){
            $changePassword = new \StdClass();
            $changePassword->username = $user->getUsername();
            $changePassword->oldpassword = null;
            $changePassword->password = null;
            $form = $this->createForm(ChangePassword::class, $changePassword);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $encoder = $this->encoder->getEncoder($user);
                $userUtils->verifyChangePassword($form, $encoder, $user, $this->em, $request);
            }
            $dataResponse['form'] = $form->createView();
        }
        $verifyDatabase = $this->initDatabase();
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') AND $verifyDatabase != 'app-db-non-exists') {
            throw $this->createAccessDeniedException();
        }

        $dataResponse['base_dir'] = realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR;
        $dataResponse['verify_database'] = $verifyDatabase;
        $dataResponse['app_configured'] = $this->app_configured;

        $dataResponse['dashboard_tiles'][] = ['title'=>'100000.25','subtitle'=>'Compras'];
        $dataResponse['dashboard_tiles'][] = ['title'=>'1000000.05','subtitle'=>'Ventas'];
        $dataResponse['dashboard_tiles'][] = ['title'=>'900000.78','subtitle'=>'Caja y Banco'];
        $dataResponse['dashboard_tiles'][] = ['title'=>'100','subtitle'=>'Nuevos Clientes'];

        return $this->render('default/index.html.twig', $dataResponse );
    }

}
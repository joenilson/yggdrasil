<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Form\ChangePassword;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;
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

        return $this->render('default/index.html.twig', $dataResponse );
    }

}
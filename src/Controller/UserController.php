<?php

namespace App\Controller;

use App\Form\UserType;
use App\Form\ChangePassword;
use App\Functions\UserUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends BaseController
{
    public function login(Request $request, AuthenticationUtils $authUtils)
    {

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'csrf' => $request,
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }

    public function changePassword(Request $request)
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
        return $this->render('user/change_password.html.twig', $dataResponse );
    }

    public function checkToken()
    {

    }

    public function userInfo(Request $request)
    {
        $user = $this->getUser();
        $user_repo = $this->em->getRepository('App:User');
        $user_info = $user_repo->findByUsername($user->getUsername())[0];
        $form = $this->createForm(UserType::class, $user_info);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $encoder = $factory->getEncoder($user);
            $userUtils->verifyChangePassword($form, $encoder, $user, $this->em, $request);
        }
        return $this->render('user/user_info.html.twig',[
            'currentUser' => $this->getUser(),
            'form'=> $form->createView(),
            'user_info' => $user_info
        ]);
    }
}
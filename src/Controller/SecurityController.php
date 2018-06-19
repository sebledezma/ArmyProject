<?php
/**
 * Created by PhpStorm.
 * UserImport: anon
 * Date: 6/19/18
 * Time: 10:03 PM
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\UserImport;

class SecurityController extends  Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    public function registerAction(Request $request)
    {
        $user = new UserImport();
        $uname = $request->request->get("_username");
        $clearpass = $request->request->get("_password");
        $hashpass = $this->get('security.password_encoder')->encodePassword($user, $clearpass);
        $user->setUserEmail($uname);
        $user->setUserPass($hashpass);
        $user->setUserGroup("ADMIN");
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute("login");
    }

    public function logoutAction(Request $request)
    {
    }
}
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
use App\Entity\User;
//use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends  Controller
{
    public function loginAction()
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
//        $authenticationUtils = $this->get('security.authentication_utils');
//        $error = $authenticationUtils->getLastAuthenticationError();
//        return $this->render('register.html.twig', array('error' => $error));
        $user = new User();
        $role = $request->get('_role');
        $uname = $request->get("_username");
        $clearpass = $request->get("_password");
        $hashpass = $this->get('security.password_encoder')->encodePassword($user, $clearpass);
        $user->setUserMail($uname);
        $user->setUserPass($hashpass);
        if ($role)
            $user->setUserGroup("SOLDIER");
        else
            $user->setUserGroup("SERGENT");
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute("login");
    }

    public function logoutAction(Request $request)
    {

    }
}
<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    public function loginAction(AuthenticationUtils $helper)
    {
        return $this->render(
            '@App/Layout/login.html.twig',
            [
                'last_username' => $helper->getLastUsername(),
                'error' => $helper->getLastAuthenticationError()
            ]
        );
    }

    public function loginCheckAction()
    {

    }

    public function logoutAction()
    {

    }
}
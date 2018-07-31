<?php

namespace AppBundle\Listeners;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener
{
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function onLogin(InteractiveLoginEvent $event)
    {
        $name = $event->getAuthenticationToken()->getUser()->getName();

        $message = (new \Swift_Message('Login Email'))
            ->setFrom('nikitadada@gmail.com')
            ->setTo('nikitadada@gmail.com')
            ->setBody(
                $this->templating->render(
                    '@App/Emails/login.html.twig',
                    array('name' => $name)
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

}
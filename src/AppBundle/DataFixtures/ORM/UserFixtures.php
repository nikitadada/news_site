<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail($this->container->getParameter('admin_email'));
        $user->setName('Admin');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $this->container->getParameter('admin_password'));
        $user->setPassword($password);
        $user->setRole('ROLE_USER');

        $manager->persist($user);

        $manager->flush();
    }

}
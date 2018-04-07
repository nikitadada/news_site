<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{

    public function indexAction(Request $request)
    {
        $newsRepository = $this->getDoctrine()->getRepository('AppBundle:News');
        $news = $newsRepository->findAll();
        return $this->render('@App/News/list.html.twig', [
            'news' => $news
        ]);
    }

    public function newsAction($id)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}

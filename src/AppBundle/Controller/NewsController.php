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
        $newsRepository = $this->getDoctrine()->getRepository('AppBundle:News');
        $news = $newsRepository->find($id);
        if(!$news) {
            throw $this->createNotFoundException('News is not found');
        }
        return $this->render('@App/News/view.html.twig', [
            'news' => $news
        ]);
    }
}

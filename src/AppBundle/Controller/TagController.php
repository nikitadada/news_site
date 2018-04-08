<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TagController extends Controller
{
    public function indexAction()
    {
        $tagsRepository = $this->getDoctrine()->getRepository('AppBundle:Tag');
        $tags = $tagsRepository->findAll();
        return $this->render('@App/Tag/list.html.twig', [
            'tags' => $tags
        ]);
    }

    public function viewAction($id)
    {
        $tagsRepository = $this->getDoctrine()->getRepository('AppBundle:Tag');
        $tag = $tagsRepository->find($id);
        if(!$tag) {
            throw $this->createNotFoundException('Tag is not found');
        }
        return $this->render('@App/Tag/view.html.twig', [
            'tag' => $tag
        ]);
    }
}

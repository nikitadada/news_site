<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use AppBundle\Form\NewsForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{

    public function indexAction()
    {
        $newsRepository = $this->getDoctrine()->getRepository('AppBundle:News');
        $news = $newsRepository->findAll();
        return $this->render('@App/News/list.html.twig', [
            'news' => $news
        ]);
    }

    public function viewAction($id)
    {
        $newsRepository = $this->getDoctrine()->getRepository('AppBundle:News');
        $news = $newsRepository->find($id);
        if (!$news) {
            throw $this->createNotFoundException('News is not found');
        }
        return $this->render('@App/News/view.html.twig', [
            'news' => $news
        ]);
    }

    public function addAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm(NewsForm::class, $news);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $file = $news->getImage();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('files_directory'),
                $fileName
            );

            $news->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();
        }
        return $this->render('@App/News/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}

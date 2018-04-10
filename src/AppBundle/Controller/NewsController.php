<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use AppBundle\Entity\Tag;
use AppBundle\Form\NewsDeleteForm;
use AppBundle\Form\NewsForm;
use AppBundle\Service\FileManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    public function searchAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository(Tag::class)->find($id);
        $news = $em->getRepository(News::class)->findByTag($tag);
        $tags = $em->getRepository(Tag::class)->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $news,
            $request->query->getInt('page', 1),
            3
        );

        if ($request->isXmlHttpRequest()) {
            return $this->render('@App/News/region.html.twig', [
                'pagination' => $pagination
            ]);
        } else {
            return $this->render('@App/News/list.html.twig', [
                'pagination' => $pagination,
                'tags' => $tags
            ]);
        }
    }

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository(News::class)->findAll();
        $tags = $em->getRepository(Tag::class)->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $news,
            $request->query->getInt('page', 1),
            3
        );

        if ($request->isXmlHttpRequest()) {
            return $this->render('@App/News/region.html.twig', [
                'pagination' => $pagination
            ]);
        } else {
            return $this->render('@App/News/list.html.twig', [
                'pagination' => $pagination,
                'tags' => $tags
            ]);
        }

    }

    public function viewAction($id)
    {
        $newsRepository = $this->getDoctrine()->getRepository('AppBundle:News');
        $news = $newsRepository->find($id);

        $tagsRepository = $this->getDoctrine()->getRepository('AppBundle:Tag');
        $tags = $tagsRepository->findAll();
        if (!$news) {
            throw $this->createNotFoundException('News is not found');
        }
        return $this->render('@App/News/view.html.twig', [
            'news' => $news,
            'tags' => $tags
        ]);
    }

    public function addAction(Request $request, FileManager $fileManager)
    {
        $news = new News();
        $form = $this->createForm(NewsForm::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $news->getImage();

            $fileName = $fileManager->upload($file);

            $news->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();
            return $this->redirectToRoute('news_view', ['id' => $news->getId()]);
        }
        $tagsRepository = $this->getDoctrine()->getRepository('AppBundle:Tag');
        $tags = $tagsRepository->findAll();
        return $this->render('@App/News/add.html.twig', [
            'form' => $form->createView(),
            'tags' => $tags
        ]);
    }

    public function editAction(Request $request, FileManager $fileManager, News $news = null)
    {
        if (!$news) {
            throw $this->createNotFoundException('News is not found');
        }

        $oldFileName = $news->getImage();
        $news->setImage(new File($this->getParameter('files_directory') . '/' . $news->getImage()));
        $form = $this->createForm(NewsForm::class, $news);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileManager->removeFile($oldFileName);

            $news = $form->getData();
            $file = $form->get('image')->getData();

            $fileName = $fileManager->upload($file);

            $news->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();
            $this->addFlash('success', 'News edited!');
            return $this->redirectToRoute('news_edit', ['id' => $news->getId()]);
        }
        $tagsRepository = $this->getDoctrine()->getRepository('AppBundle:Tag');
        $tags = $tagsRepository->findAll();
        return $this->render('@App/News/edit.html.twig', [
            'form' => $form->createView(),
            'tags' => $tags
        ]);
    }

    public function removeAction(Request $request, FileManager $fileManager, News $news = null)
    {
        if (!$news) {
            throw $this->createNotFoundException('News is not found');
        }
        $em = $this->getDoctrine()->getManager();

        foreach ($news->getTags() as $tag) {
            $news->removeTag($tag);
            $em->persist($tag);
        }
        $em->flush();

        $oldFileName = $news->getImage();
        $form = $this->createForm(NewsDeleteForm::class, $news);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $fileManager->removeFile($oldFileName);

            $em = $this->getDoctrine()->getManager();
            $em->remove($news);
            $em->flush();
            return $this->redirectToRoute('news_list', ['id' => $news->getId()]);
        }
        $tags = $em->getRepository(Tag::class)->findAll();
        return $this->render('@App/News/delete.html.twig', [
            'form' => $form->createView(),
            'tags' => $tags
        ]);
    }
}

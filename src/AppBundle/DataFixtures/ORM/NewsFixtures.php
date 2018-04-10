<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\News;
use AppBundle\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class NewsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tags = [];

        $tag = new Tag();
        $tag->setTitle("sport");
        $tags[] = $tag;

        $tag = new Tag();
        $tag->setTitle("fashion");
        $tags[] = $tag;

        $tag = new Tag();
        $tag->setTitle("politics");
        $tags[] = $tag;

        for ($i = 0; $i < 20; $i++) {
            $news = new News();
            $news->setTitle('news number ' . $i);
            $news->setText('Lorem ipsum dolor sit amet...');
            $news->setImage('news.jpg');
            $news->addTag($tags[mt_rand(0, 2)]);

            $manager->persist($news);
        }

        $manager->flush();
    }

}
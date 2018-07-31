<?php

namespace AppBundle\Repository;

use AppBundle\Entity\News;
use AppBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;

class NewsRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->createQueryBuilder("n")->getQuery();
    }

    public function findByTag(Tag $tag)
    {
        $qb = $this->createQueryBuilder('n')
            ->add('select', 'n')
            ->leftJoin('n.tags', 't')
            ->where('t.title = :tag')
            ->setParameter('tag', $tag->getTitle());
        return $qb->getQuery();
    }
}
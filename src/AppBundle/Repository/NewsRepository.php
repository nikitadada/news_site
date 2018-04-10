<?php

namespace AppBundle\Repository;

use AppBundle\Entity\News;
use AppBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;

class NewsRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->createQueryBuilder("n");
    }

    public function findByTag(Tag $tag)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->add('select', 'n');
        $qb->leftJoin('n.tags', 't');
        $qb->where('t.title = :tag');
        $qb->setParameter('tag', $tag->getTitle());
        return $qb->getQuery();
    }
}
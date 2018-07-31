<?php

namespace AppBundle\Service;

use Doctrine\ORM\Query;
use Knp\Component\Pager\Paginator;

class PaginationManager
{
    public function getPagination(Query $collection, int $page, Paginator $paginator)
    {
        $pagination = $paginator->paginate(
            $collection,
            $page,
            3
        );

        return $pagination;
    }

}
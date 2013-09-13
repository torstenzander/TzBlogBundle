<?php
namespace Tz\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{

       public function findOrderedPosts(){
           $query = $this->createQueryBuilder('post')
               ->select('post')
               ->orderBy('post.createdAt', 'DESC')
               ->getQuery();
           return $query->getResult();
       }
}

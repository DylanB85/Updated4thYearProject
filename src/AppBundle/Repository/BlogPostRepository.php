<?php

namespace AppBundle\Repository;

use AppBundle\Entity\BlogPost;
use Doctrine\ORM\Mapping;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BlogPostRepository extends \Doctrine\ORM\EntityRepository
{
}
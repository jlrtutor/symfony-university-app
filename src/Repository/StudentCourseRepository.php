<?php

namespace App\Repository;

use App\Entity\StudentCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StudentCourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentCourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentCourse[]    findAll()
 * @method StudentCourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentCourseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StudentCourse::class);
    }
}

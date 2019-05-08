<?php

namespace App\Repository;

use App\Entity\StudentSubject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class StudentSubjectRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StudentSubject::class);
    }

    public function getNumSubject($student_id, $course_id, $level)
    {
        return $this->createQueryBuilder('s')
            ->select('COUNT(s.id) as total')
            ->andWhere('s.student = :student')
            ->andWhere('s.course = :course')
            ->andWhere('s.level = :level')
            ->setParameter('student', $student_id)
            ->setParameter('course', $course_id)
            ->setParameter('level', $level)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getNumSubjectsApprovedByStudent($student_id, $course_id, $level)
    {
        return $this->createQueryBuilder('s')
            ->select('COUNT(s.id) as total')
            ->andWhere('s.student = :student')
            ->andWhere('s.course = :course')
            ->andWhere('s.level = :level')
            ->andWhere('s.grade >= 5')
            ->setParameter('student', $student_id)
            ->setParameter('course', $course_id)
            ->setParameter('level', $level)
            ->getQuery()
            ->getSingleScalarResult();
    }


    public function getAVGCourse($student_id, $course_id, $level)
    {
        return $this->createQueryBuilder('s')
            ->select('AVG(s.grade) as grade')
            ->andWhere('s.student = :student')
            ->andWhere('s.course = :course')
            ->andWhere('s.level = :level')
            ->setParameter('student', $student_id)
            ->setParameter('course', $course_id)
            ->setParameter('level', $level)
            ->getQuery()
            ->getSingleScalarResult();
    }
    

    /*
    public function findOneBySomeField($value): ?StudentSubject
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

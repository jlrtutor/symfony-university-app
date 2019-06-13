<?php

namespace App\Repository;

use App\Entity\StudentSubject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StudentSubject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentSubjectRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StudentSubject::class);
    }


    public function getGrades($student_id, $course_id, $level)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
        ->select( ['s.id', 's.name', 's.type', 's.semester', 's.credits', 'ss.grade'] )
        ->from('App\Entity\Subject', 's')
        ->leftJoin('App\Entity\StudentSubject', 'ss', 'WITH',  'ss.student = :student AND ss.level = :level AND s.id = ss.subject')
        ->where('s.course = :course')
        ->andWhere('s.isActive = :active')
        ->addOrderBy('s.semester')
        ->addOrderBy('s.name')
        ->setParameters(  [ 'course'=>$level, 
                            'active'=>1,
                            'student'=>$student_id,
                            'level'=>$level ] );

        return $query->getQuery()->getResult();
    }

    public function getSubjects($course_id)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
        ->select( ['s.id', 's.name', 's.type', 's.semester', 's.credits'] )
        ->from('App\Entity\Subject', 's')
        ->where('s.course = :course')
        ->andWhere('s.isActive = :active')
        ->addOrderBy('s.semester')
        ->addOrderBy('s.name')
        ->setParameters(  [ 'course'=>$course_id, 
                            'active'=>1 ] );

        return $query->getQuery()->getResult();
    }


    public function getNumSubject($course_id)
    {
        $em = $this->getEntityManager();
        
        return $em->createQueryBuilder()
            ->from('App\Entity\Subject', 's')
            ->select('COUNT(s.id) as total')
            ->where('s.course = :course')
            ->setParameter('course', $course_id)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getNumSubject_($student_id, $course_id, $level)
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

}

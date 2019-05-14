<?php
// src/Form/DataTransformer/StudentToNumberTransformer.php
namespace App\Form\DataTransformer;

use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StudentToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (Student) to a string (number).
     *
     * @param  Student|null $student
     * @return string
     */
    public function transform($student)
    {
        if (null === $student) {
            return '';
        }

        return $student->getId();
    }

    /**
     * Transforms a string (number) to an object (Student).
     *
     * @param  string $student_id
     * @return Student|null
     * @throws TransformationFailedException if object (Student) is not found.
     */
    public function reverseTransform($student_id)
    {
        $student = $this->entityManager
            ->getRepository(Student::class)
            // query for the Student with this id
            ->find($student_id)
        ;

        if (null === $student) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An Student with Id "%s" does not exist!',
                $student_id
            ));
        }

        return $student;
    }
}
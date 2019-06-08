<?php
// src/Form/DataTransformer/CourseToNumberTransformer.php
namespace App\Form\DataTransformer;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CourseToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (Course) to a string (number).
     *
     * @param  Course|null $course
     * @return string
     */
    public function transform($course)
    {
        if (null === $course) {
            return '';
        }

        return $course->getId();
    }

    /**
     * Transforms a string (number) to an object (Course).
     *
     * @param  string $course_id
     * @return Course|null
     * @throws TransformationFailedException if object (Course) is not found.
     */
    public function reverseTransform($course_id)
    {
        $course = $this->entityManager
            ->getRepository(Course::class)
            // query for the course with this id
            ->find($course_id)
        ;

        if (null === $course) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'A Course with Id "%s" does not exist!',
                $student_id
            ));
        }

        return $student;
    }
}
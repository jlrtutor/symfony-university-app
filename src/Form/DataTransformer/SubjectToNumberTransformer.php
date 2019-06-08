<?php
// src/Form/DataTransformer/SubjectToNumberTransformer.php
namespace App\Form\DataTransformer;

use App\Entity\Subject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SubjectToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (Subject) to a string (number).
     *
     * @param  Subject|null $subject
     * @return string
     */
    public function transform($subject)
    {
        if (null === $subject) {
            return '';
        }

        return $subject->getId();
    }

    /**
     * Transforms a string (number) to an object (Subject).
     *
     * @param  string $subject_id
     * @return Subject|null
     * @throws TransformationFailedException if object (Subject) is not found.
     */
    public function reverseTransform($subject_id)
    {
        $subject = $this->entityManager
            ->getRepository(Subject::class)
            // query for the Subject with this id
            ->find($subject_id)
        ;

        if (null === $subject) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'A Subject with Id "%s" does not exist!',
                $subject_id
            ));
        }

        return $subject;
    }
}
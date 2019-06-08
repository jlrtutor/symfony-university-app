<?php

namespace App\Form;

use App\Entity\StudentSubject;
use App\Form\DataTransformer\CourseToNumberTransformer;
use App\Form\DataTransformer\StudentToNumberTransformer;
use App\Form\DataTransformer\SubjectToNumberTransformer;
use App\Form\Type\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentSubjectType extends AbstractType
{
    private $courseTransformer;
    private $studentTransformer;
    private $subjectTransformer;

    public function __construct(CourseToNumberTransformer $courseTransformer,
                                StudentToNumberTransformer $studentTransformer,
                                SubjectToNumberTransformer $subjectTransformer)
    {
        $this->courseTransformer = $courseTransformer;
        $this->studentTransformer = $studentTransformer;
        $this->subjectTransformer = $subjectTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('student', HiddenType::class)
        ->add('subject', HiddenType::class)
        ->add('course', HiddenType::class)
        ->add('level', HiddenType::class)
        ->add('grade', FloatType::class, [
            'attr' => [
                'min'  => 0,
                'max'  => 10
            ]
        ]);

        $builder->get('course')->addModelTransformer($this->courseTransformer);
        $builder->get('student')->addModelTransformer($this->studentTransformer);
        $builder->get('subject')->addModelTransformer($this->subjectTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => StudentSubject::class,
            'data_class' => null,
        ]);
    }
}
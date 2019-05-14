<?php
namespace App\Form;

use App\Entity\Student;
use App\Entity\Course;
use App\Entity\StudentCourse;
use App\Form\DataTransformer\StudentToNumberTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;


class StudentCourseType extends AbstractType
{
    private $studentTransformer;

    public function __construct(StudentToNumberTransformer $studentTransformer)
    {
        $this->studentTransformer = $studentTransformer;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StudentCourse::class
        ]);

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('course', EntityType::class, [
            'label' => 'Seleccione año académico',
            'placeholder' => '',
            'class' => Course::class,
            'choice_label' => 'name'
        ])
        ->add('level', ChoiceType::class, [
            'label' => 'Seleccione un curso',
            'placeholder' => '',
            'choices'=>[
                '1'=>1,
                '2'=>2,
                '3'=>3,
                '4'=>4,
                '5'=>5
                ]
        ])
        ->add('save', SubmitType::class, [
            'label' => 'Matricular'
        ])
        ->add('student', HiddenType::class);

        $builder->get('student')
            ->addModelTransformer($this->studentTransformer);
    }
}
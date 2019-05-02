<?php
namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SubjectType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Subject'
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Nombre'
        ])
        ->add('code', TextType::class, [
            'label' => 'Código'
        ])
        ->add('course', ChoiceType::class, [
            'label' => 'Curso',
            'choices'=>[
                '1'=>1,
                '2'=>2,
                '3'=>3,
                '4'=>4,
                '5'=>5
            ]
        ])
        ->add('type', ChoiceType::class, [
            'label' => 'Tipo',
            'choices'=>[
                'FORMACIÓN BÁSICA'=>'FORMACIÓN BÁSICA',
                'OBLIGATORIAS'=>'OBLIGATORIAS',
                'OPTATIVAS'=>'OPTATIVAS'
            ]
        ])
        ->add('semester', ChoiceType::class, [
            'label' => 'Semestre',
            'choices'=>[
                '1º'=>1,
                '2º'=>2,
                '3º'=>3
            ]
        ])
        ->add('credits', TextType::class, [
            'label' => 'Créditos'
        ])
        ->add('is_active', CheckboxType::class, [
            'label' => 'Activo',
            'required' => false
        ] );
    }
}
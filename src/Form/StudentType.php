<?php
namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;


class StudentType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class)
        ->add('surname', TextType::class)
        ->add('birthdate', DateType::class)
        ->add('email', TextType::class)
        ->add('genre', ChoiceType::class, [
            'choices'=>[
                'Masculino','male',
                'Femenino','female'
            ]
        ])
        ->add('dni', TextType::class)
        ->add('address', TextType::class)
        ->add('cp', TextType::class)
        ->add('town', TextType::class)
        ->add('province', TextType::class)
        ->add('telephone', TextType::class)
        ->add('save', SubmitType::class, ['label' => 'Enviar']);
    }
}
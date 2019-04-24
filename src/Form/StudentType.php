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
            'data_class' => 'App\Entity\Student'
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Nombre'
        ])
        ->add('surname', TextType::class, [
            'label' => 'Apellidos'
        ])
        ->add('birthdate', DateType::class, [
            'label' => 'Fecha de nacimiento',
            'format' => 'dd/MM/yyyy',
            'widget' => 'single_text',
            'attr' => ['class' => 'js-datepicker'], //https://symfonycasts.com/screencast/symfony3-forms/date-picker-field
            'html5' => false,                       //Tells browser not render their own date widget
        ])
        ->add('email', TextType::class, [
            'label' => 'Email'
        ])
        ->add('genre', ChoiceType::class, [
            'label' => 'Género',
            'choices'=>[
                'Masculino'=>'male',
                'Femenino'=>'female'
            ]
        ])
        ->add('dni', TextType::class, [
            'label' => 'DNI'
        ])
        ->add('address', TextType::class, [
            'label' => 'Dirección'
        ])
        ->add('cp', TextType::class, [
            'label' => 'CP'
        ])
        ->add('town', TextType::class, [
            'label' => 'Población'
        ])
        ->add('province', TextType::class, [
            'label' => 'Provincia'
        ])
        ->add('telephone', TextType::class, [
            'label' => 'Teléfono'
        ])
        ->add('save', SubmitType::class, [
            'label' => 'Enviar'
        ]);
    }
}
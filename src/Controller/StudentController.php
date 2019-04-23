<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class StudentController extends AbstractController
{
    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $students = $repository->findAll();

        return $this->render('student/list.html.twig', [
            'page_title'=>'Gestión de estudiantes',
            'page_subtitle'=>'Listado',
            'menu_module'=>'student',
            'menu_controller'=>'list',
            'students' => $students
        ]);
    }
    public function edit(Request $request, Student $student)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);

        return $this->render('student/form.html.twig', [
            'page_title'=>'Alta de estudiante',
            'page_subtitle'=>'Alta',
            'menu_module'=>'student',
            'menu_controller'=>'add',
            'form' => $form
        ]);
    }
}

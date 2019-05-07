<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\StudentCourse;
use App\Form\StudentCourseType;
use App\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class StudentController extends AbstractController
{
    public function registration(Request $request, Student $student, $id)
    {
        $form = $this->createForm(StudentCourseType::class);

        $form->handleRequest($request);

        $errors = $form->getErrors(true);


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($data);
            $manager->flush();
            //return $this->redirectToRoute('student_list');
        }


        $student = $this->getDoctrine()
        ->getRepository(Student::class)
        ->find($id);

        if (!$student) {
            throw $this->createNotFoundException(
                'No atudent found for id '.$id
            );
        }


        return $this->render('student/form.registration.html.twig', [
            'page_title'=>'Editar matriculación',
            'page_subtitle'=>'Editar',
            'menu_module'=>'student',
            'menu_controller'=>'add',
            'student'=>$student,
            'form' => $form->createView()
        ]);
    }


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

    public function edit(Request $request, Student $student, $id)
    {
        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);

        $errors = $form->getErrors(true);


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($data);
            $manager->flush();
            //return $this->redirectToRoute('student_list');
        }

        $student = $this->getDoctrine()
        ->getRepository(Student::class)
        ->find($id);

        if (!$student) {
            throw $this->createNotFoundException(
                'No atudent found for id '.$id
            );
        }


        return $this->render('student/form.html.twig', [
            'page_title'=>'Editar estudiante',
            'page_subtitle'=>'Editar',
            'menu_module'=>'student',
            'menu_controller'=>'add',
            'student'=>$student,
            'form' => $form->createView()
        ]);
    }

    public function add(Request $request)
    {
        $form = $this->createForm(StudentType::class);

        $form->handleRequest($request);

        $errors = $form->getErrors(true);


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($data);
            $manager->flush();
            return $this->redirectToRoute('student_list');
        }

        return $this->render('student/form.html.twig', [
            'page_title'=>'Alta de estudiante',
            'page_subtitle'=>'Alta',
            'menu_module'=>'student',
            'menu_controller'=>'add',
            'form' => $form->createView()
        ]);
    }
}

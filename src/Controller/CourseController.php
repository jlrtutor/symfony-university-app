<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class CourseController extends AbstractController
{
    public function delete(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $course = $manager->getRepository('App:Course')->find( $id );

        $manager->remove($course);
        $manager->flush();

        return $this->redirectToRoute('course_list');
    }

    public function edit(Request $request, Course $course)
    {
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        $errors = $form->getErrors(true);


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($data);
            $manager->flush();
        }

        $repository = $this->getDoctrine()->getRepository(Course::class);
        $courses = $repository->findAll();

        return $this->render('course/index.html.twig', [
            'page_title'=>'Editar curso',
            'page_subtitle'=>'Editar',
            'form_header'=>'Datos del curso',
            'menu_module'=>'course',
            'menu_controller'=>'add',
            'courses' => $courses,
            'form' => $form->createView()
        ]);
    }


    public function list(Request $request)
    {
        $form = $this->createForm(CourseType::class);
        
        $form->handleRequest($request);

        $errors = $form->getErrors(true);


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($data);
            $manager->flush();
            
            return $this->redirectToRoute('course_list');
        }

        $repository = $this->getDoctrine()->getRepository(Course::class);
        $courses = $repository->findAll();

        return $this->render('course/index.html.twig', [
            'page_title'=>'Gestión de cursos',
            'page_subtitle'=>'Listado',
            'form_header'=>'Alta de nuevo curso',
            'menu_module'=>'course',
            'menu_controller'=>'list',
            'courses' => $courses,
            'form' => $form->createView()
        ]);
    }

    
}

<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class SubjectController extends AbstractController
{
    public function ajaxChangeStatus(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();        
        $subject = $manager->getRepository(Subject::class)->find($id);

        $subject->setIsActive( $subject->getIsActive()?false:true );
        $manager->flush();

        //Ajax Calls Only
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'status' => 'Error',
                'message' => 'Error'),
            400);
        }

        // Send all this back to client
        return new JsonResponse(array(
            'status' => 'OK',
            'message' => '1'),
        200);
    }

    public function edit(Request $request, Subject $subject)
    {
        $form = $this->createForm(SubjectType::class, $subject);

        $form->handleRequest($request);

        $errors = $form->getErrors(true);


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($data);
            $manager->flush();
            //return $this->redirectToRoute('student_list');
        }

        return $this->render('subject/form.html.twig', [
            'page_title'=>'Editar asignatura',
            'page_subtitle'=>'Editar',
            'menu_module'=>'subject',
            'menu_controller'=>'add',
            'form' => $form->createView()
        ]);
    }

    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(Subject::class);
        $subjects = $repository->findAll();

        return $this->render('subject/list.html.twig', [
            'page_title'=>'Gestión de asignaturas',
            'page_subtitle'=>'Listado',
            'menu_module'=>'subject',
            'menu_controller'=>'list',
            'subjects' => $subjects
        ]);
    }

    public function delete(Request $request, Subject $subject, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $subject = $em->getRepository('App:Subject')->find( $id );

        if($subject)
        {
            $em->remove($subject);
            $em->flush();
        }
        
        return $this->redirectToRoute('subject_list');
    }

    public function add(Request $request)
    {
        $form = $this->createForm(SubjectType::class);

        $form->handleRequest($request);

        $errors = $form->getErrors(true);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($data);
            $manager->flush();
            return $this->redirectToRoute('subject_list');
        }

        return $this->render('subject/form.html.twig', [
            'page_title'=>'Alta de asignatura',
            'page_subtitle'=>'Alta',
            'menu_module'=>'subject',
            'menu_controller'=>'add',
            'form' => $form->createView()
        ]);
    }
}

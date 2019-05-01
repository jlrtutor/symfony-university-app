<?php

namespace App\Controller;

use App\Entity\Subject;
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
}

<?php

namespace App\Controller;

use App\Entity\Subject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SubjectController extends AbstractController
{

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

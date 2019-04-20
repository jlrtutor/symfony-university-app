<?php

namespace App\Controller;

use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $students = $repository->findAll();

        return $this->render('student.list.html.twig', [
            'page_title'=>'Gestión de estudiantes',
            'page_subtitle'=>'Listado',
            'students' => $students
        ]);
    }
}

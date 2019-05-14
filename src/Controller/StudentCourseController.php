<?php
namespace App\Controller;

use App\Entity\Student;
use App\Entity\StudentCourse;
use App\Entity\StudentSubject;
use App\Form\StudentCourseType;
use App\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class StudentCourseController extends AbstractController
{
    public function registration(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $student = $em->getRepository(Student::class)->find($id);

        $studentCourseRepository = $em->getRepository(StudentCourse::class);
        $studentSubjectRepository = $em->getRepository(StudentSubject::class);

        $studentCourse = new StudentCourse();
        $studentCourse->setStudent( new Student() );

        $form = $this->createForm(StudentCourseType::class, $studentCourse);        
        $form->handleRequest($request);
        //die();
        
        $errors = $form->getErrors(true);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            //Check if Student is subscribed to course/level yet
            if( !$studentCourseRepository->findBy( [
                'course'=>$request->request->get('student_course')['course'],
                'level'=>$request->request->get('student_course')['level'],
                'student'=>$request->request->get('student_course')['student'] ])) 
                {                
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($data);
                $manager->flush();

                //return $this->redirect($request->getUri());
            }
        }else{
            //echo $form->getErrors();
        }


        if (!$student) {
            throw $this->createNotFoundException(
                'No student found for id '
            );
        }

        return $this->render('student/form.registration.html.twig', [
            'page_title'=>'Editar matriculación',
            'page_subtitle'=>'Editar',
            'menu_module'=>'student',
            'menu_controller'=>'add',
            'student'=>$student,
            'courses'=>$studentCourseRepository->findBy( ['student' => $student->getId()] ),
            'subject'=>$studentSubjectRepository,
            'form' => $form->createView()
        ]);
    }
}

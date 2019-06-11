<?php
namespace App\Controller;

use App\Entity\Course;
use App\Entity\Grade;
use App\Entity\Student;
use App\Entity\StudentCourse;
use App\Entity\StudentSubject;
use App\Entity\Subject;
use App\Form\GradeType;
use App\Form\StudentCourseType;
use App\Form\StudentSubjectType;
use App\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class StudentCourseController extends AbstractController
{
    public function grade(Request $request, $id, $rid, $lid)
    {
        $em = $this->getDoctrine()->getManager();

        $subjectRepository = $em->getRepository(Subject::class);

        $studentRepository = $em->getRepository(Student::class);

        $studentCourseRepository = $em->getRepository(StudentCourse::class);
        $registration = $studentCourseRepository->find($rid);
        
        $studentSubjectRepository = $em->getRepository(StudentSubject::class);
        $student = $em->getRepository(Student::class)->find($id);

        $course_id = $registration->getCourse()->getId();

        $courseRepository = $em->getRepository(Course::class);
        
        $form = $this->createForm(GradeType::class);        
        
        $form->handleRequest($request);
        
        $errors = $form->getErrors(true);
        
        if ($form->isSubmitted()) {
            $data = $request->request->get('calification');
            
            foreach($data as $subject_id => $grade)
            {
                $manager = $this->getDoctrine()->getManager();
                //Check if Student is subscribed to course/level yet
                if( !$calification = $studentSubjectRepository->findOneBy( [
                    'course'=>$courseRepository->find($course_id),
                    'level'=>$lid,
                    'student'=>$studentRepository->find($id),
                    'subject'=>$subjectRepository->find($subject_id) ]) ) 
                    {                
                        $new_grade = new StudentSubject();
                        $new_grade->setCourse( $courseRepository->find($rid) )
                        ->setLevel( $lid )
                        ->setStudent( $studentRepository->find($id) )
                        ->setSubject( $subjectRepository->find($subject_id) )
                        ->setCourse( $courseRepository->find($course_id) )
                        ->setGrade( (float)$grade )
                        ->setCreatedAt( new \DateTime() );
                        $manager->persist($new_grade);
                        $manager->flush();
                        //return $this->redirect($request->getUri());
                    } else {
                        //$calification->setGrade( empty($grade)?NULL:(float)$grade );
                        $calification->setGrade( empty($grade)?NULL:(float)$grade );
                        $manager->persist($calification);
                        $manager->flush();
                }
            }
        }
            
        if (!$student) {
            throw $this->createNotFoundException(
                'No student found for id '
            );
        }
            
        $grades = $studentSubjectRepository->getGrades( $id, $rid, $lid );
        
        return $this->render('student/form.grade.html.twig', [
            'page_title'=>'Editar notas',
            'page_subtitle'=>'Editar',
            'menu_module'=>'student',
            'menu_controller'=>'add',
            'student'=>$student,
            'courses'=>$studentCourseRepository->findBy( ['student' => $id] ),
            'subject'=>$studentSubjectRepository,
            'grades'=>$grades,
            'form'=>$form->createView()
            ]);
    }
            
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

    public function deleteRegistration($id, $rid)
    {
        $em = $this->getDoctrine()->getManager();
        $studentCourse = $em->getRepository('App:StudentCourse')->find( $rid );

        if($studentCourse)
        {
            $em->remove($studentCourse);
            $em->flush();
        }

        return $this->redirectToRoute('student_registration', ['id'=>$id ]);
    }
}

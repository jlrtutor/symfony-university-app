<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {   
        $course = new Course();
        $course->setName('2018/2019');
        $manager->persist($course);
        $manager->flush();

        $course = new Course();
        $course->setName('2019/2020');
        $manager->persist($course);
        $manager->flush();
    }
}
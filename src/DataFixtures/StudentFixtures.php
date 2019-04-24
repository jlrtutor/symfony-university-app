<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $genre_values = array( 'male', 'female' );
        
        $faker = Faker\Factory::create('es_ES');
        
        for ($i = 0; $i < 25; $i++) {
            $student = new Student();
            $genre = array_rand( $genre_values);

            $student->setName( $genre_values[$genre] == 'male'?$faker->firstNameMale:$faker->firstNameFemale );
            $student->setSurname( $faker->lastName . ' ' . $faker->lastName );
            $student->setBirthdate( new \DateTime( $faker->dateTimeThisCentury->format('Y-m-d') ) );
            $student->setGenre( $genre_values[$genre] );
            $student->setEmail( $faker->freeEmail );
            $student->setCreatedAt( new \DateTime() );
            $student->setDni( $faker->dni );
            $student->setAddress( $faker->streetName . ", " . $faker->buildingNumber );
            $student->setCp( $faker->postcode );
            $student->setTown( $faker->city );
            $student->setProvince( $faker->state );
            $student->setTelephone( $faker->numberBetween($min = 600000000, $max = 699999999) );
            $student->setIsDeleted( 0 );
            
            $manager->persist($student);
            $manager->flush();
        }
    }
}

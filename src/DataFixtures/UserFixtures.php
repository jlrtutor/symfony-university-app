<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Admin');
        $user->setSurname('Demo');
        $user->setEmail('admin@admin.com');
        $user->setRoles( ['ROLE_ADMIN'] );
        $user->setPassword( $this->passwordEncoder->encodePassword( $user,
                                                                    'admin'
                                                                    ) );
        $user->setComments('Programming since 1997');
        $user->setIsActive(1);

        $manager->persist($user);
        $manager->flush();
    }
}

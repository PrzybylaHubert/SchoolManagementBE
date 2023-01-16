<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\ResetPasswordRequest;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('active@student.com');
        $user1->setRoles(['ROLE_STUDENT']);
        $hashedPassword = $this->passwordHasher->hashPassword($user1, 'test');
        $user1->setPassword($hashedPassword);
        $user1->setName('student');
        $user1->setSurname('active');
        $user1->setIsActive(true);
        $user1->setFirstLogin(true);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('inactive@student.com');
        $user2->setRoles(['ROLE_STUDENT']);
        $hashedPassword = $this->passwordHasher->hashPassword($user2, 'test');
        $user2->setPassword($hashedPassword);
        $user2->setName('student');
        $user2->setSurname('inactive');
        $user2->setIsActive(false);
        $user2->setFirstLogin(true);
        $manager->persist($user2);

        $resetRequest = new ResetPasswordRequest();
        $resetRequest->setUserId($user1);
        $resetRequest->setSelector('8ffe496b573b2ac2');
        $token = '02f5ce2b8412104737c79fbff6efa707023dab52d406a2152e793c8860c97670';
        $tokenHash = hash('sha384', hex2bin($token));
        $resetRequest->setHashedToken($tokenHash);
        $created = new \DateTimeImmutable();
        $expire = $created->add(new \DateInterval('PT1H'));
        $resetRequest->setRequestedAt($created);
        $resetRequest->setExpiresAt($expire);
        $manager->persist($resetRequest);

        $manager->flush();
    }
}

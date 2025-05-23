<?php
namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $hasher
    ) {}


    public function saveUser(User $user) {
        
        // Test si le compte existe
        if ($this->userRepository->findOneBy(["email" => $user->getEmail()])) {
            throw new \Exception("Le compte existe déjà");
        }

        // Hasher le mot de passe et assigner le role
        $user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));

        $this->em->persist($user);
        $this->em->flush();
    }
}
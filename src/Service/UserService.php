<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserPasswordHasherInterface $hasher;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
        $this->userRepository = $userRepository;
    }


    //set new user with argument email, password, type,
    public function setNewAdminUser(string $email, string $password): void
    {
        $roles = ['ROLE_ADMIN', 'ROLE_EMPLOYEE', 'ROLE_OWNER'];
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->hasher->hashPassword($user, $password));
        $user->setType('owner');
        $user->setRoles($roles);

        $this->userRepository->persist($user);
        $this->userRepository->flush();
    }
}

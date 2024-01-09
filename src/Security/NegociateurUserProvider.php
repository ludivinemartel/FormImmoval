<?php

namespace App\Security;

use App\Entity\Negociateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class NegociateurUserProvider implements UserProviderInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadUserByUsername(string $email): UserInterface
    {
        $user = $this->entityManager->getRepository(Negociateur::class)->findOneBy(['email' => $email]);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('User with email "%s" does not exist.', $email));
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof Negociateur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getEmail());
    }

    public function supportsClass(string $class): bool
    {
        return Negociateur::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        // Implement the method as needed for your application
        // This method is required by the UserProviderInterface
        // It should load a user based on a unique identifier
    }
}

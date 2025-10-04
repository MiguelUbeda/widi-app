<?php

namespace App\Command;

use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Create a demo user for testing',
)]
class CreateUserCommand extends Command
{
    private DocumentManager $dm;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(DocumentManager $dm, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->dm = $dm;
        $this->passwordHasher = $passwordHasher;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $existingUser = $this->dm->getRepository(User::class)->findOneBy(['email' => 'cliente@widi.com']);
        
        if ($existingUser) {
            $io->warning('User already exists!');
            return Command::SUCCESS;
        }

        $user = new User();
        $user->setEmail('cliente@widi.com');
        $user->setRoles(['ROLE_USER']);
        
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'password123');
        $user->setPassword($hashedPassword);

        $this->dm->persist($user);
        $this->dm->flush();

        $io->success('Demo user created successfully!');
        $io->info('Email: cliente@widi.com');
        $io->info('Password: password123');

        return Command::SUCCESS;
    }
}

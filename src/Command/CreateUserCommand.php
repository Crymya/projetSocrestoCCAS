<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'CreateUserCommand',
    description: 'Add a short description for your command',
)]
class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $question1 = new Question('Entrez votre nom: ');
        $question2 = new Question('Entrez votre prénom: ');
        $question3 = new Question('Entrez votre email: ');
        $question4 = new Question('Entrez votre mot de passe: ');

        $firstName = $helper->ask($input, $output, $question1);
        $lastName = $helper->ask($input, $output, $question2);
        $email = $helper->ask($input, $output, $question3);
        $password = $helper->ask($input, $output, $question4);

        $user = new User();
        $user->setNom($firstName);
        $user->setPrenom($lastName);
        $user->setEmail($email);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $password));
        $user->setActif(true);
        $user->setRoles(["ROLE_ADMIN"]);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('User created successfully.');

        return Command::SUCCESS;
    }
}

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

        $question1 = new Question('Please enter the user\'s first name: ');
        $question2 = new Question('Please enter the user\'s last name: ');
        $question3 = new Question('Please enter the user\'s email address: ');
        $question4 = new Question('Please enter the user\'s password: ');

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

    /*private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:create-user')
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $helper = $this->getHelper('question');

        $question = new Question('Entrez le nom: ');
        $nom = $helper->ask($input, $output, $question);

        $question = new Question('Entrez le prénom: ');
        $prenom = $helper->ask($input, $output, $question);

        $question = new Question('Entrez le mail: ');
        $mail = $helper->ask($input, $output, $question);

        $question = new Question('Entrez le mot de passe: ');
        $question->setHidden(true);
        $password = $helper->ask($input, $output, $question);

        $user = new User();
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setPassword($password);
        $user->setEmail($mail);
        $user->setActif(true);
        $user->setRoles(["ROLE_ADMIN"]);



        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('Utilisateur créé');
    }*/
    /*protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }*/
}

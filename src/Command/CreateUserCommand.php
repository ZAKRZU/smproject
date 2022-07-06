<?php
namespace App\Command;

use Symfony\Component\Console\Atrribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use App\Repository\UserRepository;
use App\Entity\User;

#[AsCommand(
    name: 'app:create-user',
    description: 'Creates a new user.',
    hidden: false,
    aliases: ['app:add-user']
)]
class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserRepository $er, UserPasswordHasherInterface $passwordHasherInterface){
        $this->userRepository = $er;
        $this->passwordHasher = $passwordHasherInterface;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
        ->addArgument('email', InputArgument::REQUIRED, 'User email')
        ->addArgument('password', InputArgument::REQUIRED, 'User password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        
        $new_user = new User();
        $new_user->setEmail($input->getArgument('email'));
        $new_user->setPassword($this->passwordHasher->hashPassword($new_user, $input->getArgument('password')));
        $new_user->setRoles(array('ROLE_ADMIN'));
        
        $this->userRepository->add($new_user, true);

        $output->writeln([
            'User Creator',
            '------------',
            '',
            'Email: '.$input->getArgument('email'),
        ]);
        
        return Command::SUCCESS;
    }
}

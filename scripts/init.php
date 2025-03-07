<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

#[\Symfony\Component\Console\Attribute\AsCommand(name: 'app:init')]

class Command extends
    Symfony\Component\Console\Command\Command
{
    private \Symfony\Component\Console\Input\InputInterface   $input;

    private \Symfony\Component\Console\Output\OutputInterface $output;

    protected function configure(): void
    {
        $this->setDescription('Initialize Application"');
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output): int
    {
        $this->input  = $input;
        $this->output = $output;
        $this->output->writeln('Hello, World!');

        $this->checkUsers();


        return static::SUCCESS;
    }

    protected function checkUsers(): void
    {

        $usersCount = \RfcTool\Entity\User::getRepository()
                                          ->count()
        ;

        if (0 !== $usersCount) {
            $this->output->writeln('There are ' . $usersCount . ' users');

            return;
        }
        $this->output->writeln('There are no users yet, creating first admin user.');

        $newUser = new \RfcTool\Service\User\Creator()
            ->do(
                new \RfcTool\Service\User\Creator\Bag()
                    ->setEmail('rfc@rfc.tool')
                    ->setPersist(true)
                    ->setName('RfcToolAdmin')
                    ->setRole(\RfcTool\Definition\User\Role::admin)
                    ->setStatus(\RfcTool\Definition\User\Status::active)
                    ->setCredentials(
                        new \RfcTool\Service\User\Creator\CredentialList()
                            ->push(
                                new \RfcTool\Service\User\Creator\CredentialBag()
                                    ->setType(\RfcTool\Definition\User\CredentialType::password)
                                    ->setPassword('initial password'),
                            ),
                    ),
            )
        ;

        \RfcTool\Util\Debugger::dieDebug($newUser->getId(), $newUser->getName());
    }
}


$command     = new Command();
$application = new \Symfony\Component\Console\Application();
$application->add($command);
$application->setDefaultCommand($command->getName());
$application->run();

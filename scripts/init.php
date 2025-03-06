<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

#[\Symfony\Component\Console\Attribute\AsCommand(name: 'app:init')]

class Command extends Symfony\Component\Console\Command\Command {
    private \Symfony\Component\Console\Input\InputInterface $input;

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


        $usersCount = \RfcTool\Entity\User::getRepository()->count();

        if (0 !== $usersCount) {
            $this->output->writeln('There are ' . $usersCount . ' users');
        }
        if (0 === $usersCount) {
            $this->output->writeln('There are no users yet, creating first admin user.');

        }

        \RfcTool\Util\Debugger::dieDebug($usersCount);

        return static::SUCCESS;
    }
}


$command = new Command();
$application = new \Symfony\Component\Console\Application();
$application->add($command);
$application->setDefaultCommand($command->getName());
$application->run();

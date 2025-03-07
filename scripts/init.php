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
        $this->setDescription(description: 'Initialize Application"');
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output): int
    {
        $this->input  = $input;
        $this->output = $output;
        $this->output->writeln(messages: 'Hello, World!');

        $this->checkUsers();

        return static::SUCCESS;
    }

    protected function checkUsers(): void
    {
        $usersCount = \RfcTool\Entity\User::getRepository()
                                          ->count()
        ;

        if (0 !== $usersCount) {
            $this->output->writeln(messages: 'There are ' . $usersCount . ' users');

            return;
        }
        $this->output->writeln(messages: 'There are no users yet, creating first admin user.');

        $newUser = new \RfcTool\Service\User\Creator()
            ->do(
                bag: new \RfcTool\Service\User\Creator\Bag()
                         ->setEmail(email: 'rfc@rfc.tool')
                         ->setPersist(persist: true)
                         ->setName(name: 'RfcToolAdmin')
                         ->setRole(role: \RfcTool\Definition\User\Role::admin)
                         ->setStatus(status: \RfcTool\Definition\User\Status::active)
                         ->setCredentials(
                             credentials: new \RfcTool\Service\User\Creator\CredentialList()
                                              ->push(
                                                  item: new \RfcTool\Service\User\Creator\CredentialBag()
                                                            ->setType(type: \RfcTool\Definition\User\CredentialType::password)
                                                            ->setPassword(password: 'initial password'),
                                              ),
                         ),
            )
        ;

        \RfcTool\Util\Debugger::dieDebug($newUser->getId(), $newUser->getName());
    }
}

$command     = new Command();
$application = new \Symfony\Component\Console\Application();
$application->add(command: $command);
$application->setDefaultCommand(commandName: $command->getName());
$application->run();

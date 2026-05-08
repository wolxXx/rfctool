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
        $this->output->writeln(messages: 'RFC-Tool');
        $this->output->writeln(messages: '-> initialize');

        $this->checkUsers();

        return static::SUCCESS;
    }

    protected function checkUsers(): void
    {
        $usersCount = \RfcTool\Entity\User::getRepository()
                                          ->count()
        ;

        if (0 !== $usersCount) {
            $this->output->writeln(messages: 'There are ' . $usersCount . ' user(s), no need to create initial user.');

            return;
        }

        $this->output->writeln(messages: 'There are no users yet, creating first admin user.');

        $email    = 'rfc@rfc.tool';
        $name     = 'RfcToolAdmin';
        $password = 'initial password';
        new \RfcTool\Service\User\Creator()
            ->do(
                bag: new \RfcTool\Service\User\Creator\Bag()
                         ->doPersist(persist: true)
                         ->setEmail(email: $email)
                         ->setName(name: $name)
                         ->setRole(role: \RfcTool\Definition\User\Role::admin)
                         ->setStatus(status: \RfcTool\Definition\User\Status::active)
                         ->setCredentials(
                             credentials: [
                                              new \RfcTool\Service\User\Creator\CredentialBag()
                                                  ->setType(type: \RfcTool\Definition\User\CredentialType::password)
                                                  ->setPassword(password: $password),
                                          ],
                         ),
            )
        ;

        $this->output->writeln(messages: 'Added initial user:');
        $this->output->writeln(messages: 'Name: ' . $name);
        $this->output->writeln(messages: 'E-Mail: ' . $email);
        $this->output->writeln(messages: 'Password: ' . $password);
    }
}

$command     = new Command();
$application = new \Symfony\Component\Console\Application();
$application->add(command: $command);
$application->setDefaultCommand(commandName: $command->getName());
$application->run();

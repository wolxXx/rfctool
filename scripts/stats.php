<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

#[\Symfony\Component\Console\Attribute\AsCommand(name: 'app:stats')]

class Command extends
    Symfony\Component\Console\Command\Command
{
    private \Symfony\Component\Console\Input\InputInterface   $input;

    private \Symfony\Component\Console\Output\OutputInterface $output;

    protected function configure(): void
    {
        $this->setDescription(description: 'Grab statistics from database"');
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output): int
    {
        $this->input  = $input;
        $this->output = $output;
        $this->output->write("\033\143");

        $this->output->writeln(messages: 'RFC-Tool');
        $this->output->writeln(messages: '-> stats');

        $this->grabStats();

        return static::SUCCESS;
    }

    protected function grabStats(): void
    {
        /**
         * @var \RfcTool\Entity\User[]     $users
         * @var \RfcTool\Entity\Proposal[] $proposals
         */
        $table = new \Symfony\Component\Console\Helper\Table($this->output);
        $table->setHeaderTitle('users');
        $table->setHeaders(headers: [
                                        'Id',
                                        'Status',
                                        'Name',
                                        'Email',
                                        'invitation code',
                                        'last seen',
                                        'Role',
                                        'Blames',
                                        'Groups',
                                    ]);
        $users = \RfcTool\Entity\User::getRepository()
                                     ->createQueryBuilder('user')
                                     ->setCacheable(false)
                                     ->setCacheMode(\Doctrine\ORM\Cache::MODE_REFRESH)
                                     ->getQuery()
                                     ->execute()
        ;
        foreach ($users as $user) {
            /**
             * @var \RfcTool\Entity\User $user
             */
            $groups = '';
            foreach (RfcTool\Entity\UserInGroup::getRepository()->getForUser($user) as $group) {
                $groups .= $group->getGroup()->getName() . ', begin: ' . $group->getBeginDate()->format('Y-m-d') . ', end: ' . ($group->getEndDate()?->format('Y-m-d') ?? '-') . PHP_EOL;
            }
            $groups = trim($groups);
            if ('' === $groups) {
                $groups = '-';
            }
            $blame = 'C: '.$user->getcreatedAt()->format('Y-m-d H:i:s') . PHP_EOL .' by '.$user->getCreatedBy();
            $blame .= PHP_EOL . 'U: '.$user->getupdatedAt()->format('Y-m-d H:i:s'). ' by ' . PHP_EOL .$user->getUpdatedBy();

            $invitationCode = 'xxx'.$user->getInvitationCode().' '.(null !== $user->getInvitationCodeValidUntil()? $user->getInvitationCodeValidUntil()->format('Y-m-d H:i:s') : '-');
            $invitationCode = 'xxx'.$user->getInvitationCode();
            \RfcTool\Util\Debugger::debug($user->getInvitationCode(), $user->getId());

            $table->addRow(row: [
                                    $user->getId(),
                                    $user->getStatus()->value,
                                    $user->getName(),
                                    $user->getEmail(),
                                    $invitationCode,
                                    $user->getLastLogin()?->format('Y-m-d H:i:s') ?? '-',
                                    $user->getRole()->value,
                                    $blame,
                                    $groups,
                                ]);
        }
        $table->render();

        $proposals = \RfcTool\Entity\Proposal::getRepository()
                                             ->createQueryBuilder('proposal')
                                             ->getQuery()
                                             ->execute()
        ;
        $table     = new \Symfony\Component\Console\Helper\Table($this->output);
        $table->setHeaderTitle('proposals');
        $table->setHeaders(headers: [
                                        'Id',
                                        'Status',
                                        'Title',
                                        'Description',
                                        'Group',
                                        'Vote Start',
                                        'Vote End',
                                        'Result',
                                        'Calculation Base',
                                        'Vote Statistics',
                                        'Created At',
                                        'Created By',
                                        'Updated At',
                                        'Updated By',
                                    ]);

        $totalVoteCount       = 0;
        $totalVoteProCount    = 0;
        $totalVoteContraCount = 0;
        $totalVoteNoneCount   = 0;
        foreach ($proposals as $proposal) {
            /**
             * @var \RfcTool\Entity\Proposal $proposal
             */
            $result               = new \RfcTool\Service\Proposal\Result()->get($proposal);
            $totalVoteCount       += $result->getVoteCount();
            $totalVoteProCount    += $result->getPro();
            $totalVoteContraCount += $result->getContra();
            $totalVoteNoneCount   += $result->getNone();
            $table->addRow(row: [
                                    $proposal->getId(),
                                    $proposal->getStatus()->value,
                                    $proposal->getTitle(),
                                    $proposal->getDescription(),
                                    $proposal->getGroup()?->getName() ?? '-',
                                    $proposal->getVoteStart()?->format('Y-m-d') ?? '-',
                                    $proposal->getVoteEnd()?->format('Y-m-d') ?? '-',
                                    $result->getResult()->value,
                                    $proposal->getCalculationBase()->value,
                                    'allowed to vote: ' . $result->getAllowed() . PHP_EOL .
                                    'vote count: ' . $result->getVoteCount() . ':  ' . $result->getVotedQuote() . '%' . PHP_EOL .
                                    'pro: ' . $result->getPro() . ': ' . $result->getProQuote() . '%' . PHP_EOL .
                                    'contra: ' . $result->getContra() . ': ' . $result->getContraQuote() . '%' . PHP_EOL .
                                    'none: ' . $result->getNone() . ': ' . $result->getNoneQuote() . '%' . PHP_EOL .
                                    'not voted: ' . $result->getNotVoted() . ': ' . $result->getNotVotedQuote() . '%' . PHP_EOL
                                    ,
                                    $proposal->getCreatedAt()->format('Y-m-d H:i:s'),
                                    $proposal->getCreatedBy(),
                                    $proposal->getUpdatedAt()->format('Y-m-d H:i:s'),
                                    $proposal->getUpdatedBy(),
                                ]);
        }
        $table->render();
        $this->output->writeln(messages: 'Total vote count: ' . $totalVoteCount);
        $this->output->writeln(messages: 'Total vote pro count: ' . $totalVoteProCount);
        $this->output->writeln(messages: 'Total vote contra count: ' . $totalVoteContraCount);
        $this->output->writeln(messages: 'Total vote none count: ' . $totalVoteNoneCount);
    }

}

$command     = new Command();
$application = new \Symfony\Component\Console\Application();
$application->add(command: $command);
$application->setDefaultCommand(commandName: $command->getName());
$application->run();

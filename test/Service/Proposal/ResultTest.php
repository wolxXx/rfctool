<?php

declare(strict_types = 1);

namespace RfcToolTest\Service\Proposal;

class ResultTest extends
    \PHPUnit\Framework\TestCase
{
    public function testInstantiation()
    {
        $this->assertInstanceOf(expected: \RfcTool\Service\Proposal\Result::class, actual: new \RfcTool\Service\Proposal\Result());
    }

    public function testCalculationBase()
    {
        $user1 = new \RfcTool\Service\User\Creator()->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                     ->setName(name: 'user1')
                     ->setEmail(email: __LINE__ . __FILE__ . \Faker\Factory::create()->email . '@example.com')
                     ->setRole(role: \RfcTool\Definition\User\Role::admin),
        );
        $user2 = new \RfcTool\Service\User\Creator()->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                     ->setName(name: 'user2')
                     ->setEmail(email: __LINE__ . __FILE__ . \Faker\Factory::create()->email . '@example.com')
                     ->setRole(role: \RfcTool\Definition\User\Role::admin),
        );
        $user3 = new \RfcTool\Service\User\Creator()->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                     ->setName(name: 'user3')
                     ->setEmail(email: __LINE__ . __FILE__ . \Faker\Factory::create()->email . '@example.com')
                     ->setRole(role: \RfcTool\Definition\User\Role::admin),
        );
        $user4 = new \RfcTool\Service\User\Creator()->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                     ->setName(name: 'user4')
                     ->setEmail(email: __LINE__ . __FILE__ . \Faker\Factory::create()->email . '@example.com')
                     ->setRole(role: \RfcTool\Definition\User\Role::admin),
        );
        $user5 = new \RfcTool\Service\User\Creator()->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                     ->setName(name: 'user5')
                     ->setEmail(email: __LINE__ . __FILE__ . \Faker\Factory::create()->email . '@example.com')
                     ->setRole(role: \RfcTool\Definition\User\Role::admin),
        );
        $user6 = new \RfcTool\Service\User\Creator()->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                     ->setName(name: 'user6')
                     ->setEmail(email: __LINE__ . __FILE__ . \Faker\Factory::create()->email . '@example.com')
                     ->setRole(role: \RfcTool\Definition\User\Role::admin),
        );
        $user7 = new \RfcTool\Service\User\Creator()->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                     ->setName(name: 'user7')
                     ->setEmail(email: __LINE__ . __FILE__ . \Faker\Factory::create()->email . '@example.com')
                     ->setRole(role: \RfcTool\Definition\User\Role::admin),
        );
        \RfcTool\Util\DependencyContainer::getInstance()
                                         ->getEntityManager()
                                         ->flush()
        ;
        $proposal = new \RfcTool\Service\Proposal\Creator()
            ->do(
                bag: new \RfcTool\Service\Proposal\Creator\Bag()
                         ->setTitle(title: 'title')
                         ->setDescription(description: 'description')
                         ->setCalculationBase(calculationBase: \RfcTool\Definition\Proposal\CalculationBase::SIMPLE_MAJORITY)
                         ->setstatus(status: \RfcTool\Definition\Proposal\Status::FINISHED)
                         ->setVoteStart(voteStart: new \DateTime()->sub(new \DateInterval('PT12H')))
                         ->setVoteEnd(voteEnd: new \DateTime()->sub(new \DateInterval('PT1H')))
                         ->setGroup(group: new \RfcTool\Service\Group\Creator()
                                               ->do(
                                                   bag: new \RfcTool\Service\Group\Creator\Bag()
                                                            ->setName('test group for '.__CLASS__.'::'.__LINE__)
                                                            ->setUsers([
                                                                           new \RfcTool\Service\Group\Creator\UserBag()
                                                                               ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT13H')))
                                                                               ->setUser($user1),
                                                                           new \RfcTool\Service\Group\Creator\UserBag()
                                                                               ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT13H')))
                                                                               ->setUser($user2),
                                                                           new \RfcTool\Service\Group\Creator\UserBag()
                                                                               ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT13H')))
                                                                               ->setUser($user3),

                                                                           new \RfcTool\Service\Group\Creator\UserBag()
                                                                               ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT13H')))
                                                                               ->setUser($user4),

                                                                           new \RfcTool\Service\Group\Creator\UserBag()
                                                                               ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT13H')))
                                                                               ->setUser($user5),

                                                                           new \RfcTool\Service\Group\Creator\UserBag()
                                                                               ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT13H')))
                                                                               ->setUser($user6),

                                                                           new \RfcTool\Service\Group\Creator\UserBag()
                                                                               ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT13H')))
                                                                               ->setUser($user7),

                                                                       ]),
                                               ),
                         ),
            )
        ;
        \RfcTool\Util\DependencyContainer::getInstance()
                                         ->getEntityManager()
                                         ->flush()
        ;
        $result = new \RfcTool\Service\Proposal\Result()
            ->get($proposal)
        ;
        $this->assertSame(expected: \RfcTool\Definition\Proposal\Result::REJECTED->value, actual: $result->getResult()->value);

        new \RfcTool\Service\Proposal\Vote()
            ->set(
                bag: new \RfcTool\Service\Proposal\Vote\Bag()
                         ->setUser($user1)
                         ->setProposal($proposal)
                         ->setVoteDate(voteDate: new \DateTime()->sub(new \DateInterval('PT3H')))
                         ->setVoice(true),
            )
        ;

        new \RfcTool\Service\Proposal\Vote()
            ->set(
                bag: new \RfcTool\Service\Proposal\Vote\Bag()
                         ->setUser($user2)
                         ->setProposal($proposal)
                         ->setVoteDate(voteDate: new \DateTime()->sub(new \DateInterval('PT2H')))
                         ->setVoice(false),
            )
        ;
        \RfcTool\Util\DependencyContainer::getInstance()
                                         ->getEntityManager()
                                         ->flush()
        ;

        $result = new \RfcTool\Service\Proposal\Result()
            ->get($proposal)
        ;

        $this->assertSame(expected: \RfcTool\Definition\Proposal\Result::DRAW->value, actual: $result->getResult()->value);

        new \RfcTool\Service\Proposal\Vote()
            ->set(
                bag: new \RfcTool\Service\Proposal\Vote\Bag()
                         ->setUser($user2)
                         ->setProposal($proposal)
                         ->setVoteDate(voteDate: new \DateTime()->sub(new \DateInterval('PT2H')))
                         ->setVoice(true),
            )
        ;
        \RfcTool\Util\DependencyContainer::getInstance()
                                         ->getEntityManager()
                                         ->flush()
        ;

        $result = new \RfcTool\Service\Proposal\Result()
            ->get($proposal)
        ;

        $this->assertSame(expected: \RfcTool\Definition\Proposal\Result::ACCEPTED->value, actual: $result->getResult()->value);

        new \RfcTool\Service\Proposal\Vote()
            ->set(
                bag: new \RfcTool\Service\Proposal\Vote\Bag()
                         ->setUser($user3)
                         ->setProposal($proposal)
                         ->setVoteDate(voteDate: new \DateTime()->sub(new \DateInterval('PT2H')))
                         ->setVoice(false),
            )
        ;
        \RfcTool\Util\DependencyContainer::getInstance()
                                         ->getEntityManager()
                                         ->flush()
        ;

        $result = new \RfcTool\Service\Proposal\Result()
            ->get($proposal)
        ;

        $this->assertSame(expected: \RfcTool\Definition\Proposal\Result::ACCEPTED->value, actual: $result->getResult()->value);
        $this->assertSame(expected: 2, actual: $result->getPro());
        $this->assertSame(expected: 1, actual: $result->getContra());

        new \RfcTool\Service\Proposal\Vote()
            ->set(
                bag: new \RfcTool\Service\Proposal\Vote\Bag()
                         ->setUser($user2)
                         ->setProposal($proposal)
                         ->setVoteDate(voteDate: new \DateTime()->sub(new \DateInterval('PT2H')))
                         ->setVoice(false),
            )
        ;
        \RfcTool\Util\DependencyContainer::getInstance()
                                         ->getEntityManager()
                                         ->flush()
        ;

        $result = new \RfcTool\Service\Proposal\Result()
            ->get($proposal)
        ;

        $this->assertSame(expected: \RfcTool\Definition\Proposal\Result::REJECTED->value, actual: $result->getResult()->value);
        $this->assertSame(expected: 1, actual: $result->getPro());
        $this->assertSame(expected: 2, actual: $result->getContra());

        new \RfcTool\Service\Proposal\Vote()
            ->set(
                bag: new \RfcTool\Service\Proposal\Vote\Bag()
                         ->setUser($user2)
                         ->setProposal($proposal)
                         ->setVoteDate(voteDate: new \DateTime()->sub(new \DateInterval('PT2H')))
                         ->setVoice(null),
            )
        ;
        \RfcTool\Util\DependencyContainer::getInstance()
                                         ->getEntityManager()
                                         ->flush()
        ;

        $result = new \RfcTool\Service\Proposal\Result()
            ->get($proposal)
        ;

        $this->assertSame(expected: \RfcTool\Definition\Proposal\Result::DRAW->value, actual: $result->getResult()->value);
        $this->assertSame(expected: 1, actual: $result->getPro());
        $this->assertSame(expected: 1, actual: $result->getContra());
        $this->assertSame(expected: 1, actual: $result->getNone());
    }
}

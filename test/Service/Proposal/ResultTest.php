<?php

declare(strict_types=1);

namespace RfcToolTest\Service\Proposal;

class ResultTest extends \PHPUnit\Framework\TestCase
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
            ->setEmail(email: __LINE__ .__FILE__.\Faker\Factory::create()->email. '@example.com')
            ->setRole(role: \RfcTool\Definition\User\Role::admin)
        );
        $user2 = new \RfcTool\Service\User\Creator()->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                ->setName(name: 'user2')
                ->setEmail(email: __LINE__ .__FILE__.\Faker\Factory::create()->email. '@example.com')
                ->setRole(role: \RfcTool\Definition\User\Role::admin)
        );
        $user3 = new \RfcTool\Service\User\Creator()->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                ->setName(name: 'user3')
                ->setEmail(email: __LINE__ .__FILE__.\Faker\Factory::create()->email. '@example.com')
                ->setRole(role: \RfcTool\Definition\User\Role::admin)
        );
        $user4 = new \RfcTool\Service\User\Creator()->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                ->setName(name: 'user4')
                ->setEmail(email: __LINE__ .__FILE__.\Faker\Factory::create()->email. '@example.com')
                ->setRole(role: \RfcTool\Definition\User\Role::admin)
        );
        $user5 = new \RfcTool\Service\User\Creator()->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                ->setName(name: 'user5')
                ->setEmail(email: __LINE__ .__FILE__.\Faker\Factory::create()->email. '@example.com')
                ->setRole(role: \RfcTool\Definition\User\Role::admin)
        );
        $user6 = new \RfcTool\Service\User\Creator()->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                ->setName(name: 'user6')
                ->setEmail(email: __LINE__ .__FILE__.\Faker\Factory::create()->email. '@example.com')
                ->setRole(role: \RfcTool\Definition\User\Role::admin)
        );
        $user7 = new \RfcTool\Service\User\Creator()->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                ->setName(name: 'user7')
                ->setEmail(email: __LINE__ .__FILE__.\Faker\Factory::create()->email. '@example.com')
                ->setRole(role: \RfcTool\Definition\User\Role::admin)
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
                    ->setCalculationBase(calculationBase: \RfcTool\Definition\Proposal\CalculationBase::MAJORITY)
                    ->setstatus(status: \RfcTool\Definition\Proposal\Status::FINISHED)
                    ->setVoteStart(voteStart: new \DateTime()->sub(new \DateInterval('PT1H')))
                    ->setVoteEnd(voteEnd: new \DateTime()->add(new \DateInterval('PT1H')))
                    ->setGroup(group: new \RfcTool\Service\Group\Creator()
                        ->do(
                            bag: new \RfcTool\Service\Group\Creator\Bag()
                                ->setName('test group')
                                ->setUsers([
                                    new \RfcTool\Service\Group\Creator\UserBag()
                                        ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT1H')))
                                        ->setUser($user1),
                                    new \RfcTool\Service\Group\Creator\UserBag()
                                    ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT1H')))
                                    ->setUser($user2),
                                    new \RfcTool\Service\Group\Creator\UserBag()
                                    ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT1H')))
                                    ->setUser($user3),

                                    new \RfcTool\Service\Group\Creator\UserBag()
                                    ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT1H')))
                                    ->setUser($user4),

                                    new \RfcTool\Service\Group\Creator\UserBag()
                                    ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT1H')))
                                    ->setUser($user5),

                                    new \RfcTool\Service\Group\Creator\UserBag()
                                    ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT1H')))
                                    ->setUser($user6),

                                    new \RfcTool\Service\Group\Creator\UserBag()
                                    ->setBeginDate(new \DateTime()->sub(new \DateInterval('PT1H')))
                                    ->setUser($user7),

                                ])
                        )
                    )
            );
        \RfcTool\Util\DependencyContainer::getInstance()
            ->getEntityManager()
            ->flush()
        ;
        $result = new \RfcTool\Service\Proposal\Result()
            ->get($proposal);
        $this->assertSame(expected: \RfcTool\Definition\Proposal\Result::ILLEGAL->value, actual: $result->getResult()->value);

        new \RfcTool\Service\Proposal\Vote()
            ->set(
                bag: new \RfcTool\Service\Proposal\Vote\Bag()
                ->setUser($user1)
                ->setProposal($proposal)
                ->setVoteDate(voteDate: new \DateTime())
                ->setVoice(true)
            );

        new \RfcTool\Service\Proposal\Vote()
            ->set(
                bag: new \RfcTool\Service\Proposal\Vote\Bag()
                ->setUser($user2)
                ->setProposal($proposal)
                ->setVoteDate(voteDate: new \DateTime())
                ->setVoice(false)
            );
        \RfcTool\Util\DependencyContainer::getInstance()
            ->getEntityManager()
            ->flush()
        ;

        $result = new \RfcTool\Service\Proposal\Result()
            ->get($proposal);

        $this->assertSame(expected: \RfcTool\Definition\Proposal\Result::DRAW->value, actual: $result->getResult()->value);
    }
}

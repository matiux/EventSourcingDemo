<?php

namespace Messenger\Infrastructure\Delivery\Console\Symfony;

use Faker\Factory;
use Faker\Generator;
use Messenger\Application\Service\TransactionalApplicationService;
use Messenger\Domain\Model\Message\MessageRequest;
use Messenger\Infrastructure\Application\Persistence\Doctrine\DoctrineSession;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateNewMessagesCommand extends ContainerAwareCommand
{
    /**
     * @var Generator
     */
    private $faker;

    protected function configure()
    {
        $this
            ->setName('messenger:message:create')
            ->setDescription('Check for new messages')
            ->setHelp('This command loop over imap mailboxes to check for new messages')
            ;

        $this->faker = Factory::create();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $eventPublisher = $this->getContainer()->get('event.publisher');

        $txAppService = new TransactionalApplicationService(
            $this->getContainer()->get('create.message'),
            new DoctrineSession(
                $this->getContainer()->get('doctrine.orm.entity_manager')
            )
        );

        $response = $txAppService->execute(
            new MessageRequest(
                $this->faker->sentence(4),
                $this->faker->text(),
                new \DateTimeImmutable()
            )
        );

    }
}

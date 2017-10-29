<?php

namespace Messenger\Infrastructure\Delivery\Console\Symfony;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Dotenv\Dotenv;

class PushNotificationsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('messenger:domain:events:spread')
            ->setDescription('Notify all domain events via messaging')
            ->addArgument('exchange-name', InputArgument::OPTIONAL, 'Exchange name to publish events to', 'main-exchange');


    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (new Dotenv())->load($this->getContainer()->get('kernel')->getRootDir().'/../.env');

        $numberOfNotifications = $this->getContainer()->get('notification.service')
            ->publishNotifications(
                $input->getArgument('exchange-name')
            );

        $output->writeln(sprintf('<comment>%d</comment> <info>notifications(s) sent!</info>', $numberOfNotifications));
    }
}

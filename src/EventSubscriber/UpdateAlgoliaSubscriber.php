<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Amqp\Message\AlgoliaMessage;
use App\Amqp\Publisher\AlgoliaMessagePublisher;
use App\Entity\Company;
use App\Entity\Firm;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UpdateAlgoliaSubscriber implements EventSubscriberInterface
{
    private $algoliaPublisher;
    private $logger;

    public function __construct(
        ProducerInterface $algoliaPublisher,
        LoggerInterface $logger = null
    ) {
        $this->algoliaPublisher = $algoliaPublisher;
        $this->logger = $logger ?: new NullLogger();
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['updateAlgolia', EventPriorities::POST_WRITE],
        ];
    }

    public function updateAlgolia(GetResponseForControllerResultEvent $event)
    {
        $company = $event->getControllerResult();

        if ($company instanceof Company) {
            $this->algoliaPublisher->publish(json_encode(['id' => $company->getId()]));

            $this->logger->info("publish algolia message for company id {$company->getId()}");
        }
    }
}

<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Speaker;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UpdateAlgoliaSubscriber implements EventSubscriberInterface
{
    /** @var ProducerInterface  */
    private $algoliaPublisher;

    /** @var NullLogger */
    private $logger;

    public function __construct(
        ProducerInterface $algoliaPublisher,
        LoggerInterface $logger = null
    ) {
        $this->algoliaPublisher = $algoliaPublisher;
        $this->logger = $logger ?: new NullLogger();
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['updateAlgolia', EventPriorities::POST_WRITE],
        ];
    }

    public function updateAlgolia(GetResponseForControllerResultEvent $event): void
    {
        $speaker = $event->getControllerResult();

        if ($speaker instanceof Speaker) {
            $this->algoliaPublisher->publish(json_encode(['id' => $speaker->getId()]));

            $this->logger->info("publish algolia message for speaker id {$speaker->getId()}");
        }
    }
}

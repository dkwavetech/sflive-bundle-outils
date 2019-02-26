<?php

declare(strict_types=1);

namespace App\Consumer;

use Algolia\SearchBundle\IndexManagerInterface;
use AlgoliaSearch\Client;
use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class AlgoliaConsumer implements ConsumerInterface
{
    private $indexManager;
    private $entityManager;
    private $algoliaClient;
    private $logger;

    public function __construct(
        IndexManagerInterface $indexManager,
        EntityManagerInterface $entityManager,
        Client $algoliaClient,
        LoggerInterface $logger = null
    ) {
        $this->indexManager = $indexManager;
        $this->entityManager = $entityManager;
        $this->algoliaClient = $algoliaClient;
        $this->logger = $logger ?: new NullLogger();
    }

    public function execute(AMQPMessage $msg)
    {
        $message = \json_decode($msg->getBody(), true);

        try {
            $repository = $this->entityManager->getRepository(Company::class);

            /** @var Company $entity */
            $entity = $repository->find($message['id']);

            $this->entityManager->refresh($entity);

            $this->indexManager->index($entity, $this->entityManager);
        } catch (\Exception $e) {
            return ConsumerInterface::MSG_REJECT;
        }

        return ConsumerInterface::MSG_ACK;
    }
}

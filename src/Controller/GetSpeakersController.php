<?php

namespace App\Controller;

use App\Entity\Speaker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

class GetSpeakersController
{
    /** @var EntityManagerInterface  */
    private $entityManager;

    /** @var SerializerInterface  */
    private $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/v2/speakers", name="hello")
     */
    public function __invoke(): Response
    {
        $speakers = $this->entityManager->getRepository(Speaker::class)->findAll();

        return new Response($this->serializer->serialize($speakers, 'json'));
    }
}

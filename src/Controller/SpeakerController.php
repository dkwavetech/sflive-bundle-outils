<?php

declare(strict_types=1);

namespace App\Controller;

use GuzzleHttp\Client;
use League\Flysystem\FileExistsException;
use League\Flysystem\Filesystem;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpeakerController
{
    /** @var Client */
    private $client;

    /** @var Filesystem  */
    private $filesystem;

    /** @var LoggerInterface  */
    private $logger;

    public function __construct(
        Client $client,
        Filesystem $filesystem,
        LoggerInterface $logger = null
    ) {
        $this->client = $client;
        $this->filesystem = $filesystem;
        $this->logger = $logger ?: new NullLogger();
    }

    /**
     * @Route(
     *     name="app_speaker_wiki",
     *     path="/api/wiki",
     *     methods={"GET"}
     * )
     */
    public function getWikiInfos(): Response
    {
        $response = $this->client->get('https://fr.wikipedia.org/w/api.php?action=opensearch&search=php');

        return new Response($response->getBody()->getContents(), $response->getStatusCode());
    }

    public function exportFile($filename)
    {
        try {
            $this->filesystem->write('/', file_get_contents($filename));
        } catch (FileExistsException $e) {
            $this->logger->alert($e->getMessage());
        }
    }

    public function excessiveMethodLength():string
    {
        $test1 = 1;
        //$test2 = 2;
        //d
        if ($test1 === '2') {
            return 'ok';
        }
    }

    /*private function unused()
    {
        return true;
    }*/
}

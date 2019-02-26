<?php

declare(strict_types=1);

namespace App\Controller;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController
{

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @Route(
     *     name="app_company_wiki",
     *     path="/api/wiki",
     *     methods={"GET"}
     * )
     */
    public function getWikiInfos(Request $request): Response
    {
        $response = $this->client->get('https://fr.wikipedia.org/w/api.php?action=opensearch&search=php');

        return new Response($response->getBody()->getContents(), $response->getStatusCode());
    }

    /**
     * @Route(
     *     name="app_company_secured",
     *     path="/api/secured",
     *     methods={"GET"}
     * )
     */
    public function getSecured(): Response
    {
        return new Response();
    }
}

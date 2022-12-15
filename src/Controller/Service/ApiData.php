<?php

namespace App\Controller\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiData
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    // get all data from api
    public function getApiData(): array
    {
        // get api
        $response = $this->client->request(
            'GET',
            'https://opendata.bordeaux-metropole.fr/api/records/1.0/search/?dataset=previsions_pont_chaban&q=&rows=75&timezone=Europe%2FParis'
        );

        // return an array from api
        return $response->toArray();
    }

    // get all closures data from a specific day
    public function getClosuresData(): array
    {
        $content = $this->getApiData();

        // define start day
        $today = '2022-09-01';

        $closures = [];

        // get only closures data from api start on $today
        foreach ($content['records'] as $closeData) {
            if ($closeData['fields']['date_passage'] > $today) {
                $closures[] = $closeData['fields'];
            }
        }

        // order by "date_passage" then by "fermeture_a_la_circulation"
        array_multisort(array_column($closures, "date_passage"),
            array_column($closures, "fermeture_a_la_circulation"),
            $closures);

        // change date format foreach closure
        foreach ($closures as &$closure) {
            $closure['date_passage'] = date('d-m-Y', strtotime($closure['date_passage']));
        }

        return $closures;
    }
}
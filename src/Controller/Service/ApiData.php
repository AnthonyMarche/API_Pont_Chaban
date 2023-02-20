<?php

namespace App\Controller\Service;

use DateTime;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiData
{
    private HttpClientInterface $client;
    private DateTime $today;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->today = new DateTime();
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

        $closures = [];

        // get only closures data from api start on $today
        foreach ($content['records'] as $closeData) {
            if (DateTime::createFromFormat('Y-m-d', $closeData['fields']['date_passage']) > $this->today) {
                $closures[] = $closeData['fields'];
            }
        }

        // order by "date_passage" then by "fermeture_a_la_circulation"
        array_multisort(array_column($closures, "date_passage"),
            array_column($closures, "fermeture_a_la_circulation"),
            $closures);
        // change date format foreach closure
        foreach ($closures as &$closure) {
            $closure['date_reformat'] = date('d/m/Y', strtotime($closure['date_passage']));
        }

        return $closures;
    }

    public function sortByMonth(): array
    {
        $closures = $this->getClosuresData();

        $closuresByMonth = [];

        // sort closure data by month
        foreach ($closures as $closure) {
            $month = date('m', strtotime($closure['date_passage']));
            if (!isset($closuresByMonth[$month])) {
                $closuresByMonth[$month] = [];
            }
            $closuresByMonth[$month][] = $closure;
        }

        // define key => French month name
        $monthNames = [
            '01' => 'JANVIER',
            '02' => 'FÉVRIER',
            '03' => 'MARS',
            '04' => 'AVRIL',
            '05' => 'MAI',
            '06' => 'JUIN',
            '07' => 'JUILLET',
            '08' => 'AOÛT',
            '09' => 'SEPTEMBRE',
            '10' => 'OCTOBRE',
            '11' => 'NOVEMBRE',
            '12' => 'DÉCEMBRE'
        ];

        // Replace the month numbers with their French name
        foreach ($closuresByMonth as $month => $monthClosures) {
            if (isset($monthNames[$month])) {
                $closuresByMonth[$monthNames[$month]] = $monthClosures;
                unset($closuresByMonth[$month]);
            }
        }

        return $closuresByMonth;
    }

    // get all reason to closure from a specific day
    public function getClosuresReasonData(): array
    {
        $content = $this->getApiData();

        $closuresReason = [];

        // get only closures data from api start on $today
        foreach ($content['records'] as $closuresData) {
            if (DateTime::createFromFormat('Y-m-d', $closuresData['fields']['date_passage']) > $this->today) {

                // get all reasons to closure
                $closuresReasonList = explode('/', $closuresData['fields']['bateau']);
                foreach ($closuresReasonList as $closureReasonValue) {
                    $closuresReason[] = trim($closureReasonValue);
                }
            }
        }

        // treatment to get only unique reason et order by asc
        $closuresReason = array_unique($closuresReason);
        sort($closuresReason);

        return $closuresReason;
    }

    // build next closure with first 'date_passage' and first 'fermeture_a_la_circulation'
    public function getNextClosure(): DateTime
    {
        $closures = $this->getClosuresData();
        return new DateTime($closures[0]['date_passage'] . " " . $closures[0]['fermeture_a_la_circulation']);
    }
}
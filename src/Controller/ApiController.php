<?php

namespace App\Controller;

use App\Controller\Service\ApiData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{

    #[Route('/', name: 'app_index')]
    public function index(ApiData $apiData,): Response
    {
        // get data from API
        $closures = $apiData->getClosuresData();

        return $this->render('api/index.html.twig', [
            'closures' => $closures,
        ]);
    }
}

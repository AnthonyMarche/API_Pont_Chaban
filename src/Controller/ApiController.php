<?php

namespace App\Controller;

use App\Controller\Service\ApiData;
use App\Controller\Service\ApiTreatment;
use App\Form\FilterApiType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request, ApiData $apiData, ApiTreatment $apiTreatment): Response
    {
        // get data from API
        $closures = $apiData->getClosuresData();
        $closuresReason = $apiData->getClosuresReasonData();

        // Create form from FilterApiType
        $form = $this->createForm(FilterApiType::class, $closuresReason);

        // Get data from HTTP request
        $form->handleRequest($request);

        // get data filter by reason selected
        if ($form->isSubmitted() && $form->isValid()) {
            $closures = $apiTreatment->treatmentFilterForm($form->getData(), $closures);
        }

        return $this->render('api/index.html.twig', [
            'closures' => $closures,
            'form' => $form->createView(),
            'closuresReason' => $closuresReason
        ]);
    }
}

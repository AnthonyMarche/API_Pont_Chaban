<?php

namespace App\Controller;

use App\Controller\Service\ApiData;
use App\Controller\Service\ApiFormTreatment;
use App\Controller\Service\Countdown;
use App\Form\FilterApiType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request, ApiData $apiData, ApiFormTreatment $apiFormTreatment): Response
    {
        // get date today
        $today = $apiData->getToday();

        // get data from API
        $closuresByMonth = $apiData->sortByMonth();
        $closuresReason = $apiData->getClosuresReasonData();

        // get next closure
        $nextClosure = $apiData->getNextClosure();

        // Create form from FilterApiType
        $form = $this->createForm(FilterApiType::class, $closuresReason);

        // Get data from HTTP request
        $form->handleRequest($request);

        // get data filter by reason selected
        if ($form->isSubmitted() && $form->isValid()) {
            $closuresByMonth = $apiFormTreatment->treatmentFilterForm($form->getData(), $closuresByMonth);
        }

        return $this->render('api/index.html.twig', [
            'today' => $today,
            'nextClosure' => $nextClosure,
            'closuresByMonth' => $closuresByMonth,
            'form' => $form->createView(),
            'closuresReason' => $closuresReason
        ]);
    }
}

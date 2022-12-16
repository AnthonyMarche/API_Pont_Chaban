<?php

namespace App\Controller\Service;

class ApiTreatment
{
    private array $results;

    // filter closures by reason selected
    public function filterReasonSelected($reason, $closures): array
    {
        foreach ($closures as $closure) {
            if (str_contains($closure['bateau'], $reason)) {
                $this->results[] = $closure;
            }
        }

        return $this->results;
    }

    // filter closures by date selected
    public function filterDateSelected($date, $closures): array
    {
        foreach ($closures as $closure) {
            if ($closure['date_passage'] === $date) {
                $this->results[] = $closure;
            }
        }

        return $this->results;
    }

    // filter closures by reason and date selected
    public function twoFiltersSelected($reason, $date, $closures): array
    {
        foreach ($closures as $closure) {
            if ($closure['date_passage'] === $date && str_contains($closure['bateau'], $reason)) {
                $this->results[] = $closure;
            }
        }

        return $this->results;
    }

    // get data with form filters selected
    public function treatmentFilterForm($filter, $closures): array
    {
        $reason = $filter['reason'];
        $date = $filter['date'];

        // change date format if exist
        if ($date) {
            $date = $date->format('d/m/Y');
        }

        // return new closures data with filter
        if ($reason && !$date) {
            $closures = $this->filterReasonSelected($reason, $closures);
        } elseif (!$reason && $date) {
            $closures = $this->filterDateSelected($date, $closures);
        } elseif ($reason && $date) {
            $closures = $this->twoFiltersSelected($reason, $date, $closures);
        }

        return $closures;
    }
}

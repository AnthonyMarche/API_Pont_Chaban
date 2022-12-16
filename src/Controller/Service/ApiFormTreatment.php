<?php

namespace App\Controller\Service;

class ApiFormTreatment
{
    private array $results;

    public function filterReasonSelected($reason, $closuresByMonth): array
    {
        $keys = array_keys($closuresByMonth);

        // check if key exist
        foreach ($keys as $key) {
            if (array_key_exists($key, $closuresByMonth)) {
                $filteredMonth = [];
                // if key exists, get all closures for this reason this month
                foreach ($closuresByMonth[$key] as $closure) {
                    if (str_contains($closure['bateau'], $reason)) {
                        $filteredMonth[] = $closure;
                    }
                }
                // get initial array format with closures filtered by reason
                $this->results[$key] = $filteredMonth;
            }
        }
        return $this->results;
    }


    // filter closures by date selected
    public function filterDateSelected($date, $closuresByMonth): array
    {
        $keys = array_keys($closuresByMonth);

        // check if key exist
        foreach ($keys as $key) {
            if (array_key_exists($key, $closuresByMonth)) {
                $filteredMonth = [];
                // if key exists, get all closures for this date this month
                foreach ($closuresByMonth[$key] as $closure) {
                    if ($closure['date_reformat'] === $date) {
                        $filteredMonth[] = $closure;
                    }
                }
                // get initial array format with closures filtered by date
                $this->results[$key] = $filteredMonth;
            }
        }
        return $this->results;
    }

    // filter closures by reason and date selected
    public function twoFiltersSelected($reason, $date, $closuresByMonth): array
    {
        $keys = array_keys($closuresByMonth);

        // check if key exist
        foreach ($keys as $key) {
            if (array_key_exists($key, $closuresByMonth)) {
                $filteredMonth = [];
                // if key exists, get all closures for this reason and this date this month
                foreach ($closuresByMonth[$key] as $closure) {
                    if ($closure['date_reformat'] === $date && str_contains($closure['bateau'], $reason)) {
                        $filteredMonth[] = $closure;
                    }
                }
                // get initial array format with closures filtered by reason and date
                $this->results[$key] = $filteredMonth;
            }
        }
        return $this->results;
    }

    // get data with form filters selected
    public function treatmentFilterForm($filter, $closuresByMonth): array
    {
        $reason = $filter['reason'];
        $date = $filter['date'];

        // change date format if exist
        if ($date) {
            $date = $date->format('d/m/Y');
        }

        // return new closures data with filter
        if ($reason && !$date) {
            $closuresByMonth = $this->filterReasonSelected($reason, $closuresByMonth);
        } elseif (!$reason && $date) {
            $closuresByMonth = $this->filterDateSelected($date, $closuresByMonth);
        } elseif ($reason && $date) {
            $closuresByMonth = $this->twoFiltersSelected($reason, $date, $closuresByMonth);
        }

        return $closuresByMonth;
    }
}

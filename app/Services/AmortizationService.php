<?php

namespace App\Services;

class AmortizationService
{
    /**
     * Generate a reducing balance (annuity) amortization schedule.
     *
     * @param  float  $principal  Principal loan amount
     * @param  float  $monthlyRate  Monthly interest rate as a percentage (e.g. 2 for 2%)
     * @param  int  $termMonths  Loan term in months
     * @param  string  $startDate  Disbursement date (Y-m-d)
     * @return array<int, array{installment_no: int, due_date: string, principal_due: float, interest_due: float, total_due: float}>
     */
    public function generate(float $principal, float $monthlyRate, int $termMonths, string $startDate): array
    {
        $r = $monthlyRate / 100;
        $schedule = [];
        $balance = $principal;

        // EMI = P * r * (1+r)^n / ((1+r)^n - 1)
        if ($r == 0) {
            $emi = round($principal / $termMonths, 2);
        } else {
            $emi = $principal * ($r * pow(1 + $r, $termMonths)) / (pow(1 + $r, $termMonths) - 1);
            $emi = round($emi, 2);
        }

        $date = new \DateTime($startDate);

        for ($i = 1; $i <= $termMonths; $i++) {
            $date->modify('+1 month');

            $interestDue = round($balance * $r, 2);

            // Last installment: pay exact remaining balance to avoid rounding drift
            if ($i === $termMonths) {
                $principalDue = round($balance, 2);
                $totalDue = round($principalDue + $interestDue, 2);
            } else {
                $principalDue = round($emi - $interestDue, 2);
                $totalDue = $emi;
            }

            $schedule[] = [
                'installment_no' => $i,
                'due_date' => $date->format('Y-m-d'),
                'principal_due' => $principalDue,
                'interest_due' => $interestDue,
                'total_due' => $totalDue,
            ];

            $balance = round($balance - $principalDue, 2);
        }

        return $schedule;
    }
}

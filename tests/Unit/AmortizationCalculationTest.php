<?php

use App\Services\AmortizationService;

test('verify that sum of principal due in amortization schedule equals original principal', function () {
    $service = new AmortizationService();
    
    $principal = 1000.00;
    $interestRate = 2.00; // 2% monthly
    $termMonths = 6;
    $startDate = '2026-08-28';

    $schedule = $service->generate($principal, $interestRate, $termMonths, $startDate);

    $sumPrincipalDue = 0.0;
    foreach ($schedule as $row) {
        $sumPrincipalDue += $row['principal_due'];
    }

    expect($sumPrincipalDue)->toEqual($principal);
});

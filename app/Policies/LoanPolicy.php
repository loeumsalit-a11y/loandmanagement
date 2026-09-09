<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;

class LoanPolicy
{
    /**
     * Determine if the user can view the loan.
     */
    public function view(User $user, Loan $loan): bool
    {
        return $user->isAdmin() || $user->isLoanOfficer() || $user->isCashier() || $loan->customer_id === $user->id;
    }

    /**
     * Determine if the user can approve the loan.
     */
    public function approve(User $user): bool
    {
        return $user->isAdmin() || $user->isLoanOfficer();
    }

    /**
     * Determine if the user can disburse the loan.
     */
    public function disburse(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can record repayment.
     */
    public function repay(User $user): bool
    {
        return $user->isCashier();
    }
}

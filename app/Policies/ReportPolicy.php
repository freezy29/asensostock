<?php

namespace App\Policies;

use App\Models\User;

class ReportPolicy
{
    /**
     * Determine whether the user can view reports.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view reports, but with different levels of access
        return true;
    }

    /**
     * Determine whether the user can view financial reports.
     */
    public function viewFinancial(User $user): bool
    {
        // Only admins and super admins can view financial data
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can export reports.
     */
    public function export(User $user): bool
    {
        // Only admins and super admins can export reports
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can view all transactions (not just their own).
     */
    public function viewAllTransactions(User $user): bool
    {
        // Only admins and super admins can view all transactions
        return in_array($user->role, ['admin', 'super_admin']);
    }
}


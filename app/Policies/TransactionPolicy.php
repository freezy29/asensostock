<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransactionPolicy
{
    /**
     * Determine whether the user can view any models.
     * Note: All authenticated users can access the transactions list,
     * but data is filtered by ownership in TransactionController::index()
     * to ensure staff only see their own transactions.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        // Staff can only view their own transactions
        if ($user->role === 'staff') {
            return $transaction->user_id === $user->id;
        }

        // Admin and super_admin can view all transactions
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Transaction $transaction): bool
    {
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Transaction $transaction): bool
    {
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Transaction $transaction): bool
    {
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Transaction $transaction): bool
    {
        return $user->role === 'super_admin';
    }
}

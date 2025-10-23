<?php

namespace App\Policies;

use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductVariantPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdministrator()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if (!$user) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductVariant $productVariant): bool
    {
        if (!$user) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductVariant $productVariant): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductVariant $productVariant): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProductVariant $productVariant): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProductVariant $productVariant): bool
    {
        return false;
    }
}

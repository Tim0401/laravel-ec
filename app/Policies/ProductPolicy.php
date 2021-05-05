<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Seller  $seller
     * @return mixed
     */
    public function viewAny(Seller $seller)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Seller  $seller
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function view(Seller $seller, Product $product)
    {
        return $seller->id === $product->seller_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Seller  $seller
     * @return mixed
     */
    public function create(Seller $seller)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Seller  $seller
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function update(Seller $seller, Product $product)
    {
        return $seller->id === $product->seller_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Seller  $seller
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function delete(Seller $seller, Product $product)
    {
        return $seller->id === $product->seller_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Seller  $seller
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function restore(Seller $seller, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Seller  $seller
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function forceDelete(Seller $seller, Product $product)
    {
        //
    }
}

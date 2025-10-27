<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductUnit extends Model
{
    protected $table = 'product_units';

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

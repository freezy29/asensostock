<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'unit_id',
        'stock_quantity',
        'price',
        'critical_level',
        'status'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Calculate weighted average cost price from stock-in transactions.
     * This represents the actual cost of current inventory.
     * Uses aggregation query for optimal performance.
     */
    public function getAverageCostPrice(): float
    {
        // Use aggregation query instead of loading all transactions
        $result = $this->transactions()
            ->where('type', 'in')
            ->selectRaw('SUM(total_amount) as total_cost, SUM(quantity) as total_quantity')
            ->first();

        if (!$result || $result->total_quantity == 0 || $result->total_cost == null) {
            // No transactions yet, estimate as 65% of selling price (fallback)
            return $this->price * 0.65;
        }

        return round($result->total_cost / $result->total_quantity, 2);
    }

    /**
     * Calculate the cost value of current stock.
     * Uses weighted average cost for accurate inventory valuation.
     */
    public function getCostValue(): float
    {
        if ($this->stock_quantity <= 0) {
            return 0;
        }

        $averageCost = $this->getAverageCostPrice();
        return round($this->stock_quantity * $averageCost, 2);
    }

    /**
     * Calculate the retail value of current stock (selling price).
     */
    public function getRetailValue(): float
    {
        return round($this->stock_quantity * $this->price, 2);
    }

    /**
     * Get the most recent cost price from transactions.
     * Useful for suggesting cost when creating new transactions.
     * Uses optimized query with only cost_price and created_at.
     */
    public function getLatestCostPrice(): ?float
    {
        $latestTransaction = $this->transactions()
            ->where('type', 'in')
            ->select('cost_price', 'created_at') // Only select needed columns
            ->orderBy('created_at', 'desc')
            ->first();

        if ($latestTransaction) {
            return $latestTransaction->cost_price;
        }

        // Fallback to estimated cost
        return $this->price * 0.65;
    }
}

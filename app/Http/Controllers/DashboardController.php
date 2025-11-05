<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        // Key Metrics - Stock Overview
        // Use same base query logic as navbar for consistency
        $stockBase = Product::query();
        if (!in_array($user->role, ['admin', 'super_admin'])) {
            $stockBase->where('status', 'active');
        } else {
            $stockBase->where('status', 'active'); // Still filter active for dashboard
        }
        
        $totalProducts = (clone $stockBase)->count();
        
        // Calculate total stock value using cost price (optimized with aggregation)
        // Use raw SQL aggregation to avoid N+1 queries
        $stockValueData = (clone $stockBase)
            ->leftJoin('transactions', function($join) {
                $join->on('products.id', '=', 'transactions.product_id')
                     ->where('transactions.type', '=', 'in');
            })
            ->selectRaw('
                products.id,
                products.stock_quantity,
                products.price,
                COALESCE(SUM(transactions.total_amount), 0) as total_cost,
                COALESCE(SUM(transactions.quantity), 0) as total_quantity
            ')
            ->groupBy('products.id', 'products.stock_quantity', 'products.price')
            ->get();
        
        $totalStockValue = $stockValueData->sum(function($item) {
            if ($item->total_quantity > 0) {
                $avgCost = $item->total_cost / $item->total_quantity;
            } else {
                $avgCost = $item->price * 0.65; // Fallback
            }
            return round($item->stock_quantity * $avgCost, 2);
        });
        
        // Calculate retail value (simple calculation)
        $totalRetailValue = (clone $stockBase)
            ->selectRaw('SUM(stock_quantity * price) as total')
            ->first()
            ->total ?? 0;

        // Match navbar logic exactly
        $lowStockQuery = (clone $stockBase)
            ->whereRaw('stock_quantity <= (critical_level * 1.5)');
        
        $totalAlerts = (clone $lowStockQuery)->count(); // This should match navbar count
        
        $criticalStock = (clone $stockBase)
            ->whereRaw('stock_quantity <= critical_level')
            ->count();
        
        $lowStock = (clone $stockBase)
            ->whereRaw('stock_quantity > critical_level AND stock_quantity <= (critical_level * 1.5)')
            ->count();

        $zeroStock = (clone $stockBase)
            ->where('stock_quantity', 0)
            ->count();

        // Stock Alerts - Match navbar query logic
        $criticalProducts = (clone $stockBase)
            ->whereRaw('stock_quantity <= critical_level')
            ->with(['category', 'unit'])
            ->orderByRaw('stock_quantity / NULLIF(critical_level, 0)')
            ->limit(10)
            ->get();

        $lowStockProducts = (clone $stockBase)
            ->whereRaw('stock_quantity > critical_level AND stock_quantity <= (critical_level * 1.5)')
            ->with(['category', 'unit'])
            ->orderByRaw('stock_quantity / NULLIF(critical_level, 0)')
            ->limit(10)
            ->get();

        // Transaction Queries - Filter by user role
        $transactionQuery = Transaction::query();
        
        // Staff can only see their own transactions
        if ($user->role === 'staff') {
            $transactionQuery->where('user_id', $user->id);
        }

        // Today's Transactions
        $todayTransactions = (clone $transactionQuery)
            ->whereDate('created_at', $today)
            ->count();

        $todayStockIn = (clone $transactionQuery)
            ->whereDate('created_at', $today)
            ->where('type', 'in')
            ->sum('quantity');

        $todayStockOut = (clone $transactionQuery)
            ->whereDate('created_at', $today)
            ->where('type', 'out')
            ->sum('quantity');

        // Recent Transactions
        $recentTransactions = (clone $transactionQuery)
            ->with(['product.category', 'product.unit', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // This Week's Activity
        $weekTransactions = (clone $transactionQuery)
            ->whereBetween('created_at', [$startOfWeek, Carbon::now()->endOfDay()])
            ->count();

        // This Month's Activity
        $monthTransactions = (clone $transactionQuery)
            ->whereBetween('created_at', [$startOfMonth, Carbon::now()->endOfDay()])
            ->count();

        // Top Products by Activity (Last 30 days)
        $topProducts = Product::where('status', 'active')
            ->withCount(['transactions' => function($query) use ($user) {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
                if ($user->role === 'staff') {
                    $query->where('user_id', $user->id);
                }
            }])
            ->orderBy('transactions_count', 'desc')
            ->limit(5)
            ->get();

        // Transaction Trends (Last 7 days) - for chart
        $transactionTrends = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dayStart = Carbon::parse($date)->startOfDay();
            $dayEnd = Carbon::parse($date)->endOfDay();
            
            $dayQuery = (clone $transactionQuery)
                ->whereBetween('created_at', [$dayStart, $dayEnd]);
            
            $transactionTrends[] = [
                'date' => Carbon::parse($date)->format('M d'),
                'in' => (clone $dayQuery)->where('type', 'in')->count(),
                'out' => (clone $dayQuery)->where('type', 'out')->count(),
            ];
        }

        // Role-based permissions
        $canViewFinancial = in_array($user->role, ['admin', 'super_admin']);

        return view('dashboard.index', [
            'totalProducts' => $totalProducts,
            'totalStockValue' => $totalStockValue,
            'totalRetailValue' => $totalRetailValue,
            'totalAlerts' => $totalAlerts,
            'criticalStock' => $criticalStock,
            'lowStock' => $lowStock,
            'zeroStock' => $zeroStock,
            'criticalProducts' => $criticalProducts,
            'lowStockProducts' => $lowStockProducts,
            'todayTransactions' => $todayTransactions,
            'todayStockIn' => $todayStockIn,
            'todayStockOut' => $todayStockOut,
            'recentTransactions' => $recentTransactions,
            'weekTransactions' => $weekTransactions,
            'monthTransactions' => $monthTransactions,
            'topProducts' => $topProducts,
            'transactionTrends' => $transactionTrends,
            'canViewFinancial' => $canViewFinancial,
        ]);
    }
}


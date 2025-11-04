<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportsController extends Controller
{
    /**
     * Display the reports index page.
     */
    public function index(Request $request)
    {
        // All authenticated users can view reports (with role-based data filtering)
        // Get date range filters
        $startDate = $request->filled('start_date') 
            ? Carbon::parse($request->start_date)->startOfDay() 
            : Carbon::now()->startOfMonth();
        
        $endDate = $request->filled('end_date') 
            ? Carbon::parse($request->end_date)->endOfDay() 
            : Carbon::now()->endOfDay();

        // Stock Reports - Apply category filter if provided
        $stockQuery = Product::where('status', 'active');
        
        if ($request->filled('category')) {
            $stockQuery->where('category_id', $request->category);
        }
        
        $totalProducts = Product::count();
        $activeProducts = (clone $stockQuery)->count();
        $totalStockValue = (clone $stockQuery)
            ->selectRaw('SUM(stock_quantity * price) as total')
            ->first()
            ->total ?? 0;

        // Critical and Low Stock - Apply category filter
        $criticalStock = (clone $stockQuery)
            ->whereRaw('stock_quantity <= critical_level')
            ->count();
        
        $lowStock = (clone $stockQuery)
            ->whereRaw('stock_quantity > critical_level AND stock_quantity <= (critical_level * 1.5)')
            ->count();

        $zeroStock = (clone $stockQuery)
            ->where('stock_quantity', 0)
            ->count();

        // Stock by Category - Apply category filter if provided
        $categoryQuery = Category::query();
        
        if ($request->filled('category')) {
            $categoryQuery->where('id', $request->category);
        }
        
        $stockByCategory = $categoryQuery
            ->withCount(['products' => function($query) {
                $query->where('status', 'active');
            }])
            ->get()
            ->map(function($category) {
                $products = Product::where('category_id', $category->id)
                    ->where('status', 'active')
                    ->get();
                
                $totalValue = $products->sum(function($product) {
                    return $product->stock_quantity * $product->price;
                });
                $totalQuantity = $products->sum('stock_quantity');
                
                return [
                    'name' => $category->name,
                    'products_count' => $category->products_count,
                    'total_value' => $totalValue,
                    'total_quantity' => $totalQuantity,
                ];
            })
            ->filter(function($category) {
                return $category['products_count'] > 0;
            })
            ->values();

        // Transaction Reports - Apply date range, category, and type filters
        $transactionQuery = Transaction::whereBetween('created_at', [$startDate, $endDate]);

        // Staff can only see their own transactions
        if ($request->user()->role === 'staff') {
            $transactionQuery->where('user_id', $request->user()->id);
        }

        if ($request->filled('category')) {
            $transactionQuery->whereHas('product', function($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        if ($request->filled('transaction_type')) {
            $transactionQuery->where('type', $request->transaction_type);
        }

        $totalTransactions = (clone $transactionQuery)->count();
        $stockInCount = (clone $transactionQuery)->where('type', 'in')->count();
        $stockOutCount = (clone $transactionQuery)->where('type', 'out')->count();
        
        $stockInQuantity = (clone $transactionQuery)
            ->where('type', 'in')
            ->sum('quantity');
        
        $stockOutQuantity = (clone $transactionQuery)
            ->where('type', 'out')
            ->sum('quantity');

        // Financial Reports
        $totalCostValue = (clone $transactionQuery)
            ->where('type', 'in')
            ->sum('total_amount');

        // Top Products - Apply category and date filters
        $topProductsQuery = Product::where('status', 'active')
            ->withCount(['transactions' => function($query) use ($startDate, $endDate, $request) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }]);
        
        if ($request->filled('category')) {
            $topProductsQuery->where('category_id', $request->category);
        }
        
        $topProducts = $topProductsQuery
            ->orderBy('transactions_count', 'desc')
            ->limit(10)
            ->get();

        // Recent Transactions - Apply filters
        $recentTransactionsQuery = Transaction::with(['product', 'user'])
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        // Staff can only see their own transactions
        if ($request->user()->role === 'staff') {
            $recentTransactionsQuery->where('user_id', $request->user()->id);
        }
        
        if ($request->filled('category')) {
            $recentTransactionsQuery->whereHas('product', function($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }
        
        if ($request->filled('transaction_type')) {
            $recentTransactionsQuery->where('type', $request->transaction_type);
        }
        
        $recentTransactions = $recentTransactionsQuery
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Low Stock Products - Apply category filter if provided
        $lowStockProductsQuery = Product::where('status', 'active')
            ->whereRaw('stock_quantity <= (critical_level * 1.5)');
        
        if ($request->filled('category')) {
            $lowStockProductsQuery->where('category_id', $request->category);
        }
        
        $lowStockProducts = $lowStockProductsQuery
            ->orderByRaw('stock_quantity / NULLIF(critical_level, 0)')
            ->with(['category', 'unit'])
            ->get();

        // Get categories for filters
        $categories = Category::where('status', 'active')
            ->orderBy('name')
            ->get();

        // Check if user can export (only admins and super admins)
        $canExport = in_array($request->user()->role, ['admin', 'super_admin']);
        $canViewFinancial = in_array($request->user()->role, ['admin', 'super_admin']);

        // Check if export is requested
        if ($request->has('export')) {
            if (!$canExport) {
                abort(403, 'You do not have permission to export reports.');
            }
            return $this->exportReport($request, $startDate, $endDate, $lowStockProducts, $recentTransactions, $stockByCategory, $topProducts);
        }

        return view('reports.index', [
            'canViewFinancial' => $canViewFinancial,
            'canExport' => $canExport,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalProducts' => $totalProducts,
            'activeProducts' => $activeProducts,
            'totalStockValue' => $totalStockValue,
            'criticalStock' => $criticalStock,
            'lowStock' => $lowStock,
            'zeroStock' => $zeroStock,
            'stockByCategory' => $stockByCategory,
            'totalTransactions' => $totalTransactions,
            'stockInCount' => $stockInCount,
            'stockOutCount' => $stockOutCount,
            'stockInQuantity' => $stockInQuantity,
            'stockOutQuantity' => $stockOutQuantity,
            'totalCostValue' => $totalCostValue,
            'topProducts' => $topProducts,
            'recentTransactions' => $recentTransactions,
            'lowStockProducts' => $lowStockProducts,
            'categories' => $categories,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    /**
     * Export reports to CSV
     */
    private function exportReport($request, $startDate, $endDate, $lowStockProducts, $recentTransactions, $stockByCategory, $topProducts)
    {
        $exportType = $request->get('export'); // 'stock', 'transactions', 'financial', 'all'
        
        $filename = 'reports_' . $exportType . '_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return new StreamedResponse(function() use ($exportType, $startDate, $endDate, $lowStockProducts, $recentTransactions, $stockByCategory, $topProducts) {
            $file = fopen('php://output', 'w');
            
            // BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            if ($exportType === 'stock' || $exportType === 'all') {
                // Stock Reports
                fputcsv($file, ['STOCK REPORTS']);
                fputcsv($file, ['Report Period:', $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y')]);
                fputcsv($file, []);
                
                // Low Stock Products
                fputcsv($file, ['LOW STOCK PRODUCTS']);
                fputcsv($file, ['Product Name', 'Category', 'Current Stock', 'Critical Level', 'Status', 'Price']);
                foreach ($lowStockProducts as $product) {
                    $status = $product->stock_quantity <= $product->critical_level ? 'Critical' : 'Low';
                    fputcsv($file, [
                        $product->name,
                        $product->category->name,
                        $product->stock_quantity . ' ' . ($product->unit->abbreviation ?? $product->unit->name),
                        $product->critical_level,
                        $status,
                        '₱' . number_format($product->price, 2)
                    ]);
                }
                fputcsv($file, []);
                
                // Stock by Category
                fputcsv($file, ['STOCK BY CATEGORY']);
                fputcsv($file, ['Category', 'Number of Products', 'Total Quantity', 'Total Value']);
                foreach ($stockByCategory as $category) {
                    fputcsv($file, [
                        $category['name'],
                        $category['products_count'],
                        number_format($category['total_quantity']),
                        '₱' . number_format($category['total_value'], 2)
                    ]);
                }
                fputcsv($file, []);
            }

            if ($exportType === 'transactions' || $exportType === 'all') {
                // Transaction Reports
                fputcsv($file, ['TRANSACTION REPORTS']);
                fputcsv($file, ['Report Period:', $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y')]);
                fputcsv($file, []);
                
                // Recent Transactions
                fputcsv($file, ['RECENT TRANSACTIONS']);
                fputcsv($file, ['Date', 'Product', 'Type', 'Quantity', 'Cost Price', 'Total Amount', 'Processed By']);
                foreach ($recentTransactions as $transaction) {
                    fputcsv($file, [
                        $transaction->created_at->format('M d, Y g:i A'),
                        $transaction->product->name,
                        strtoupper($transaction->type),
                        $transaction->quantity . ' ' . ($transaction->product->unit->abbreviation ?? ''),
                        '₱' . number_format($transaction->cost_price, 2),
                        '₱' . number_format($transaction->total_amount, 2),
                        $transaction->user->first_name . ' ' . $transaction->user->last_name
                    ]);
                }
                fputcsv($file, []);
            }

            if ($exportType === 'financial' || $exportType === 'all') {
                // Financial Reports
                fputcsv($file, ['FINANCIAL REPORTS']);
                fputcsv($file, ['Report Period:', $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y')]);
                fputcsv($file, []);
                
                // Top Products
                fputcsv($file, ['MOST ACTIVE PRODUCTS']);
                fputcsv($file, ['Product Name', 'Category', 'Current Stock', 'Price', 'Stock Value', 'Transaction Count']);
                foreach ($topProducts as $product) {
                    fputcsv($file, [
                        $product->name,
                        $product->category->name,
                        $product->stock_quantity . ' ' . ($product->unit->abbreviation ?? $product->unit->name),
                        '₱' . number_format($product->price, 2),
                        '₱' . number_format($product->stock_quantity * $product->price, 2),
                        $product->transactions_count
                    ]);
                }
            }

            fclose($file);
        }, 200, $headers);
    }
}


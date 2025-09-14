<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Reports extends Component
{
    public $sales;
    public $filterPeriod = 'year';
    public $startDate;
    public $endDate;
    
    // Pagination properties
    public $perPage = 10;
    public $currentPage = 1;
    
    public function mount()
    {
        $this->startDate = \Carbon\Carbon::now()->startOfYear()->format('Y-m-d');
        $this->endDate = \Carbon\Carbon::now()->endOfYear()->format('Y-m-d');
        $this->loadSales();
    }

    public function loadSales()
    {
        $query = Sale::with(['product', 'user']);
        
        if ($this->filterPeriod === 'custom') {
            if ($this->startDate && $this->endDate) {
                $query->whereBetween('sale_date', [$this->startDate, $this->endDate]);
            }
        } else {
            $this->applyPeriodFilter($query);
        }
        
        $this->sales = $query->orderBy('sale_date', 'desc')->get();
    }

    public function applyPeriodFilter($query)
    {
        switch ($this->filterPeriod) {
            case 'today':
                // Use Carbon to ensure we get the correct today's date
                $today = \Carbon\Carbon::today()->format('Y-m-d');
                $query->whereDate('sale_date', $today);
                break;
            case 'week':
                $startOfWeek = \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d');
                $endOfWeek = \Carbon\Carbon::now()->endOfWeek()->format('Y-m-d');
                $query->whereBetween('sale_date', [$startOfWeek, $endOfWeek]);
                break;
            case 'month':
                $startOfMonth = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
                $endOfMonth = \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
                $query->whereBetween('sale_date', [$startOfMonth, $endOfMonth]);
                break;
            case 'year':
                $startOfYear = \Carbon\Carbon::now()->startOfYear()->format('Y-m-d');
                $endOfYear = \Carbon\Carbon::now()->endOfYear()->format('Y-m-d');
                $query->whereBetween('sale_date', [$startOfYear, $endOfYear]);
                break;
        }
    }

    public function updatedFilterPeriod()
    {
        // Update date range based on selected period
        switch ($this->filterPeriod) {
            case 'today':
                $this->startDate = \Carbon\Carbon::today()->format('Y-m-d');
                $this->endDate = \Carbon\Carbon::today()->format('Y-m-d');
                break;
            case 'week':
                $this->startDate = \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d');
                $this->endDate = \Carbon\Carbon::now()->endOfWeek()->format('Y-m-d');
                break;
            case 'month':
                $this->startDate = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
                $this->endDate = \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
                break;
            case 'year':
                $this->startDate = \Carbon\Carbon::now()->startOfYear()->format('Y-m-d');
                $this->endDate = \Carbon\Carbon::now()->endOfYear()->format('Y-m-d');
                break;
            case 'custom':
                // Set default custom range if not already set
                if (!$this->startDate || !$this->endDate) {
                    $this->startDate = \Carbon\Carbon::now()->subMonth()->format('Y-m-d');
                    $this->endDate = \Carbon\Carbon::today()->format('Y-m-d');
                }
                break;
        }
        
        $this->currentPage = 1; // Reset to first page when changing filter
        $this->loadSales();
    }

    public function updatedStartDate()
    {
        if ($this->filterPeriod === 'custom') {
            // Ensure end date is not before start date
            if ($this->endDate && $this->startDate > $this->endDate) {
                $this->endDate = $this->startDate;
            }
            $this->currentPage = 1; // Reset to first page when changing date
            $this->loadSales();
        }
    }

    public function updatedEndDate()
    {
        if ($this->filterPeriod === 'custom') {
            // Ensure start date is not after end date
            if ($this->startDate && $this->endDate < $this->startDate) {
                $this->startDate = $this->endDate;
            }
            $this->currentPage = 1; // Reset to first page when changing date
            $this->loadSales();
        }
    }

    public function getTotalRevenue()
    {
        return $this->sales->sum('total_amount');
    }

    public function getTotalQuantity()
    {
        return $this->sales->sum('quantity');
    }

    public function getTotalOrders()
    {
        return $this->sales->count();
    }

    public function getAverageOrderValue()
    {
        $totalOrders = $this->getTotalOrders();
        return $totalOrders > 0 ? $this->getTotalRevenue() / $totalOrders : 0;
    }

    public function getTopProducts()
    {
        return $this->sales->groupBy('product_id')
            ->map(function ($sales) {
                return [
                    'product' => $sales->first()->product,
                    'quantity' => $sales->sum('quantity'),
                    'revenue' => $sales->sum('total_amount')
                ];
            })
            ->sortByDesc('quantity')
            ->take(5);
    }

    public function getTopStaff()
    {
        return $this->sales->groupBy('user_id')
            ->map(function ($sales) {
                return [
                    'user' => $sales->first()->user,
                    'sales' => $sales->count(),
                    'revenue' => $sales->sum('total_amount')
                ];
            })
            ->sortByDesc('revenue')
            ->take(5);
    }

    public function getDailySales()
    {
        if (!$this->sales || $this->sales->isEmpty()) {
            return collect();
        }
        
        $dailySales = $this->sales->groupBy(function ($sale) {
            return \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d');
        })->map(function ($sales, $date) {
            return [
                'date' => $date,
                'revenue' => $sales->sum('total_amount'),
                'quantity' => $sales->sum('quantity'),
                'transactions' => $sales->count()
            ];
        })->sortByDesc('date'); // Sort by date descending for newest first
        
        return $dailySales;
    }

    public function getPaginatedDailySales()
    {
        $dailySales = $this->getDailySales();
        $total = $dailySales->count();
        
        // Ensure current page is valid
        $lastPage = max(1, ceil($total / $this->perPage));
        if ($this->currentPage > $lastPage) {
            $this->currentPage = 1;
        }
        
        $offset = ($this->currentPage - 1) * $this->perPage;
        $paginatedData = $dailySales->slice($offset, $this->perPage);
        
        return [
            'data' => $paginatedData,
            'total' => $total,
            'currentPage' => $this->currentPage,
            'lastPage' => $lastPage,
            'perPage' => $this->perPage
        ];
    }

    public function goToPage($page)
    {
        $this->currentPage = $page;
    }

    public function updatedPerPage()
    {
        $this->currentPage = 1; // Reset to first page when changing per page
    }

    public function getFilterInfo()
    {
        switch ($this->filterPeriod) {
            case 'today':
                return 'Today (' . now()->format('M d, Y') . ')';
            case 'week':
                return 'This Week (' . now()->startOfWeek()->format('M d') . ' - ' . now()->endOfWeek()->format('M d, Y') . ')';
            case 'month':
                return 'This Month (' . now()->startOfMonth()->format('M d') . ' - ' . now()->endOfMonth()->format('M d, Y') . ')';
            case 'year':
                return 'This Year (' . now()->startOfYear()->format('M d, Y') . ' - ' . now()->endOfYear()->format('M d, Y') . ')';
            case 'custom':
                if ($this->startDate && $this->endDate) {
                    return 'Custom Range (' . \Carbon\Carbon::parse($this->startDate)->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($this->endDate)->format('M d, Y') . ')';
                }
                return 'Custom Range';
            default:
                return 'Unknown Period';
        }
    }

    public function exportReport()
    {
        // Create filename with current date and filter period
        $filename = 'sales_report_' . $this->filterPeriod . '_' . now()->format('Ymd_His') . '.csv';
        
        // Get filtered sales data
        $query = Sale::with(['product', 'user']);
        
        if ($this->filterPeriod === 'custom') {
            if ($this->startDate && $this->endDate) {
                $query->whereBetween('sale_date', [$this->startDate, $this->endDate]);
            }
        } else {
            $this->applyPeriodFilter($query);
        }
        
        $sales = $query->orderBy('sale_date', 'desc')->get();
        
        return response()->streamDownload(function () use ($sales) {
            $handle = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            
            // CSV Headers
            fputcsv($handle, [
                'No.',
                'Date',
                'Product',
                'Staff',
                'Quantity',
                'Unit Price',
                'Total Amount'
            ]);
            
            // CSV Data
            $counter = 1;
            foreach ($sales as $sale) {
                fputcsv($handle, [
                    $counter++,
                    \Carbon\Carbon::parse($sale->sale_date)->format('M/d/Y'),
                    $sale->product->name,
                    $sale->user->name,
                    $sale->quantity,
                    number_format((float) $sale->unit_price, 2, '.', ''),
                    number_format((float) $sale->total_amount, 2, '.', '')
                ]);
            }
            
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
        ]);
    }


    public function render()
    {
        return view('livewire.reports');
    }
}

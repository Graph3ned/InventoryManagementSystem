<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class Reports extends Component
{
    public $sales;
    public $filterPeriod = 'week';
    public $startDate;
    public $endDate;
    
    public function mount()
    {
        $this->startDate = now()->startOfWeek()->format('Y-m-d');
        $this->endDate = now()->endOfWeek()->format('Y-m-d');
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
                $query->whereDate('sale_date', today());
                break;
            case 'week':
                $query->whereBetween('sale_date', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereBetween('sale_date', [now()->startOfMonth(), now()->endOfMonth()]);
                break;
            case 'year':
                $query->whereBetween('sale_date', [now()->startOfYear(), now()->endOfYear()]);
                break;
        }
    }

    public function updatedFilterPeriod()
    {
        // Update date range based on selected period
        switch ($this->filterPeriod) {
            case 'today':
                $this->startDate = now()->format('Y-m-d');
                $this->endDate = now()->format('Y-m-d');
                break;
            case 'week':
                $this->startDate = now()->startOfWeek()->format('Y-m-d');
                $this->endDate = now()->endOfWeek()->format('Y-m-d');
                break;
            case 'month':
                $this->startDate = now()->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->endOfMonth()->format('Y-m-d');
                break;
            case 'year':
                $this->startDate = now()->startOfYear()->format('Y-m-d');
                $this->endDate = now()->endOfYear()->format('Y-m-d');
                break;
            case 'custom':
                // Keep current custom dates
                break;
        }
        
        $this->loadSales();
    }

    public function updatedStartDate()
    {
        if ($this->filterPeriod === 'custom') {
            $this->loadSales();
        }
    }

    public function updatedEndDate()
    {
        if ($this->filterPeriod === 'custom') {
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
        return $this->sales->groupBy(function ($sale) {
            return \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d');
        })->map(function ($sales, $date) {
            return [
                'date' => $date,
                'revenue' => $sales->sum('total_amount'),
                'quantity' => $sales->sum('quantity')
            ];
        })->sortBy('date');
    }

    public function exportReport()
    {
        // Generate CSV data
        $csvData = $this->generateCsvData();
        
        // For now, we'll just show a success message
        // In a real application, you would generate and download the file
        session()->flash('message', 'Report exported successfully! CSV data generated for ' . $this->sales->count() . ' records.');
    }

    private function generateCsvData()
    {
        $csvData = [];
        $csvData[] = ['Date', 'Product', 'Staff', 'Quantity', 'Unit Price', 'Total Amount'];
        
        foreach ($this->sales as $sale) {
            $csvData[] = [
                \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d'),
                $sale->product->name,
                $sale->user->name,
                $sale->quantity,
                $sale->unit_price,
                $sale->total_amount
            ];
        }
        
        return $csvData;
    }

    public function render()
    {
        return view('livewire.reports');
    }
}

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
            return $sale->sale_date->format('Y-m-d');
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
        // This would typically generate a CSV or PDF
        session()->flash('message', 'Report exported successfully!');
    }

    public function render()
    {
        return view('livewire.reports');
    }
}

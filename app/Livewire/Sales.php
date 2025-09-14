<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;

class Sales extends Component
{
    public $sales;
    public $products;
    public $showModal = false;
    public $editingSale = null;
    
    // Form fields
    public $product_id = '';
    public $quantity = '';
    public $unit_price = '';
    public $sale_date = '';
    
    protected $rules = [
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'unit_price' => 'required|numeric|min:0',
        'sale_date' => 'required|date',
    ];

    public function mount()
    {
        $this->loadSales();
        $this->loadProducts();
        $this->sale_date = now()->format('Y-m-d');
    }

    public function loadSales()
    {
        $this->sales = Sale::with(['product', 'user'])->orderBy('created_at', 'desc')->get();
    }

    public function loadProducts()
    {
        $this->products = Product::where('status', 'active')->get();
    }

    public function openModal($saleId = null)
    {
        if ($saleId) {
            $this->editingSale = Sale::find($saleId);
            $this->product_id = $this->editingSale->product_id;
            $this->quantity = $this->editingSale->quantity;
            $this->unit_price = $this->editingSale->unit_price;
            $this->sale_date = $this->editingSale->sale_date;
        } else {
            $this->resetForm();
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingSale = null;
        $this->product_id = '';
        $this->quantity = '';
        $this->unit_price = '';
        $this->sale_date = now()->format('Y-m-d');
    }

    public function updatedProductId()
    {
        if ($this->product_id) {
            $product = Product::find($this->product_id);
            $this->unit_price = $product ? $product->price : '';
        }
    }

    public function save()
    {
        $this->validate();

        $product = Product::find($this->product_id);
        
        // Check if there's enough stock
        if ($product->stock_quantity < $this->quantity) {
            session()->flash('error', 'Insufficient stock! Available: ' . $product->stock_quantity);
            return;
        }

        $totalAmount = $this->quantity * $this->unit_price;

        if ($this->editingSale) {
            $this->editingSale->update([
                'product_id' => $this->product_id,
                'user_id' => auth()->id(),
                'quantity' => $this->quantity,
                'unit_price' => $this->unit_price,
                'total_amount' => $totalAmount,
                'sale_date' => $this->sale_date,
            ]);
            session()->flash('message', 'Sale updated successfully!');
        } else {
            Sale::create([
                'product_id' => $this->product_id,
                'user_id' => auth()->id(),
                'quantity' => $this->quantity,
                'unit_price' => $this->unit_price,
                'total_amount' => $totalAmount,
                'sale_date' => $this->sale_date,
                'status' => 'completed',
            ]);
            session()->flash('message', 'Sale recorded successfully!');
        }

        // Update product stock
        $product->decrement('stock_quantity', $this->quantity);
        
        $this->loadSales();
        $this->loadProducts();
        $this->closeModal();
    }

    public function delete($saleId)
    {
        $sale = Sale::find($saleId);
        
        // Restore stock
        $sale->product->increment('stock_quantity', $sale->quantity);
        
        $sale->delete();
        session()->flash('message', 'Sale deleted successfully!');
        $this->loadSales();
        $this->loadProducts();
    }

    public function getTotalSales()
    {
        return $this->sales->sum('total_amount');
    }

    public function getTotalQuantity()
    {
        return $this->sales->sum('quantity');
    }

    public function getTodaySales()
    {
        return $this->sales->where('sale_date', now()->format('Y-m-d'))->sum('total_amount');
    }

    public function getTodayQuantity()
    {
        return $this->sales->where('sale_date', now()->format('Y-m-d'))->sum('quantity');
    }

    public function render()
    {
        return view('livewire.sales');
    }
}

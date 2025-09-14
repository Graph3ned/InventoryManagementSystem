<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Models\InventoryLog;
use Illuminate\Support\Facades\Auth;

class Sales extends Component
{
    public $sales;
    public $products;
    public $showModal = false;
    public $editingSale = null;
    
    // Pagination properties
    public $perPage = 10;
    public $currentPage = 1;
    
    // Form fields
    public $product_id = '';
    public $quantity = '';
    public $unit_price = '';
    public $sale_date = '';
    
    // Search functionality
    public $productSearch = '';
    public $filteredProducts;
    public $selectedProduct;
    
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
        $this->filteredProducts = collect();
    }

    public function loadSales()
    {
        $this->sales = Sale::with(['product', 'user'])->orderBy('created_at', 'desc')->get();
    }

    public function loadProducts()
    {
        $this->products = Product::with('category')
            ->whereIn('status', ['In Stock', 'Low Stock'])
            ->where('stock_quantity', '>', 0)
            ->orderBy('name')
            ->get();
    }

    public function openModal($saleId = null)
    {
        if ($saleId) {
            $this->editingSale = Sale::find($saleId);
            $this->product_id = $this->editingSale->product_id;
            $this->quantity = $this->editingSale->quantity;
            $this->unit_price = $this->editingSale->unit_price;
            $this->sale_date = $this->editingSale->sale_date;
            $this->selectedProduct = $this->editingSale->product;
            $this->productSearch = '';
            $this->filteredProducts = collect();
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
        $this->productSearch = '';
        $this->filteredProducts = collect();
        $this->selectedProduct = null;
    }

    public function updatedProductId()
    {
        if ($this->product_id) {
            $product = Product::find($this->product_id);
            if ($product) {
                $this->unit_price = $product->price;
                $this->selectedProduct = $product;
                // Reset quantity to 1 when product changes
                $this->quantity = 1;
            }
        }
    }

    public function updatedProductSearch()
    {
        if (strlen($this->productSearch) >= 2) {
            $this->filteredProducts = $this->products->filter(function ($product) {
                return stripos($product->name, $this->productSearch) !== false ||
                       stripos($product->category->name ?? '', $this->productSearch) !== false;
            });
        } else {
            $this->filteredProducts = collect();
        }
    }

    public function selectProduct($productId)
    {
        $this->product_id = $productId;
        $this->productSearch = '';
        $this->filteredProducts = collect();
        
        $product = Product::find($productId);
        if ($product) {
            $this->unit_price = $product->price;
            $this->selectedProduct = $product;
            $this->quantity = 1;
        }
    }

    public function clearProductSelection()
    {
        $this->product_id = '';
        $this->unit_price = '';
        $this->selectedProduct = null;
        $this->quantity = '';
        $this->productSearch = '';
        $this->filteredProducts = collect();
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
        $previousQuantity = $product->stock_quantity;
        $newQuantity = $previousQuantity - $this->quantity;

        if ($this->editingSale) {
            // Restore previous stock for edit
            $product->increment('stock_quantity', $this->editingSale->quantity);
            
            $this->editingSale->update([
                'product_id' => $this->product_id,
                'user_id' => Auth::id(),
                'quantity' => $this->quantity,
                'unit_price' => $this->unit_price,
                'total_amount' => $totalAmount,
                'sale_date' => $this->sale_date,
            ]);
            session()->flash('message', 'Sale updated successfully!');
        } else {
            Sale::create([
                'product_id' => $this->product_id,
                'user_id' => Auth::id(),
                'quantity' => $this->quantity,
                'unit_price' => $this->unit_price,
                'total_amount' => $totalAmount,
                'sale_date' => $this->sale_date,
            ]);
            session()->flash('message', 'Sale recorded successfully!');
        }

        // Update product stock
        $product->decrement('stock_quantity', $this->quantity);
        
        // Update product status based on new stock level
        $this->updateProductStatus($product, $newQuantity);
        
        // Log inventory change
        InventoryLog::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'action' => 'Stock Out',
            'quantity_change' => -$this->quantity,
            'previous_quantity' => $previousQuantity,
            'new_quantity' => $newQuantity,
            'reason' => 'Sale transaction - ' . ($this->editingSale ? 'Updated' : 'New') . ' sale',
        ]);
        
        $this->loadSales();
        $this->loadProducts();
        $this->closeModal();
    }

    public function delete($saleId)
    {
        $sale = Sale::find($saleId);
        $product = $sale->product;
        $previousQuantity = $product->stock_quantity;
        $newQuantity = $previousQuantity + $sale->quantity;
        
        // Restore stock
        $product->increment('stock_quantity', $sale->quantity);
        
        // Update product status based on new stock level
        $this->updateProductStatus($product, $newQuantity);
        
        // Log inventory change
        InventoryLog::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'action' => 'Stock In',
            'quantity_change' => $sale->quantity,
            'previous_quantity' => $previousQuantity,
            'new_quantity' => $newQuantity,
            'reason' => 'Sale deletion - Stock restored',
        ]);
        
        $sale->delete();
        session()->flash('message', 'Sale deleted successfully!');
        $this->loadSales();
        $this->loadProducts();
    }

    private function updateProductStatus($product, $newQuantity)
    {
        if ($newQuantity <= 0) {
            $product->update(['status' => 'Out of Stock']);
        } elseif ($newQuantity <= 10) { // Assuming 10 is the low stock threshold
            $product->update(['status' => 'Low Stock']);
        } else {
            $product->update(['status' => 'In Stock']);
        }
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

    public function getPaginatedSales()
    {
        $allSales = $this->sales;
        $total = $allSales->count();
        
        // Ensure current page is valid
        $lastPage = max(1, ceil($total / $this->perPage));
        if ($this->currentPage > $lastPage) {
            $this->currentPage = 1;
        }
        
        $offset = ($this->currentPage - 1) * $this->perPage;
        $paginatedData = $allSales->slice($offset, $this->perPage);
        
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

    public function render()
    {
        return view('livewire.sales');
    }
}

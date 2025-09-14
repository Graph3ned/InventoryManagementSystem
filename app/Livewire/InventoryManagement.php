<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\InventoryLog;
use Illuminate\Support\Facades\Auth;

class InventoryManagement extends Component
{
    public $products;
    public $categories;
    public $showModal = false;
    public $editingProduct = null;
    
    // Pagination properties
    public $perPage = 10;
    public $currentPage = 1;
    
    // Form fields
    public $name = '';
    public $category_id = '';
    public $price = '';
    public $stock_quantity = '';
    public $description = '';
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'description' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadProducts();
        $this->loadCategories();
    }

    public function loadProducts()
    {
        $this->products = Product::with('category')->get();
    }

    public function getPaginatedProducts()
    {
        $allProducts = $this->products;
        $total = $allProducts->count();
        
        // Ensure current page is valid
        $lastPage = max(1, ceil($total / $this->perPage));
        if ($this->currentPage > $lastPage) {
            $this->currentPage = 1;
        }
        
        $offset = ($this->currentPage - 1) * $this->perPage;
        $paginatedData = $allProducts->slice($offset, $this->perPage);
        
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

    public function loadCategories()
    {
        $this->categories = Category::all();
    }

    public function openModal($productId = null)
    {
        if ($productId) {
            $this->editingProduct = Product::find($productId);
            $this->name = $this->editingProduct->name;
            $this->category_id = $this->editingProduct->category_id;
            $this->price = $this->editingProduct->price;
            $this->stock_quantity = $this->editingProduct->stock_quantity;
            $this->description = $this->editingProduct->description;
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
        $this->editingProduct = null;
        $this->name = '';
        $this->category_id = '';
        $this->price = '';
        $this->stock_quantity = '';
        $this->description = '';
    }

    public function save()
    {
        $this->validate();

        $previousQuantity = $this->editingProduct ? $this->editingProduct->stock_quantity : 0;
        $quantityChange = $this->stock_quantity - $previousQuantity;
        $status = $this->getStatus($this->stock_quantity);

        if ($this->editingProduct) {
            $this->editingProduct->update([
                'name' => $this->name,
                'category_id' => $this->category_id,
                'price' => $this->price,
                'stock_quantity' => $this->stock_quantity,
                'status' => $status,
                'description' => $this->description,
            ]);
            session()->flash('message', 'Product updated successfully!');
        } else {
            Product::create([
                'name' => $this->name,
                'category_id' => $this->category_id,
                'price' => $this->price,
                'stock_quantity' => $this->stock_quantity,
                'status' => $status,
                'description' => $this->description,
            ]);
            session()->flash('message', 'Product added successfully!');
        }

        // Log inventory change if there's a quantity change
        if ($quantityChange != 0) {
            InventoryLog::create([
                'product_id' => $this->editingProduct ? $this->editingProduct->id : Product::where('name', $this->name)->first()->id,
                'user_id' => Auth::id(),
                'action' => $quantityChange > 0 ? 'Stock In' : 'Stock Out',
                'quantity_change' => $quantityChange,
                'previous_quantity' => $previousQuantity,
                'new_quantity' => $this->stock_quantity,
                'reason' => $this->editingProduct ? 'Product update' : 'New product added',
            ]);
        }

        $this->loadProducts();
        $this->closeModal();
    }

    // Product deletion is disabled for data integrity
    // Products cannot be deleted once they have sales records or inventory history

    public function getStatus($stockQuantity)
    {
        if ($stockQuantity == 0) {
            return 'Out of Stock';
        } elseif ($stockQuantity <= 10) {
            return 'Low Stock';
        } else {
            return 'In Stock';
        }
    }

    public function getStatusColor($stockQuantity)
    {
        if ($stockQuantity == 0) {
            return 'text-red-600';
        } elseif ($stockQuantity <= 10) {
            return 'text-yellow-500';
        } else {
            return 'text-green-600';
        }
    }

    public function render()
    {
        return view('livewire.inventory-management');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class InventoryManagement extends Component
{
    public $products;
    public $categories;
    public $showModal = false;
    public $editingProduct = null;
    
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

        if ($this->editingProduct) {
            $this->editingProduct->update([
                'name' => $this->name,
                'category_id' => $this->category_id,
                'price' => $this->price,
                'stock_quantity' => $this->stock_quantity,
                'description' => $this->description,
            ]);
            session()->flash('message', 'Product updated successfully!');
        } else {
            Product::create([
                'name' => $this->name,
                'category_id' => $this->category_id,
                'price' => $this->price,
                'stock_quantity' => $this->stock_quantity,
                'description' => $this->description,
            ]);
            session()->flash('message', 'Product added successfully!');
        }

        $this->loadProducts();
        $this->closeModal();
    }

    public function delete($productId)
    {
        Product::find($productId)->delete();
        session()->flash('message', 'Product deleted successfully!');
        $this->loadProducts();
    }

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

<div class="ml-64">
    <!-- Sales Section -->
    <div class="bg-zinc-100 p-4 sm:p-6 md:p-8 min-h-screen">
        <header class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Sales Management</h2>
            <a href="{{ route('profile') }}" class="flex flex-col items-end space-y-0.5 cursor-pointer hover:bg-gray-100 p-2 rounded">
                <span class="text-zinc-700 font-medium">{{ Auth::user()->name }}</span>
                <span class="text-sm text-gray-500">{{ Auth::user()->email }}</span>
            </a>
        </header>

        <p class="text-gray-700 mb-6">Track and manage your sales transactions</p>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Sales Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-600 font-semibold">Total Sales</p>
                <p class="text-2xl font-bold">₱{{ number_format($this->getTotalSales(), 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-600 font-semibold">Total Items Sold</p>
                <p class="text-2xl font-bold">{{ $this->getTotalQuantity() }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-600 font-semibold">Today's Sales</p>
                <p class="text-2xl font-bold text-green-600">₱{{ number_format($this->getTodaySales(), 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-600 font-semibold">Today's Items</p>
                <p class="text-2xl font-bold text-blue-600">{{ $this->getTodayQuantity() }}</p>
            </div>
        </div>

        <!-- Add Sale Button (Only for Staff) -->
        @if(auth()->user()->role === 'staff')
            <div class="mb-4 flex justify-end">
                <button wire:click="openModal" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Add Sale
                </button>
            </div>
        @endif

        <!-- Sales Table -->
        <div class="overflow-auto bg-white rounded shadow border border-gray-300">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-4 py-2">Product</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $sale->product->name }} ({{ $sale->quantity }}kg)</td>
                            <td class="px-4 py-2">{{ $sale->sale_date->format('Y-m-d') }}</td>
                            <td class="px-4 py-2">₱{{ number_format($sale->total_amount, 2) }}</td>
                            <td class="px-4 py-2">
                                @if($sale->status === 'Completed')
                                    <span class="text-green-600 font-medium">{{ $sale->status }}</span>
                                @elseif($sale->status === 'Pending')
                                    <span class="text-yellow-600 font-medium">{{ $sale->status }}</span>
                                @else
                                    <span class="text-red-600 font-medium">{{ $sale->status }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <button wire:click="openModal({{ $sale->id }})" class="text-blue-600 hover:underline">Edit</button>
                                <button wire:click="delete({{ $sale->id }})" 
                                        wire:confirm="Are you sure you want to delete this sale?" 
                                        class="text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">No sales found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Sale Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ $editingSale ? 'Edit Sale' : 'Add New Sale' }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="save">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Search Product from Inventory</label>
                                <div class="relative">
                                    <input type="text" 
                                           wire:model.live="productSearch" 
                                           placeholder="Type to search products..." 
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 pr-10 focus:outline-none focus:ring-red-500 focus:border-red-500">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                @if($productSearch && $filteredProducts->count() > 0)
                                    <div class="mt-2 max-h-48 overflow-y-auto border border-gray-300 rounded-md bg-white shadow-lg">
                                        @foreach($filteredProducts as $product)
                                            <div wire:click="selectProduct({{ $product->id }})" 
                                                 class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                                        <p class="text-sm text-gray-500">{{ $product->category->name ?? 'No category' }}</p>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="font-semibold text-red-600">₱{{ number_format($product->price, 2) }}</p>
                                                        <p class="text-sm text-gray-500">Stock: {{ $product->stock_quantity }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($productSearch && $filteredProducts->count() == 0)
                                    <div class="mt-2 p-3 text-center text-gray-500 bg-gray-50 rounded-md">
                                        No products found matching "{{ $productSearch }}"
                                    </div>
                                @endif
                                
                                @if($product_id)
                                    <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded-md">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium text-green-800">{{ $selectedProduct->name ?? 'Selected Product' }}</p>
                                                <p class="text-sm text-green-600">Price: ₱{{ number_format($selectedProduct->price ?? 0, 2) }}</p>
                                            </div>
                                            <button type="button" wire:click="clearProductSelection" class="text-red-600 hover:text-red-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                
                                @error('product_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                @if($products->isEmpty())
                                    <p class="text-sm text-red-600 mt-1">No products available in inventory. Add products to inventory first.</p>
                                @endif
                            </div>
                            
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" 
                                       wire:model="quantity" 
                                       min="1" 
                                       class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-red-500 focus:border-red-500">
                                @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                @if($product_id)
                                    @foreach($products as $product)
                                        @if($product->id == $product_id)
                                            <p class="text-sm text-gray-600 mt-1">Available stock: {{ $product->stock_quantity }} {{ $product->category->name ?? 'units' }}</p>
                                            @break
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Sale Date</label>
                                <input type="date" wire:model="sale_date" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-red-500 focus:border-red-500">
                                @error('sale_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                {{ $editingSale ? 'Update Sale' : 'Add Sale' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
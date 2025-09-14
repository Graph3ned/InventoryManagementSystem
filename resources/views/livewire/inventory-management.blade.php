<div class="ml-64">
    <!-- Inventory Section -->
    <div class="bg-zinc-100 p-4 sm:p-6 md:p-8 min-h-screen">
        <header class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Inventory Management</h2>
            <a href="{{ route('profile') }}" class="flex flex-col items-end space-y-0.5 cursor-pointer hover:bg-gray-100 p-2 rounded">
                <span class="text-zinc-700 font-medium">{{ Auth::user()->name }}</span>
                <span class="text-sm text-gray-500">{{ Auth::user()->email }}</span>
            </a>
        </header>

        <p class="text-gray-700 mb-6">Track and manage your product inventory</p>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Inventory Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-600 font-semibold">Total Products</p>
                <p class="text-2xl font-bold">{{ $products->count() }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-600 font-semibold">Total Stock</p>
                <p class="text-2xl font-bold">{{ $products->sum('stock_quantity') }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-600 font-semibold">Low Stock</p>
                <p class="text-2xl font-bold text-yellow-500">{{ $products->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 10)->count() }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-600 font-semibold">Out of Stock</p>
                <p class="text-2xl font-bold text-red-600">{{ $products->where('stock_quantity', 0)->count() }}</p>
            </div>
        </div>

        <!-- Add Product Button -->
        <div class="mb-4 flex justify-end">
            <button wire:click="openModal" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Add Product
            </button>
        </div>

        <!-- Items per page selector -->
        <div class="flex items-center gap-2 mb-4">
            <label class="text-sm text-gray-600">Show:</label>
            <select wire:model.live="perPage" class="text-sm border border-gray-300 rounded px-2 py-1 focus:border-red-500 focus:ring-1 focus:ring-red-500" style="-webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: none;">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <span class="text-sm text-gray-600">per page</span>
        </div>

        <!-- Inventory Table -->
        <div class="overflow-auto bg-white rounded shadow border border-gray-300">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-4 py-2">Product</th>
                        <th class="px-4 py-2">Category</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Stock</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $paginatedData = $this->getPaginatedProducts();
                    @endphp
                    @forelse($paginatedData['data'] as $product)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $product->name }}</td>
                            <td class="px-4 py-2">{{ $product->category->name }}</td>
                            <td class="px-4 py-2">₱{{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-2">{{ $product->stock_quantity }}</td>
                            <td class="px-4 py-2 {{ $this->getStatusColor($product->stock_quantity) }}">
                                {{ $this->getStatus($product->stock_quantity) }}
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <button wire:click="openModal({{ $product->id }})" class="text-blue-600 hover:underline">Edit</button>
                                
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">No products found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Results Count and Pagination -->
        @php
            $paginatedData = $this->getPaginatedProducts();
            $totalApplications = $paginatedData['total'];
            $currentPage = $paginatedData['currentPage'];
            $lastPage = $paginatedData['lastPage'];
            $perPage = $paginatedData['perPage'];
        @endphp
        
        @if($totalApplications > 0)
            <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-sm text-gray-600">
                    Showing {{ (($currentPage - 1) * $perPage) + 1 }} to {{ min($currentPage * $perPage, $totalApplications) }} of {{ $totalApplications }} result(s)
                </div>
                
                <!-- Pagination Controls -->
                @if($lastPage > 1)
                    <div class="flex items-center gap-2">
                        <!-- Pagination buttons -->
                        <div class="flex items-center gap-1">
                            <!-- Previous button -->
                            <button 
                                wire:click="goToPage({{ $currentPage - 1 }})" 
                                @if($currentPage <= 1) disabled @endif
                                class="px-3 py-1 text-sm border border-gray-300 rounded {{ $currentPage == 1 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50' }}"
                            >
                                Previous
                            </button>
                            
                            <!-- Page numbers -->
                            @php
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp
                            
                            @if($start > 1)
                                <button wire:click="goToPage(1)" class="px-3 py-1 text-sm border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50">1</button>
                                @if($start > 2)
                                    <span class="px-2 text-gray-400">...</span>
                                @endif
                            @endif
                            
                            @for($i = $start; $i <= $end; $i++)
                                <button 
                                    wire:click="goToPage({{ $i }})" 
                                    class="px-3 py-1 text-sm border border-gray-300 rounded {{ $i == $currentPage ? 'bg-red-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}"
                                >
                                    {{ $i }}
                                </button>
                            @endfor
                            
                            @if($end < $lastPage)
                                @if($end < $lastPage - 1)
                                    <span class="px-2 text-gray-400">...</span>
                                @endif
                                <button wire:click="goToPage({{ $lastPage }})" class="px-3 py-1 text-sm border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50">{{ $lastPage }}</button>
                            @endif
                            
                            <!-- Next button -->
                            <button 
                                wire:click="goToPage({{ $currentPage + 1 }})" 
                                @if($currentPage >= $lastPage) disabled @endif
                                class="px-3 py-1 text-sm border border-gray-300 rounded {{ $currentPage >= $lastPage ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50' }}"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Add/Edit Product Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ $editingProduct ? 'Edit Product' : 'Add New Product' }}
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
                                <label class="block text-sm font-medium text-gray-700">Product Name</label>
                                <input type="text" wire:model="name" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-red-500 focus:border-red-500">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Category</label>
                                <select wire:model="category_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-red-500 focus:border-red-500">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" wire:model="price" step="0.01" min="0" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-red-500 focus:border-red-500">
                                @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                                <input type="number" wire:model="stock_quantity" min="0" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-red-500 focus:border-red-500">
                                @error('stock_quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                                <textarea wire:model="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                {{ $editingProduct ? 'Update Product' : 'Add Product' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

</div>

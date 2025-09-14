<div class="ml-64">
    <!-- Reports Section -->
    <div class="bg-zinc-100 p-4 sm:p-6 md:p-8 min-h-screen">
        <header class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Sales Reports</h2>
            <a href="{{ route('profile') }}" class="flex flex-col items-end space-y-0.5 cursor-pointer hover:bg-gray-100 p-2 rounded">
                <span class="text-zinc-700 font-medium">{{ Auth::user()->name }}</span>
                <span class="text-sm text-gray-500">{{ Auth::user()->email }}</span>
            </a>
        </header>

        <p class="text-gray-700 mb-6">Analyze your store's performance</p>
        
        

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Filter + Export -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter Period</label>
                    <select wire:model.live="filterPeriod" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="year">This Year</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
                @if($filterPeriod === 'custom')
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input type="date" wire:model.live="startDate" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="date" wire:model.live="endDate" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                    </div>
                @endif
            </div>
            <div class="flex space-x-2">
                <button wire:click="exportReport" 
                        wire:loading.attr="disabled"
                        wire:target="exportReport"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="exportReport">Export Report</span>
                    <span wire:loading wire:target="exportReport">Exporting...</span>
                </button>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div wire:loading class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
            <div class="flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading report data...
            </div>
        </div>

        <!-- Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded shadow p-4 text-center">
                <p class="text-sm text-gray-600">Total Revenue</p>
                <p class="text-2xl font-bold text-zinc-800">₱{{ number_format($this->getTotalRevenue(), 2) }}</p>
            </div>
            <div class="bg-white rounded shadow p-4 text-center">
                <p class="text-sm text-gray-600">Items Sold</p>
                <p class="text-2xl font-bold text-zinc-800">{{ $this->getTotalQuantity() }}</p>
            </div>
            <div class="bg-white rounded shadow p-4 text-center">
                <p class="text-sm text-gray-600">Total Orders</p>
                <p class="text-2xl font-bold text-zinc-800">{{ $this->getTotalOrders() }}</p>
            </div>
            <div class="bg-white rounded shadow p-4 text-center">
                <p class="text-sm text-gray-600">Avg Order Value</p>
                <p class="text-2xl font-bold text-zinc-800">₱{{ number_format($this->getAverageOrderValue(), 2) }}</p>
            </div>
        </div>

        <!-- Top Products and Staff -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Top Products -->
            <div class="bg-white rounded shadow border border-gray-300">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Top Products</h3>
                </div>
                <div class="p-4">
                    @forelse($this->getTopProducts() as $productData)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                            <div>
                                <p class="font-medium text-gray-900">{{ $productData['product']->name }}</p>
                                <p class="text-sm text-gray-500">{{ $productData['quantity'] }} units sold</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-red-600">₱{{ number_format($productData['revenue'], 2) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No product data for the selected period</p>
                    @endforelse
                </div>
            </div>

            <!-- Top Staff -->
            <div class="bg-white rounded shadow border border-gray-300">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Top Staff</h3>
                </div>
                <div class="p-4">
                    @forelse($this->getTopStaff() as $staffData)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                            <div>
                                <p class="font-medium text-gray-900">{{ $staffData['user']->name }}</p>
                                <p class="text-sm text-gray-500">{{ $staffData['sales'] }} transactions</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-green-600">₱{{ number_format($staffData['revenue'], 2) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No staff data for the selected period</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sub-Section -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Daily Sales Summary</h3>
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


        <!-- Sales Table -->
        <div class="overflow-auto bg-white rounded shadow border border-gray-300">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Total Sales</th>
                        <th class="px-4 py-3">Items Sold</th>
                        <th class="px-4 py-3">Transactions</th>
                        <th class="px-4 py-3">Avg. Sale</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-100">
                    @php
                        $paginatedData = $this->getPaginatedDailySales();
                    @endphp
                    @foreach ($paginatedData['data'] as $dailySale)
                        <tr class="bg-white hover:bg-blue-50 transition-colors duration-200">
                            <td class="px-4 py-3 text-gray-700">
                                <div class="text-gray-700 font-medium">{{ \Carbon\Carbon::parse($dailySale['date'])->format('M d, Y') }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <div class="text-gray-700 font-semibold text-green-600">₱{{ number_format($dailySale['revenue'], 2) }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <div class="text-gray-700">{{ $dailySale['quantity'] }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <div class="text-gray-700">{{ $dailySale['transactions'] }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <div class="text-gray-700 font-medium">₱{{ number_format($dailySale['revenue'] / max($dailySale['transactions'], 1), 2) }}</div>
                            </td>
                        </tr>
                    @endforeach
                    @if($paginatedData['total'] == 0)
                        <tr class="bg-white">
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <p class="text-gray-500">No sales data for the selected period</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @if($paginatedData['total'] > 0)
                        <tr class="bg-gray-50 font-semibold border-t-2 border-gray-200">
                            <td class="px-4 py-3 text-gray-800">
                                <div class="text-gray-800 font-bold">Total</div>
                            </td>
                            <td class="px-4 py-3 text-gray-800">
                                <div class="text-gray-800 font-bold text-green-600">₱{{ number_format($this->getTotalRevenue(), 2) }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-800">
                                <div class="text-gray-800 font-bold">{{ $this->getTotalQuantity() }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-800">
                                <div class="text-gray-800 font-bold">{{ $this->getTotalOrders() }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-800">
                                <div class="text-gray-800 font-bold">₱{{ number_format($this->getAverageOrderValue(), 2) }}</div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Results Count and Pagination -->
        @php
            $paginatedData = $this->getPaginatedDailySales();
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

</div>
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
                    <select wire:model="filterPeriod" class="border rounded px-3 py-2 text-sm">
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="year">This Year</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
                @if($filterPeriod === 'custom')
                    <div class="flex space-x-2">
                        <input type="date" wire:model="startDate" class="border rounded px-3 py-2 text-sm">
                        <input type="date" wire:model="endDate" class="border rounded px-3 py-2 text-sm">
                    </div>
                @endif
            </div>
            <button wire:click="exportReport" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Export Report
            </button>
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

        <!-- Sub-Section -->
        <h3 class="text-xl font-semibold mb-4">Sales Summary</h3>

        <!-- Sales Table -->
        <div class="overflow-auto bg-white rounded shadow border border-gray-300">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Total Sales</th>
                        <th class="px-4 py-2">Items Sold</th>
                        <th class="px-4 py-2">Transactions</th>
                        <th class="px-4 py-2">Avg. Sale</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->getDailySales() as $dailySale)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($dailySale['date'])->format('M d, Y') }}</td>
                            <td class="px-4 py-2">₱{{ number_format($dailySale['revenue'], 2) }}</td>
                            <td class="px-4 py-2">{{ $dailySale['quantity'] }}</td>
                            <td class="px-4 py-2">{{ $sales->where('sale_date', $dailySale['date'])->count() }}</td>
                            <td class="px-4 py-2">₱{{ number_format($dailySale['revenue'] / max($sales->where('sale_date', $dailySale['date'])->count(), 1), 2) }}</td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">No sales data for the selected period</td>
                        </tr>
                    @endforelse
                    @if($this->getDailySales()->count() > 0)
                        <tr class="bg-gray-50 font-semibold border-t">
                            <td class="px-4 py-2">Total</td>
                            <td class="px-4 py-2">₱{{ number_format($this->getTotalRevenue(), 2) }}</td>
                            <td class="px-4 py-2">{{ $this->getTotalQuantity() }}</td>
                            <td class="px-4 py-2">{{ $this->getTotalOrders() }}</td>
                            <td class="px-4 py-2">₱{{ number_format($this->getAverageOrderValue(), 2) }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
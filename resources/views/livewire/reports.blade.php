<!-- ✅ Report Section -->
<div id="reportSection" class="bg-zinc-100 p-4 sm:p-6 md:p-8 overflow-auto min-h-screen ml-64">

  <header class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold">Sales Reports</h2>
  </header>

  <p class="text-gray-700 mb-6">Analyze your store's performance</p>

  <!-- Filter + Export -->
  <div class="flex justify-between items-center mb-6">
    <div>
      <select class="border rounded px-3 py-2 text-sm">
        <option>This Week</option>
        <option>Last Week</option>
        <option>This Month</option>
        <option>Custom Range</option>
      </select>
    </div>
  </div>

  <!-- Overview Cards -->
  <div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded shadow p-4 text-center">
      <p class="text-sm text-gray-600">Sales Overview</p>
      <p class="text-2xl font-bold text-zinc-800">₱10,711.50</p>
    </div>
    <div class="bg-white rounded shadow p-4 text-center">
      <p class="text-sm text-gray-600">Product Performance</p>
      <p class="text-2xl font-bold text-zinc-800">191 Items</p>
    </div>
    <div class="bg-white rounded shadow p-4 text-center">
      <p class="text-sm text-gray-600">Inventory Status</p>
      <p class="text-2xl font-bold text-zinc-800">Stable</p>
    </div>
    <div class="bg-white rounded shadow p-4 text-center">
      <p class="text-sm text-gray-600">Daily Sales</p>
      <p class="text-2xl font-bold text-zinc-800">₱2,450.00</p>
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
        <tr class="border-t">
          <td class="px-4 py-2">Today</td>
          <td class="px-4 py-2">₱2,450.00</td>
          <td class="px-4 py-2">42</td>
          <td class="px-4 py-2">15</td>
          <td class="px-4 py-2">₱163.33</td>
        </tr>
        <tr class="border-t">
          <td class="px-4 py-2">Yesterday</td>
          <td class="px-4 py-2">₱2,125.50</td>
          <td class="px-4 py-2">38</td>
          <td class="px-4 py-2">12</td>
          <td class="px-4 py-2">₱177.13</td>
        </tr>
        <tr class="border-t">
          <td class="px-4 py-2">May 15, 2023</td>
          <td class="px-4 py-2">₱1,875.25</td>
          <td class="px-4 py-2">35</td>
          <td class="px-4 py-2">10</td>
          <td class="px-4 py-2">₱187.53</td>
        </tr>
        <tr class="border-t">
          <td class="px-4 py-2">May 14, 2023</td>
          <td class="px-4 py-2">₱2,310.75</td>
          <td class="px-4 py-2">40</td>
          <td class="px-4 py-2">14</td>
          <td class="px-4 py-2">₱165.05</td>
        </tr>
        <tr class="border-t">
          <td class="px-4 py-2">May 13, 2023</td>
          <td class="px-4 py-2">₱1,950.00</td>
          <td class="px-4 py-2">36</td>
          <td class="px-4 py-2">11</td>
          <td class="px-4 py-2">₱177.27</td>
        </tr>
        <tr class="bg-gray-50 font-semibold border-t">
          <td class="px-4 py-2">Weekly Total</td>
          <td class="px-4 py-2">₱10,711.50</td>
          <td class="px-4 py-2">191</td>
          <td class="px-4 py-2">62</td>
          <td class="px-4 py-2">₱172.77</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="ml-64">
    <!-- Dashboard Section -->
    <main id="dashboardMain" class="bg-zinc-100 p-4 sm:p-6 md:p-8 min-h-screen">
        <header class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Dashboard</h2>
            <div class="flex flex-col items-end space-y-0.5">
                <span class="text-zinc-700 font-medium">{{ Auth::user()->name }}</span>
                <span class="text-sm text-gray-500">admin</span>
            </div>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-lg shadow flex items-center space-x-4">
                <svg class="w-10 h-10 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                </svg>
                <div>
                    <p class="text-gray-600 font-semibold">Total Products</p>
                    <p class="text-2xl font-bold">248</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow flex items-center space-x-4">
                <svg class="w-10 h-10 text-yellow-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-gray-600 font-semibold">Low Stock This Month</p>
                    <p class="text-2xl font-bold">12</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow flex items-center space-x-4">
                <svg class="w-10 h-10 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                </svg>
                <div>
                    <p class="text-gray-600 text-sm sm:text-base font-semibold">Today's Sales</p>
                    <p class="text-xl sm:text-2xl font-bold">$1,248</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow flex items-center space-x-4">
                <svg class="w-10 h-10 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-gray-600 font-semibold">Best-Seller Product This Month</p>
                    <p class="text-2xl font-bold">Tomatoes</p>
                </div>
            </div>
        </div>

        <!-- Recent Sales -->
        <div class="mt-6">
            <h3 class="text-xl font-semibold mb-4">Recent Sales</h3>
            <div class="flex justify-start mb-4"></div>
            <table class="min-w-full bg-white rounded shadow border border-zinc-300">
                <thead>
                    <tr>
                        <th class="border px-4 py-2 text-left">Product</th>
                        <th class="border px-4 py-2 text-left">Date</th>
                        <th class="border px-4 py-2 text-left">Amount</th>
                        <th class="border px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border px-4 py-2">Fresh Tomatoes (5kg)</td>
                        <td class="border px-4 py-2">Today, 10:45 AM</td>
                        <td class="border px-4 py-2">$25.99</td>
                        <td class="border px-4 py-2">In Stock</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2">Organic Carrots (3kg)</td>
                        <td class="border px-4 py-2">Today, 9:20 AM</td>
                        <td class="border px-4 py-2">$19.50</td>
                        <td class="border px-4 py-2">In Stock</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2">Green Lettuce (2kg)</td>
                        <td class="border px-4 py-2">Yesterday, 4:15 PM</td>
                        <td class="border px-4 py-2">$15.00</td>
                        <td class="border px-4 py-2">In Stock</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2">Red Onions (4kg)</td>
                        <td class="border px-4 py-2">Yesterday, 2:30 PM</td>
                        <td class="border px-4 py-2">$18.75</td>
                        <td class="border px-4 py-2">In Stock</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Low Stock Alerts -->
        <div class="mt-6">
            <h3 class="text-xl font-semibold">Low Stock Alerts</h3>
            <ul class="bg-white mt-2 rounded p-4 shadow border border-zinc-300 space-y-2">
                <li class="flex items-center space-x-3">
                    <span class="text-red-600 font-semibold">Tomatoes</span>
                    <span class="text-sm text-gray-600">- Only 3kg left</span>
                </li>
                <li class="flex items-center space-x-3">
                    <span class="text-red-600 font-semibold">Green Lettuce</span>
                    <span class="text-sm text-gray-600">- Only 5kg left</span>
                </li>
                <li class="flex items-center space-x-3">
                    <span class="text-red-600 font-semibold">Red Onions</span>
                    <span class="text-sm text-gray-600">- Only 2kg left</span>
                </li>
            </ul>
        </div>
    </main>

    

    <!-- Inventory Section (initially hidden) -->
    <div id="inventorySection" class="hidden bg-zinc-100 p-4 sm:p-6 md:p-8 overflow-auto min-h-screen">
        <header class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Inventory Management</h2>
        </header>

        <p class="text-gray-700 mb-6">Track and manage your product inventory</p>

        <!-- Inventory Stats -->
        <div class="grid grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-600 font-semibold">Total Products</p>
                <p class="text-2xl font-bold">51</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-600 font-semibold">Total Stock</p>
                <p class="text-2xl font-bold">840</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-600 font-semibold">Low Stock</p>
                <p class="text-2xl font-bold text-yellow-500">8</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-gray-600 font-semibold">Out of Stock</p>
                <p class="text-2xl font-bold text-red-600">3</p>
            </div>
        </div>

        <!-- Add Product Form -->
        <form id="inventoryForm" class="grid grid-cols-5 gap-4 mb-6" onsubmit="addInventoryProduct(event)">
            <input type="text" id="invName" placeholder="Product" required class="border p-2 rounded col-span-1" />
            <input type="text" id="invCategory" placeholder="Category" required class="border p-2 rounded col-span-1" />
            <input type="number" id="invPrice" placeholder="Price" required step="0.01" class="border p-2 rounded col-span-1" />
            <input type="number" id="invStock" placeholder="Stock" required class="border p-2 rounded col-span-1" />
            <select id="invStatus" required class="border p-2 rounded col-span-1">
                <option>In Stock</option>
                <option>Low Stock</option>
                <option>Out of Stock</option>
            </select>
            <div class="col-span-5 text-right">
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Add Product</button>
            </div>
        </form>

        <!-- Inventory Table -->
        <div class="overflow-auto bg-white rounded shadow border border-gray-300">
            <table class="min-w-full text-sm text-left" id="inventoryTable">
                <thead class="bg-gray-100 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-4 py-2">Product</th>
                        <th class="px-4 py-2">Category</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Stock</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic rows go here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Other sections (Reports, Users, Backup, Settings) would go here with similar structure -->
</div>

<script>
// Navigation functionality
const salesLink = document.getElementById('salesLink');
const inventoryLink = document.getElementById('inventoryLink');
const reportLink = document.getElementById('reportLink');
const settingsLink = document.getElementById('settingsLink');
const backupLink = document.getElementById('backupLink');
const userLink = document.getElementById('userLink');

const dashboardMain = document.getElementById('dashboardMain');
const salesSection = document.getElementById('salesSection');
const inventorySection = document.getElementById('inventorySection');

function hideAllSections() {
    dashboardMain.classList.add('hidden');
    salesSection.classList.add('hidden');
    inventorySection.classList.add('hidden');
}

salesLink?.addEventListener('click', (e) => {
    e.preventDefault();
    hideAllSections();
    salesSection.classList.remove('hidden');
});

inventoryLink?.addEventListener('click', (e) => {
    e.preventDefault();
    hideAllSections();
    inventorySection.classList.remove('hidden');
});

// Sales functions
function addProduct(event) {
    event.preventDefault();
    const product = document.getElementById('product').value;
    const date = document.getElementById('date').value;
    const amount = parseFloat(document.getElementById('amount').value).toFixed(2);
    const status = document.getElementById('status').value;

    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="border px-4 py-2">${product}</td>
        <td class="border px-4 py-2">${date}</td>
        <td class="border px-4 py-2">$${amount}</td>
        <td class="border px-4 py-2">${status}</td>
        <td class="border px-4 py-2 space-x-2">
            <button class="text-blue-600 hover:underline editBtn">Edit</button>
            <button class="text-red-600 hover:underline deleteBtn">Delete</button>
        </td>
    `;

    document.getElementById('salesTable').insertBefore(newRow, document.getElementById('salesTable').lastElementChild);
    document.getElementById('addProductForm').reset();
}

// Inventory functions
function addInventoryProduct(event) {
    event.preventDefault();
    const name = document.getElementById('invName').value.trim();
    const category = document.getElementById('invCategory').value.trim();
    const price = parseFloat(document.getElementById('invPrice').value).toFixed(2);
    const stock = parseInt(document.getElementById('invStock').value);
    const status = document.getElementById('invStatus').value;

    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="px-4 py-2">${name}</td>
        <td class="px-4 py-2">${category}</td>
        <td class="px-4 py-2">₱${price}</td>
        <td class="px-4 py-2">${stock}</td>
        <td class="px-4 py-2">${status}</td>
        <td class="px-4 py-2 space-x-2">
            <button class="text-blue-600 hover:underline editBtn">Edit</button>
            <button class="text-red-600 hover:underline deleteBtn">Delete</button>
        </td>
    `;
    document.querySelector('#inventoryTable tbody').appendChild(newRow);
    document.getElementById('inventoryForm').reset();
}
</script>

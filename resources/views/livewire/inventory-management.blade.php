<div class="ml-64">
    <!-- Inventory Section -->
    <div class="bg-zinc-100 p-4 sm:p-6 md:p-8 min-h-screen">
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
</div>

<!-- <script>
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
    attachInventoryRowHandlers(newRow);
}

function attachInventoryRowHandlers(row) {
    row.querySelector('.deleteBtn').onclick = () => row.remove();

    row.querySelector('.editBtn').onclick = () => {
        const cells = row.querySelectorAll('td');
        const name = cells[0].textContent;
        const category = cells[1].textContent;
        const price = cells[2].textContent.replace('₱', '');
        const stock = cells[3].textContent;
        const status = cells[4].textContent;

        row.innerHTML = `
            <td><input class="border p-1 w-full" value="${name}" /></td>
            <td><input class="border p-1 w-full" value="${category}" /></td>
            <td><input type="number" step="0.01" class="border p-1 w-full" value="${price}" /></td>
            <td><input type="number" class="border p-1 w-full" value="${stock}" /></td>
            <td>
                <select class="border p-1 w-full">
                    <option ${status === 'In Stock' ? 'selected' : ''}>In Stock</option>
                    <option ${status === 'Low Stock' ? 'selected' : ''}>Low Stock</option>
                    <option ${status === 'Out of Stock' ? 'selected' : ''}>Out of Stock</option>
                </select>
            </td>
            <td class="space-x-2">
                <button class="text-green-600 hover:underline saveBtn">Save</button>
                <button class="text-gray-600 hover:underline cancelBtn">Cancel</button>
            </td>
        `;

        const saveBtn = row.querySelector('.saveBtn');
        const cancelBtn = row.querySelector('.cancelBtn');

        saveBtn.onclick = () => {
            const inputs = row.querySelectorAll('input, select');
            const updatedName = inputs[0].value;
            const updatedCategory = inputs[1].value;
            const updatedPrice = parseFloat(inputs[2].value).toFixed(2);
            const updatedStock = inputs[3].value;
            const updatedStatus = inputs[4].value;

            row.innerHTML = `
                <td class="px-4 py-2">${updatedName}</td>
                <td class="px-4 py-2">${updatedCategory}</td>
                <td class="px-4 py-2">₱${updatedPrice}</td>
                <td class="px-4 py-2">${updatedStock}</td>
                <td class="px-4 py-2">${updatedStatus}</td>
                <td class="px-4 py-2 space-x-2">
                    <button class="text-blue-600 hover:underline editBtn">Edit</button>
                    <button class="text-red-600 hover:underline deleteBtn">Delete</button>
                </td>
            `;
            attachInventoryRowHandlers(row);
        };

        cancelBtn.onclick = () => {
            row.innerHTML = `
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
            attachInventoryRowHandlers(row);
        };
    };
}
</script> -->

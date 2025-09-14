<!-- Sales Section (initially hidden) -->
<div id="salesSection" class="bg-zinc-100 p-4 sm:p-6 md:p-8 overflow-auto min-h-screen ml-64">
        <header class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Sales</h2>
        </header>

        <!-- Add Product Form -->
        <form id="addProductForm" class="mb-6 space-y-4 max-w-xl">
            <div class="grid grid-cols-4 gap-4 items-end">
                <div>
                    <label for="product" class="block mb-1 font-semibold">Product Name</label>
                    <input
                        id="product"
                        name="product"
                        type="text"
                        class="border border-gray-300 rounded p-2 w-full"
                        required
                        placeholder="Product Name"
                    />
                </div>
                <div>
                    <label for="date" class="block mb-1 font-semibold">Date</label>
                    <input
                        id="date"
                        name="date"
                        type="date"
                        class="border border-gray-300 rounded p-2 w-full"
                        required
                    />
                </div>
                <div>
                    <label for="amount" class="block mb-1 font-semibold">Amount</label>
                    <input
                        id="amount"
                        name="amount"
                        type="number"
                        step="0.01"
                        min="0"
                        class="border border-gray-300 rounded p-2 w-full"
                        required
                        placeholder="Amount"
                    />
                </div>
                <div>
                    <label for="status" class="block mb-1 font-semibold">Status</label>
                    <select
                        id="status"
                        name="status"
                        class="border border-gray-300 rounded p-2 w-full"
                        required
                    >
                        <option value="In Stock">In Stock</option>
                        <option value="Out of Stock">Out of Stock</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
                <div>
                    <button
                        type="submit"
                        class="bg-red-600 text-white rounded px-4 py-2 hover:bg-red-700"
                    >
                        Add Product
                    </button>
                </div>
            </div>
        </form>

        <!-- Sales Table -->
        <table
            id="salesTable"
            class="min-w-full rounded shadow border border-zinc-300"
        >
            <thead>
                <tr>
                    <th class="border px-4 py-2 text-left">Product</th>
                    <th class="border px-4 py-2 text-left">Date</th>
                    <th class="border px-4 py-2 text-left">Amount</th>
                    <th class="border px-4 py-2 text-left">Status</th>
                    <th class="border px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-4 py-2">Fresh Tomatoes (5kg)</td>
                    <td class="border px-4 py-2">2025-05-19</td>
                    <td class="border px-4 py-2">$25.99</td>
                    <td class="border px-4 py-2">In Stock</td>
                    <td class="border px-4 py-2 space-x-2">
                        <button class="text-blue-600 hover:underline editBtn">Edit</button>
                        <button class="text-red-600 hover:underline deleteBtn">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Organic Carrots (3kg)</td>
                    <td class="border px-4 py-2">2025-05-19</td>
                    <td class="border px-4 py-2">$19.50</td>
                    <td class="border px-4 py-2">In Stock</td>
                    <td class="border px-4 py-2 space-x-2">
                        <button class="text-blue-600 hover:underline editBtn">Edit</button>
                        <button class="text-red-600 hover:underline deleteBtn">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
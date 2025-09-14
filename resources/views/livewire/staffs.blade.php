<!-- ✅ User Section -->
<div id="userSection" class="bg-zinc-100 p-4 sm:p-6 md:p-8 overflow-auto relative ml-64">

  <header class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold">User Management</h2>
  </header>

  <p class="text-gray-700 mb-6">Manage your store users and staff</p>

  <div class="mb-4 text-right">
    <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Add User</button>
  </div>

  <!-- User Table -->
  <div class="overflow-auto bg-white rounded shadow border border-gray-300">
    <table class="min-w-full text-sm text-left" id="userTable">
      <thead class="bg-gray-100 text-gray-700 font-semibold">
        <tr>
          <th class="px-4 py-2">Full Name</th>
          <th class="px-4 py-2">Email</th>
          <th class="px-4 py-2">Status</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-t">
          <td class="px-4 py-2">Charl Casido</td>
          <td class="px-4 py-2">charl@tindahan.ph</td>
          <td class="px-4 py-2 text-green-600 font-medium">Active</td>
          <td class="px-4 py-2 space-x-2">
            <button class="text-blue-600 hover:underline editUserBtn">Edit</button>
            <button class="text-red-600 hover:underline deleteUserBtn">Delete</button>
          </td>
        </tr>
        <tr class="border-t">
          <td class="px-4 py-2">Josiah</td>
          <td class="px-4 py-2">josiah@tindahan.ph</td>
          <td class="px-4 py-2 text-green-600 font-medium">Active</td>
          <td class="px-4 py-2 space-x-2">
            <button class="text-blue-600 hover:underline editUserBtn">Edit</button>
            <button class="text-red-600 hover:underline deleteUserBtn">Delete</button>
          </td>
        </tr>
        <tr class="border-t">
          <td class="px-4 py-2">Edd</td>
          <td class="px-4 py-2">edd@tindahan.ph</td>
          <td class="px-4 py-2 text-green-600 font-medium">Active</td>
          <td class="px-4 py-2 space-x-2">
            <button class="text-blue-600 hover:underline editUserBtn">Edit</button>
            <button class="text-red-600 hover:underline deleteUserBtn">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Edit User Modal -->
  <div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-30 hidden justify-center items-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-lg">
      <h3 class="text-xl font-semibold mb-4">Edit User</h3>
      <form id="editUserForm" class="space-y-4" onsubmit="editUser(event)">
        <div>
          <label class="block text-sm font-medium mb-1">Full Name</label>
          <input id="editFullName" type="text" class="border rounded w-full px-3 py-2" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Email</label>
          <input id="editEmail" type="email" class="border rounded w-full px-3 py-2" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Password</label>
          <input id="editPassword" type="password" class="border rounded w-full px-3 py-2" />
        </div>
        <div class="flex justify-end space-x-3 pt-4">
          <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded border text-gray-600 hover:bg-gray-100">Cancel</button>
          <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
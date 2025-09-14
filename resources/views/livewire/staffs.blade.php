<div class="ml-64">
    <!-- Staff Management Section -->
    <div class="bg-zinc-100 p-4 sm:p-6 md:p-8 min-h-screen">
        <header class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Staff Management</h2>
            <a href="{{ route('profile') }}" class="flex flex-col items-end space-y-0.5 cursor-pointer hover:bg-gray-100 p-2 rounded">
                <span class="text-zinc-700 font-medium">{{ Auth::user()->name }}</span>
                <span class="text-sm text-gray-500">{{ Auth::user()->email }}</span>
            </a>
        </header>

        <p class="text-gray-700 mb-6">Manage your store users and staff</p>

        <div class="mb-4 text-right">
            <button wire:click="openModal" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Add Staff</button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Staff Table -->
        <div class="overflow-auto bg-white rounded shadow border border-gray-300">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-4 py-2">Full Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">
                                <span class="font-medium {{ $user->status === 'active' ? 'text-green-600' : 'text-yellow-500' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <button wire:click="openModal({{ $user->id }})" class="text-blue-600 hover:underline">Edit</button>
                                <button wire:click="delete({{ $user->id }})" 
                                        wire:confirm="Are you sure you want to delete this staff member?"
                                        class="text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">No staff members found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Staff Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
                <h3 class="text-xl font-semibold mb-4">
                    {{ $editingUser ? 'Edit Staff' : 'Add New Staff' }}
                </h3>
                
                <form wire:submit.prevent="save">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Full Name</label>
                            <input type="text" wire:model="name" 
                                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                                   placeholder="Enter full name">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-1">Email</label>
                            <input type="email" wire:model="email" 
                                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                                   placeholder="Enter email address">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-1">Password</label>
                            <input type="password" wire:model="password" 
                                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                                   placeholder="{{ $editingUser ? 'Leave blank to keep current password' : 'Enter password' }}">
                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-1">Status</label>
                            <select wire:model="status" 
                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" wire:click="closeModal" 
                                class="px-4 py-2 rounded border text-gray-600 hover:bg-gray-100">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
                            {{ $editingUser ? 'Update Staff' : 'Add Staff' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>

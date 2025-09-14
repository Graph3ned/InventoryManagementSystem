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

        <p class="text-gray-700 mb-6">Manage your store users and staff. Staff accounts cannot be deleted to preserve sales data integrity.</p>

        

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Data Integrity Notice -->
        <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-blue-800">Data Integrity Protection</h3>
                    <p class="text-sm text-blue-700 mt-1">Staff accounts cannot be deleted because they are linked to sales records. Use the activate/deactivate options to control access while preserving historical data.</p>
                </div>
            </div>
        </div>
        <div class="mb-4 text-right">
            <button wire:click="openModal" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Add Staff</button>
        </div>

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
                                @if($user->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <button wire:click="openModal({{ $user->id }})" class="text-blue-600 hover:underline">Edit</button>
                                @if($user->status === 'active')
                                    <button wire:click="deactivateUser({{ $user->id }})" 
                                            wire:confirm="Are you sure you want to deactivate this staff member? They will not be able to log in after this change."
                                            class="text-yellow-600 hover:underline">Deactivate</button>
                                @else
                                    <button wire:click="activateUser({{ $user->id }})" 
                                            class="text-green-600 hover:underline">Activate</button>
                                @endif
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

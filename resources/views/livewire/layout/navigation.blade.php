<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<!-- Sidebar Navigation -->
<aside class="w-64 bg-red-600 text-white p-6 flex flex-col justify-between fixed h-full">
    <div>
        <h1 class="text-2xl font-bold flex items-center space-x-2">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
            </svg>
            <span>Inventory SYSTEM</span>
        </h1>
        <nav class="mt-10">
            <ul>
                @if(auth()->user()->role === 'admin')
                    <li class="relative py-3 pl-2 flex items-center space-x-2 {{ request()->routeIs('dashboard') ? 'bg-red-700 rounded-lg' : '' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        <a href="{{ route('dashboard') }}" wire:navigate class="hover:text-zinc-200 font-semibold {{ request()->routeIs('dashboard') ? 'text-zinc-200' : '' }}">
                            Dashboard
                        </a>
                    </li>
                @endif
                <li class="relative py-3 pl-2 flex items-center space-x-2 {{ request()->routeIs('InventoryManagement') ? 'bg-red-700 rounded-lg' : '' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                    <a href="{{ route('InventoryManagement') }}" wire:navigate class="hover:text-zinc-200 font-semibold {{ request()->routeIs('InventoryManagement') ? 'text-zinc-200' : '' }}">
                        Inventory
                    </a>
                </li>
                
                <li class="relative py-3 pl-2 flex items-center space-x-2 {{ request()->routeIs('Sales') ? 'bg-red-700 rounded-lg' : '' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2L3 7v11a1 1 0 001 1h12a1 1 0 001-1V7l-7-5zM8 15a1 1 0 01-2 0v-3a1 1 0 112 0v3zm4 0a1 1 0 01-2 0v-3a1 1 0 112 0v3z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('Sales') }}" wire:navigate class="hover:text-zinc-200 font-semibold {{ request()->routeIs('Sales') ? 'text-zinc-200' : '' }}">
                        Sales
                    </a>
                </li>
                
                @if(auth()->user()->role === 'admin')
                    <li class="relative py-3 pl-2 flex items-center space-x-2 {{ request()->routeIs('Reports') ? 'bg-red-700 rounded-lg' : '' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                        </svg>
                        <a href="{{ route('Reports') }}" wire:navigate class="hover:text-zinc-200 font-semibold {{ request()->routeIs('Reports') ? 'text-zinc-200' : '' }}">
                            Reports
                        </a>
                    </li>
                    <li class="relative py-3 pl-2 flex items-center space-x-2 {{ request()->routeIs('Staffs') ? 'bg-red-700 rounded-lg' : '' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('Staffs') }}" wire:navigate class="hover:text-zinc-200 font-semibold {{ request()->routeIs('Staffs') ? 'text-zinc-200' : '' }}">
                            Staffs
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    <div>
        <button wire:click="logout" class="flex items-center space-x-2 hover:text-zinc-200 w-full text-left">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
            </svg>
            <span>Logout</span>
                </button>
    </div>
</aside>

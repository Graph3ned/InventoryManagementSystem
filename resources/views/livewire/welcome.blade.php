<div class="min-h-screen bg-gray-50">
    <div class="container">
        <header>
            <h1 class="logo">INVENTORY SYSTEM</h1>
        </header>

        <main class="role-selection">
            <h2 class="text-2xl font-bold mb-8">Choose Your Role</h2>
            <div class="cards">
                <!-- Administrator -->
                <button wire:click="redirectToLogin('admin')" class="card admin">
                    <div class="icon">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3>Administrator</h3>
                    <p>Full system control and management</p>
                    <div class="hover-info">
                        <ul>
                            <li>Manage users and permissions</li>
                            <li>View system analytics</li>
                            <li>Configure system settings</li>
                        </ul>
                        <span class="enter-text">Click to enter →</span>
                    </div>
                </button>

                <!-- Staff / User -->
                <button wire:click="redirectToLogin('staff')" class="card staff">
                    <div class="icon">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3>Staff </h3>
                    <p>Inventory & Sale management</p>
                    <div class="hover-info">
                        <ul>
                            <li>Manage inventory items</li>
                            <li>Manage Sale Product</li>
                            <li>Generate reports</li>
                        </ul>
                        <span class="enter-text">Click to enter →</span>
                    </div>
                </button>
            </div>
        </main>

        <footer>
            <p>© {{ date('Y') }} Inventory Management System. All rights reserved.</p>
        </footer>
    </div>

    <div class="background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
</div>
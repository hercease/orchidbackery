
        <div id="sidebar" class="sidebar w-64 bg-orchid-dark text-white flex flex-col h-full">
            <!-- Logo and Close Button -->
            <div class="p-6 border-b border-orchid-gold/30 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-[#FFFFFF] flex items-center justify-center">
                        <img src="public/logo/logo.png" alt="brand logo" class="img-fluid">
                    </div>
                    <div>
                        <h1 class="font-bold text-lg">Orchid Bakery</h1>
                        <p class="text-xs text-gray-300">Admin Portal</p>
                    </div>
                </div>
                <!-- Close button for mobile -->
                <button id="closeSidebar" class="md:hidden text-xl" onclick="closeSidebar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Admin Info -->
            <div class="p-4 border-b border-orchid-gold/30">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                        <i class="fas fa-user text-orchid-dark"></i>
                    </div>
                    <div>
                        <p class="font-medium">Admin User</p>
                        <?php if($fetchuserdetails['isAdmin'] > 0): ?><p class="text-xs text-gray-300">Super Administrator</p><?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="dashboard" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg bg-orchid-gold/10">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="pt-4">
                    <p class="text-xs uppercase text-gray-400 tracking-wider mb-2">User Management</p>
                    <a href="manage_users" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-users w-5"></i>
                        <span>Manage Users</span>
                    </a>
                </div>
                
                <div class="pt-2">
                    <p class="text-xs uppercase text-gray-400 tracking-wider mb-2">Partner Management</p>
                    <a href="manage_partners" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-handshake w-5"></i>
                        <span>Manage Partners</span>
                    </a>
                </div>
                
                <div class="pt-2">
                    <p class="text-xs uppercase text-gray-400 tracking-wider mb-2">Points & Rewards</p>
                    <a href="point_award" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-coins w-5"></i>
                        <span>Point Award</span>
                    </a>
                    <a href="point_configuration" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-coins w-5"></i>
                        <span>Points Configuration</span>
                    </a>
                </div>
                
                <div class="pt-2">
                    <p class="text-xs uppercase text-gray-400 tracking-wider mb-2">Financial Management</p>
                    <a href="withdrawal_requests" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-money-check-alt w-5"></i>
                        <span>Withdrawal Requests</span>
                    </a>
                </div>
                
                <div class="pt-2">
                    <p class="text-xs uppercase text-gray-400 tracking-wider mb-2">Reporting</p>
                    <a href="activity_logs" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-history w-5"></i>
                        <span>Transaction Logs</span>
                    </a>
                </div>
                
                <div class="pt-2">
                    <p class="text-xs uppercase text-gray-400 tracking-wider mb-2">System</p>
                    <a href="control_access" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-shield-alt w-5"></i>
                        <span>Access Control</span>
                    </a>
                </div>
            </nav>
            
            <!-- Logout -->
            <div class="p-4 border-t border-orchid-gold/30">
                <a href="logout" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-900/30">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $adminMetaTags; ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'orchid-dark': '#013220',
                        'orchid-gold': '#CC9933',
                        'orchid-light': '#f8f6f2'
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-link:hover {
            background-color: rgba(204, 153, 51, 0.1);
        }
        .stat-card:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease;
        }
        .btn-primary {
            background-color: #013220;
            color: white;
        }
        .btn-primary:hover {
            background-color: #011a16;
        }
        .btn-secondary {
            background-color: #CC9933;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #b3862e;
        }
        
        /* Mobile overlay */
        #sidebarOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }
        
        /* Show overlay when sidebar is open on mobile */
        #sidebarOverlay.active {
            display: block;
        }
        
        /* Sidebar styles */
        @media (max-width: 767px) {
            .sidebar {
                position: fixed;
                left: -100%;
                top: 0;
                bottom: 0;
                width: 280px;
                transition: left 0.3s ease-in-out;
                z-index: 50;
            }
            
            .sidebar.open {
                left: 0;
            }
            
            .main-content {
                width: 100%;
                margin-left: 0;
            }
        }
        
        @media (min-width: 768px) {
            .sidebar {
                position: relative;
                left: 0;
            }
            
            .main-content {
                width: calc(100% - 16rem);
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" onclick="closeSidebar()"></div>
    
    <div class="flex h-screen">
        <!-- Sideba -->
        <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>
        <!-- Main Content Area -->
        <div class="main-content flex-1 flex flex-col overflow-hidden">
            <!-- Header with Mobile Menu Button -->
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <!-- Mobile Menu Button -->
                    <button id="openSidebar" class="md:hidden text-xl text-gray-700" onclick="openSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h2 id="dashboardTitle" class="text-xl font-semibold text-gray-800">Admin Dashboard</h2>
                    </div>
                </div>
            </header>
            
            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Total Users</p>
                                <p class="text-3xl font-bold mt-2"><?php echo $userStats['total']; ?></p>
                                <p class="text-xs <?php echo $userStats['is_increase'] ? 'text-green-600' : 'text-red-600'; ?> mt-1">
                                    <i class="fas fa-arrow-<?php echo $userStats['is_increase'] ? 'up' : 'down'; ?> mr-1"></i>
                                    <?php echo $userStats['text']; ?>
                                </p>
                            </div>
                            <div class="p-3 rounded-full bg-orchid-dark/10">
                                <i class="fas fa-users text-orchid-dark text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Active Partners</p>
                                <p class="text-3xl font-bold mt-2"><?php echo $partnerStats['total']; ?></p>
                                <p class="text-xs text-green-600 mt-1"><i class="fas fa-arrow-up mr-1"></i><?php echo $partnerStats['text']; ?></p>
                            </div>
                            <div class="p-3 rounded-full bg-orchid-gold/10">
                                <i class="fas fa-handshake text-orchid-gold text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Points Redeemed</p>
                                <p class="text-3xl font-bold mt-2"><?php echo $currentPointStats; ?></p>
                                <p class="text-xs <?php echo $pointsStats['is_increase'] ? 'text-green-600' : 'text-red-600'; ?> mt-1">
                                    <i class="fas fa-arrow-<?php echo $pointsStats['is_increase'] ? 'up' : 'down'; ?> mr-1"></i>
                                    <?php echo $pointsStats['text']; ?>
                                </p>
                            </div>
                            <div class="p-3 rounded-full bg-orchid-dark/10">
                                <i class="fas fa-coins text-orchid-dark text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Pending Withdrawals</p>
                                <p class="text-3xl font-bold mt-2"><?php echo $withdrawalStats['total']; ?></p>
                                <p class="text-xs text-orange-600 mt-1">
                                    <?php echo $withdrawalStats['text']; ?>
                                </p>
                            </div>
                            <div class="p-3 rounded-full bg-orchid-gold/10">
                                <i class="fas fa-money-check-alt text-orchid-gold text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activity & Quick Actions -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Recent Users -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow overflow-hidden">
                            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                                <h3 class="font-bold text-gray-800">Recent User Registrations</h3>
                                <a href="#" class="text-sm text-orchid-dark font-medium">View All</a>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="text-left p-4 text-sm font-medium text-gray-600">User</th>
                                            <th class="text-left p-4 text-sm font-medium text-gray-600">Points</th>
                                            <th class="text-left p-4 text-sm font-medium text-gray-600">Status</th>
                                            <th class="text-left p-4 text-sm font-medium text-gray-600">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                                            <td class="p-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                                        <i class="fas fa-user text-gray-500"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium">Alex Johnson</p>
                                                        <p class="text-xs text-gray-500">alex@example.com</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <span class="font-bold">1,250</span>
                                            </td>
                                            <td class="p-4">
                                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Active</span>
                                            </td>
                                            <td class="p-4">
                                                <button class="text-sm text-orchid-dark font-medium">Manage</button>
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                                            <td class="p-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                                        <i class="fas fa-user text-gray-500"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium">Maria Garcia</p>
                                                        <p class="text-xs text-gray-500">maria@example.com</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <span class="font-bold">850</span>
                                            </td>
                                            <td class="p-4">
                                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Active</span>
                                            </td>
                                            <td class="p-4">
                                                <button class="text-sm text-orchid-dark font-medium">Manage</button>
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                                            <td class="p-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                                        <i class="fas fa-user text-gray-500"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium">David Chen</p>
                                                        <p class="text-xs text-gray-500">david@example.com</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <span class="font-bold">2,150</span>
                                            </td>
                                            <td class="p-4">
                                                <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">Pending</span>
                                            </td>
                                            <td class="p-4">
                                                <button class="text-sm text-orchid-dark font-medium">Manage</button>
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="p-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                                        <i class="fas fa-user text-gray-500"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium">Sarah Williams</p>
                                                        <p class="text-xs text-gray-500">sarah@example.com</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <span class="font-bold">3,450</span>
                                            </td>
                                            <td class="p-4">
                                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Active</span>
                                            </td>
                                            <td class="p-4">
                                                <button class="text-sm text-orchid-dark font-medium">Manage</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div>
                        <div class="bg-white rounded-xl shadow overflow-hidden mb-6">
                            <div class="p-5 border-b border-gray-100">
                                <h3 class="font-bold text-gray-800">Quick Actions</h3>
                            </div>
                            <div class="p-5 space-y-4">
                                <a href="#" class="quick-action flex items-center justify-between p-3 rounded-lg border border-orchid-dark/20 hover:bg-orchid-dark/5" onclick="handleQuickAction(this)">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-orchid-dark/10 flex items-center justify-center mr-3">
                                            <i class="fas fa-user-plus text-orchid-dark"></i>
                                        </div>
                                        <span class="font-medium">Register New User</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </a>
                                
                                <a href="#" class="quick-action flex items-center justify-between p-3 rounded-lg border border-orchid-gold/20 hover:bg-orchid-gold/5" onclick="handleQuickAction(this)">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-orchid-gold/10 flex items-center justify-center mr-3">
                                            <i class="fas fa-store text-orchid-gold"></i>
                                        </div>
                                        <span class="font-medium">Add New Partner</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </a>
                                
                                <a href="#" class="quick-action flex items-center justify-between p-3 rounded-lg border border-orchid-dark/20 hover:bg-orchid-dark/5" onclick="handleQuickAction(this)">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-orchid-dark/10 flex items-center justify-center mr-3">
                                            <i class="fas fa-coins text-orchid-dark"></i>
                                        </div>
                                        <span class="font-medium">Adjust User Points</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </a>
                                
                                <a href="#" class="quick-action flex items-center justify-between p-3 rounded-lg border border-orchid-gold/20 hover:bg-orchid-gold/5" onclick="handleQuickAction(this)">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-orchid-gold/10 flex items-center justify-center mr-3">
                                            <i class="fas fa-money-check-alt text-orchid-gold"></i>
                                        </div>
                                        <span class="font-medium">Process Withdrawals</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </a>
                            </div>
                        </div>
                        
                        <!-- System Status -->
                        <div class="bg-white rounded-xl shadow overflow-hidden">
                            <div class="p-5 border-b border-gray-100">
                                <h3 class="font-bold text-gray-800">System Status</h3>
                            </div>
                            <div class="p-5 space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Platform Uptime</span>
                                    <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-800">99.7%</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">API Response Time</span>
                                    <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-800">142ms</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Active Sessions</span>
                                    <span class="px-3 py-1 rounded-full text-xs bg-purple-100 text-purple-800">247</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Database Load</span>
                                    <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">Medium</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Transactions -->
                <div class="mt-8">
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800">Recent Transactions</h3>
                            <div class="flex space-x-2">
                                <button class="px-4 py-2 text-sm font-medium rounded-lg border border-gray-300">Filter</button>
                                <button class="px-4 py-2 text-sm font-medium rounded-lg btn-primary">Export CSV</button>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="text-left p-4 text-sm font-medium text-gray-600">Date/Time</th>
                                        <th class="text-left p-4 text-sm font-medium text-gray-600">User</th>
                                        <th class="text-left p-4 text-sm font-medium text-gray-600">Type</th>
                                        <th class="text-left p-4 text-sm font-medium text-gray-600">Points</th>
                                        <th class="text-left p-4 text-sm font-medium text-gray-600">Partner</th>
                                        <th class="text-left p-4 text-sm font-medium text-gray-600">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="p-4 text-sm">15 Nov, 10:15 AM</td>
                                        <td class="p-4 font-medium">Alex Johnson</td>
                                        <td class="p-4">
                                            <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">Redemption</span>
                                        </td>
                                        <td class="p-4 font-bold text-orchid-gold">-250</td>
                                        <td class="p-4">Coffee Haven</td>
                                        <td class="p-4">
                                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Completed</span>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="p-4 text-sm">15 Nov, 09:42 AM</td>
                                        <td class="p-4 font-medium">Maria Garcia</td>
                                        <td class="p-4">
                                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Earned</span>
                                        </td>
                                        <td class="p-4 font-bold text-green-600">+100</td>
                                        <td class="p-4">Orchid Bakery</td>
                                        <td class="p-4">
                                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Completed</span>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="p-4 text-sm">14 Nov, 04:30 PM</td>
                                        <td class="p-4 font-medium">David Chen</td>
                                        <td class="p-4">
                                            <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">Redemption</span>
                                        </td>
                                        <td class="p-4 font-bold text-orchid-gold">-500</td>
                                        <td class="p-4">Urban Cafe</td>
                                        <td class="p-4">
                                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Completed</span>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="p-4 text-sm">14 Nov, 02:15 PM</td>
                                        <td class="p-4 font-medium">Sarah Williams</td>
                                        <td class="p-4">
                                            <span class="px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-800">Manual Adj.</span>
                                        </td>
                                        <td class="p-4 font-bold text-green-600">+200</td>
                                        <td class="p-4">Admin Adjustment</td>
                                        <td class="p-4">
                                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Completed</span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-4 text-sm">14 Nov, 11:05 AM</td>
                                        <td class="p-4 font-medium">James Wilson</td>
                                        <td class="p-4">
                                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Earned</span>
                                        </td>
                                        <td class="p-4 font-bold text-green-600">+150</td>
                                        <td class="p-4">Orchid Bakery</td>
                                        <td class="p-4">
                                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Completed</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 p-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-500 mb-2 md:mb-0">© 2023 Orchid Bakery Loyalty Platform. All rights reserved.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-sm text-gray-500 hover:text-orchid-dark">Help Center</a>
                        <a href="#" class="text-sm text-gray-500 hover:text-orchid-dark">Privacy Policy</a>
                        <a href="#" class="text-sm text-gray-500 hover:text-orchid-dark">Terms of Service</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Sidebar functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        function openSidebar() {
            sidebar.classList.add('open');
            sidebarOverlay.classList.add('active');
        }
        
        function closeSidebar() {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('active');
        }
        
        // Set active link in sidebar
        function setActiveLink(link) {
            // Remove active class from all sidebar links
            document.querySelectorAll('.sidebar-link').forEach(l => {
                l.classList.remove('bg-orchid-gold/10');
            });
            
            // Add active class to clicked link (if it's not the logout link)
            if (!link.querySelector('.fa-sign-out-alt')) {
                link.classList.add('bg-orchid-gold/10');
                
                // Update dashboard title based on clicked link
                const linkText = link.querySelector('span').textContent;
                const dashboardTitle = document.getElementById('dashboardTitle');
                if (dashboardTitle && linkText !== 'Logout') {
                    dashboardTitle.textContent = linkText;
                }
            }
            
            // Close sidebar on mobile after clicking
            if (window.innerWidth < 768) {
                closeSidebar();
            }
        }
        
        // Handle quick actions
        function handleQuickAction(action) {
            const actionText = action.querySelector('.font-medium').textContent;
            alert(`In a real application, this would open the ${actionText} interface.`);
            
            // Close sidebar on mobile if open
            if (window.innerWidth < 768) {
                closeSidebar();
            }
        }
        
        // Update date and time
        function updateDateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateString = now.toLocaleDateString('en-US', options);
            const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
            
            document.getElementById('currentDate').textContent = dateString;
            document.getElementById('currentTime').textContent = timeString;
        }
        
        // Add hover effects to stat cards
        document.addEventListener('DOMContentLoaded', function() {
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Update date and time initially and every minute
            updateDateTime();
            setInterval(updateDateTime, 60000);
            
            // Close sidebar with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeSidebar();
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    // On larger screens, ensure sidebar is visible
                    closeSidebar();
                }
            });
        });
    </script>
</body>
</html>
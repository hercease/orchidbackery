<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $metaTags ?>
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
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }
        
        .modal.active {
            display: flex;
        }
        
        /* Form styles */
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(1, 50, 32, 0.1);
        }
        
        /* Loading spinner */
        .spinner {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
    
    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
            <div class="p-8">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-6">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Points Awarded Successfully!</h3>
                    <p class="text-gray-600 mb-6" id="successMessage"></p>
                    <div class="bg-green-50 border border-green-100 rounded-lg p-4 mb-6 w-full">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">Points Awarded:</span>
                            <span class="font-bold text-green-600" id="awardedPoints">0</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">Customer:</span>
                            <span class="font-medium" id="awardedCustomer">-</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">New Balance:</span>
                            <span class="font-bold text-orchid-gold" id="newBalance">0</span>
                        </div>
                    </div>
                    <button onclick="closeSuccessModal()" class="w-full py-3 px-4 rounded-lg btn-primary">
                        Continue Awarding Points
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- User Details Modal -->
    <div id="userModal" class="modal">
        <div class="bg-white rounded-xl shadow-lg max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Customer Details</h3>
                    <button onclick="closeUserModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="w-16 h-16 rounded-full bg-orchid-dark/10 flex items-center justify-center mr-4">
                            <i class="fas fa-user text-orchid-dark text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg" id="userName">-</h4>
                            <p class="text-gray-600" id="userEmail">-</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <p class="text-sm text-gray-500 mb-1">Current Points</p>
                            <p class="text-2xl font-bold text-orchid-gold" id="userCurrentPoints">0</p>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <p class="text-sm text-gray-500 mb-1">Total Earned</p>
                            <p class="text-2xl font-bold text-green-600" id="userTotalEarned">0</p>
                        </div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-500 mb-2">Account Status</p>
                        <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-800" id="userStatus">-</span>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-500 mb-2">Member Since</p>
                        <p class="font-medium" id="userJoinDate">-</p>
                    </div>
                    
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200 flex space-x-4">
                    <button onclick="closeUserModal()" class="flex-1 py-3 px-4 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50">
                        Close
                    </button>
                    <button onclick="useUserForAward()" class="flex-1 py-3 px-4 rounded-lg btn-secondary">
                        <i class="fas fa-gift mr-2"></i> Award Points
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex h-screen">
        <!-- Sidebar Navigation -->
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
                        <h2 class="text-xl font-semibold text-gray-800">Award Points</h2>
                    </div>
                </div>
                <!--<div class="flex items-center space-x-4">
                    <button onclick="refreshRate()" class="p-2 rounded-lg border border-gray-300 hover:bg-gray-50" id="refreshBtn">
                        <i class="fas fa-sync-alt text-gray-600"></i>
                    </button>
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-medium" id="currentDate"><?php echo date('l, d M Y'); ?></p>
                    </div>
                </div>-->
            </header>
            
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-6xl mx-auto">
                    <!-- Stats Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="stat-card bg-white rounded-xl shadow p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500">Today's Awards</p>
                                    <p class="text-3xl font-bold mt-2 text-green-600"><?php echo $awardStats['today_awards'] ?? 0; ?></p>
                                    <p class="text-xs text-gray-500 mt-1" id="todayAmount">&#8358; <?php echo $awardStats['today_amount'] ?? 0; ?> awarded</p>
                                </div>
                                <div class="p-3 rounded-full bg-green-100">
                                    <i class="fas fa-gift text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stat-card bg-white rounded-xl shadow p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500">Monthly Total</p>
                                    <p class="text-3xl font-bold mt-2 text-orchid-gold" id="monthlyPoints"><?php echo $awardStats['monthly_points'] ?? 0; ?></p>
                                    <p class="text-xs text-gray-500 mt-1" id="monthlyCustomers"><?php echo $awardStats['monthly_customers'] ?? 0; ?> customers</p>
                                </div>
                                <div class="p-3 rounded-full bg-orchid-gold/10">
                                    <i class="fas fa-chart-line text-orchid-gold text-xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stat-card bg-white rounded-xl shadow p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500">Active Customers</p>
                                    <p class="text-3xl font-bold mt-2 text-blue-600" id="activeCustomers"><?php echo $awardStats['active_customers'] ?? 0; ?></p>
                                    <p class="text-xs text-green-600 mt-1" id="customerGrowth">+<?php echo $awardStats['new_customers_month'] ?? 0; ?> this month</p>
                                </div>
                                <div class="p-3 rounded-full bg-blue-100">
                                    <i class="fas fa-users text-blue-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stat-card bg-white rounded-xl shadow p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500">Avg. Purchase</p>
                                    <p class="text-3xl font-bold mt-2 text-purple-600" id="avgPurchase">&#8358; <?php echo $awardStats['avg_purchase'] ?? 0; ?></p>
                                    <p class="text-xs text-gray-500 mt-1">Per transaction</p>
                                </div>
                                <div class="p-3 rounded-full bg-purple-100">
                                    <i class="fas fa-shopping-cart text-purple-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Award Points Form -->
                        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-6">Award Points to Customer</h3>
                            
                            <form id="awardForm" onsubmit="submitAwardForm(event)">
                                <div class="space-y-6">
                                    <!-- Customer Email -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Customer Email Address *
                                        </label>
                                        <div class="relative">
                                            <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                            <input type="email" 
                                                   id="customerEmail" 
                                                   class="w-full pl-12 pr-10 py-3 border border-gray-300 rounded-lg form-input focus:border-orchid-dark focus:ring-orchid-dark" 
                                                   placeholder="customer@example.com"
                                                   required
                                                   onblur="checkUserDetails()">
                                            <button type="button" 
                                                    onclick="clearCustomer()" 
                                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                                    id="clearCustomerBtn"
                                                    style="display: none;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="mt-2" id="userCheckResult">
                                            <!-- User check result will appear here -->
                                        </div>
                                    </div>
                                    
                                    <!-- Sales Amount -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Sales Amount (&#8358;) *
                                        </label>
                                        <div class="relative">
                                            <i class="fas fa-naira-sign absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                            <input type="number" 
                                                   id="salesAmount" 
                                                   min="0.01" 
                                                   step="0.01" 
                                                   class="w-full pl-12 pr-10 py-3 border border-gray-300 rounded-lg form-input focus:border-orchid-dark focus:ring-orchid-dark" 
                                                   placeholder="0.00"
                                                   required
                                                   oninput="calculatePoints()">
                                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">NGN</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Points Calculation -->
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-gray-600">Purchase Amount:</span>
                                            <span class="font-medium" id="displayAmount">&#8358;0.00</span>
                                        </div>
                                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                            <span class="font-bold text-gray-800">Points to Award:</span>
                                            <span class="text-2xl font-bold text-orchid-gold" id="calculatedPoints">0</span>
                                        </div>
                                    </div>
                                    
                                    
                                    <!-- Submit Button -->
                                    <div class="pt-4">
                                        <button type="submit" 
                                                class="w-full py-3 px-4 rounded-lg btn-primary text-lg font-medium"
                                                id="submitBtn">
                                            <i class="fas fa-gift mr-2"></i>
                                            <span id="submitText">Award Points</span>
                                            <span id="submitLoading" class="hidden ml-2">
                                                <i class="fas fa-spinner spinner"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Points Rate & Recent Awards -->
                        <div class="space-y-6">
                            <!-- Current Rate Card -->
                            <div class="bg-white rounded-xl shadow p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="font-bold text-gray-800">Current Points Rate</h3>
                                    <span class="text-xs text-gray-500" id="rateUpdated">Loading...</span>
                                </div>
                                <div class="text-center mb-4">
                                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-orchid-dark/10 mb-3">
                                        <i class="fas fa-percentage text-orchid-dark text-2xl"></i>
                                    </div>
                                    <p class="text-gray-600">1 naira = <?php echo $rates['conversion_rate'] ?> points</p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <!-- Quick Actions & Bulk Award -->
                    <div class="bg-white rounded-xl shadow p-6 mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <button onclick="quickAction(100)" class="p-4 bg-orchid-dark/5 border border-orchid-dark/20 rounded-lg hover:bg-orchid-dark/10 transition-colors">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-orchid-dark mb-1">&#8358;100</p>
                                    <p class="text-sm text-gray-600"><?php echo $rates['conversion_rate'] * 100 ?> Points</p>
                                </div>
                            </button>
                            <button onclick="quickAction(500)" class="p-4 bg-orchid-dark/5 border border-orchid-dark/20 rounded-lg hover:bg-orchid-dark/10 transition-colors">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-orchid-dark mb-1">&#8358;500</p>
                                    <p class="text-sm text-gray-600"><?php echo $rates['conversion_rate'] * 500 ?> Points</p>
                                </div>
                            </button>
                            <button onclick="quickAction(1000)" class="p-4 bg-orchid-dark/5 border border-orchid-dark/20 rounded-lg hover:bg-orchid-dark/10 transition-colors">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-orchid-dark mb-1">&#8358;1000</p>
                                    <p class="text-sm text-gray-600"><?php echo $rates['conversion_rate'] * 1000 ?> Points</p>
                                </div>
                            </button>
                            <button onclick="quickAction(5000)" class="p-4 bg-orchid-dark/5 border border-orchid-dark/20 rounded-lg hover:bg-orchid-dark/10 transition-colors">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-orchid-dark mb-1">&#8358;5000</p>
                                    <p class="text-sm text-gray-600"><?php echo $rates['conversion_rate'] * 5000 ?> Points</p>
                                </div>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Recent Transactions Table -->
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="font-bold text-gray-800">Recent Point Transactions</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="text-left p-4 text-sm font-medium text-gray-600">Date/Time</th>
                                        <th class="text-left p-4 text-sm font-medium text-gray-600">Customer</th>
                                        <th class="text-left p-4 text-sm font-medium text-gray-600">Amount</th>
                                        <th class="text-left p-4 text-sm font-medium text-gray-600">Points Awarded</th>
                                        <th class="text-left p-4 text-sm font-medium text-gray-600">Admin</th>
                                        <th class="text-left p-4 text-sm font-medium text-gray-600">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="transactionsTable">
                                    <!-- Transactions will be loaded here -->
                                    <tr>
                                        <td colspan="6" class="p-8 text-center">
                                            <div class="flex flex-col items-center justify-center space-y-3">
                                                <i class="fas fa-exchange-alt text-gray-300 text-3xl"></i>
                                                <p class="text-gray-500">Loading transactions...</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 border-t border-gray-100 text-center">
                            <a href="points-history.html" class="text-orchid-dark hover:text-orchid-gold font-medium">
                                View All Transactions <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 p-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-500 mb-2 md:mb-0">© <?php echo date('Y'); ?> Orchid Bakery Loyalty Platform. All rights reserved.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-sm text-gray-500 hover:text-orchid-dark">Help Center</a>
                        <a href="#" class="text-sm text-gray-500 hover:text-orchid-dark">Privacy Policy</a>
                        <a href="#" class="text-sm text-gray-500 hover:text-orchid-dark">Terms of Service</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bulk Award Modal -->
    <div id="bulkModal" class="modal">
        <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Bulk Points Award</h3>
                    <button onclick="closeBulkModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="bulkForm" onsubmit="submitBulkAward(event)">
                    <div class="space-y-6">
                        <!-- CSV Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Upload CSV File *
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition-colors">
                                <i class="fas fa-file-csv text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-600 mb-2">Drag & drop your CSV file here</p>
                                <p class="text-sm text-gray-500 mb-4">or click to browse</p>
                                <input type="file" 
                                       id="csvFile" 
                                       accept=".csv" 
                                       class="hidden" 
                                       onchange="handleCSVUpload(this)">
                                <button type="button" 
                                        onclick="document.getElementById('csvFile').click()" 
                                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                    Browse Files
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                CSV format: email,amount,notes (optional)
                            </p>
                        </div>
                        
                        <!-- Preview -->
                        <div id="csvPreview" class="hidden">
                            <h4 class="font-bold text-gray-800 mb-3">Preview</h4>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 max-h-60 overflow-y-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-200">
                                            <th class="text-left py-2 text-gray-600">Email</th>
                                            <th class="text-left py-2 text-gray-600">Amount</th>
                                            <th class="text-left py-2 text-gray-600">Points</th>
                                            <th class="text-left py-2 text-gray-600">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="previewTable">
                                        <!-- Preview rows will appear here -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span class="text-sm text-gray-600" id="previewCount">0 records</span>
                                <span class="text-sm font-bold text-orchid-gold" id="previewTotalPoints">0 total points</span>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full py-3 px-4 rounded-lg btn-primary text-lg font-medium"
                                    id="bulkSubmitBtn"
                                    disabled>
                                <i class="fas fa-gift mr-2"></i>
                                <span id="bulkSubmitText">Process Bulk Award</span>
                                <span id="bulkSubmitLoading" class="hidden ml-2">
                                    <i class="fas fa-spinner spinner"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentUser = null;
        let currentRate = <?php echo $rates['conversion_rate']; ?>;
        let minPurchase = 1.0;
        let maxPoints = 1000;
        let isLoading = false;
        
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
        
        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Load initial data
           // fetchRecentAwards();
           // fetchRecentTransactions();
            
            // Update date
            updateDate();
            
            // Handle window resize for sidebar
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    closeSidebar();
                }
            });
            
            // Close modals with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeSuccessModal();
                    closeUserModal();
                    closeBulkModal();
                    closeSidebar();
                }
            });
        });
        
        // Update date
        function updateDate() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
        }
        
        
        
        // Update rate display
        function updateRateDisplay(rateData) {
            currentRate = rateData.rate;
            // Recalculate points if amount is entered
            calculatePoints();
        }
        
        
        // Fetch recent awards
       /* async function fetchRecentAwards() {
            try {
                const response = await fetch('/api/get_recent_awards?limit=5');
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    updateRecentAwards(data.awards);
                }
                
            } catch (error) {
                console.error('Error fetching recent awards:', error);
            }
        } */
        
        // Update recent awards display
        function updateRecentAwards(awards) {
            const container = document.getElementById('recentAwards');
            
            if (!awards || awards.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-gift text-gray-300 text-2xl mb-3"></i>
                        <p class="text-gray-500">No recent awards</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            awards.forEach(award => {
                html += `
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-orchid-dark/10 flex items-center justify-center mr-3">
                                <i class="fas fa-user text-orchid-dark"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm">${award.user_name || award.user_email}</p>
                                <p class="text-xs text-gray-500">${formatDate(award.created_at)}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-orchid-gold">+${award.points}</p>
                            <p class="text-xs text-gray-500">$${parseFloat(award.amount).toFixed(2)}</p>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }
        
        // Fetch recent transactions
        /*async function fetchRecentTransactions() {
            try {
                const response = await fetch('/api/get_recent_transactions?limit=10');
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    updateTransactionsTable(data.transactions);
                }
                
            } catch (error) {
                console.error('Error fetching transactions:', error);
            }
        }*/
        
        // Update transactions table
        function updateTransactionsTable(transactions) {
            const tableBody = document.getElementById('transactionsTable');
            
            if (!transactions || transactions.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="p-8 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <i class="fas fa-exchange-alt text-gray-300 text-3xl"></i>
                                <p class="text-gray-500">No transactions found</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }
            
            let html = '';
            transactions.forEach(transaction => {
                const date = new Date(transaction.created_at);
                const timeString = date.toLocaleTimeString('en-US', { 
                    hour: '2-digit', 
                    minute: '2-digit' 
                });
                const dateString = date.toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric' 
                });
                
                html += `
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="p-4">
                            <div class="text-sm font-medium text-gray-900">${dateString}</div>
                            <div class="text-xs text-gray-500">${timeString}</div>
                        </td>
                        <td class="p-4">
                            <p class="font-medium">${transaction.user_name || 'Unknown User'}</p>
                            <p class="text-xs text-gray-500">${transaction.user_email || 'No email'}</p>
                        </td>
                        <td class="p-4">
                            <p class="font-bold">$${parseFloat(transaction.amount).toFixed(2)}</p>
                        </td>
                        <td class="p-4">
                            <p class="font-bold text-orchid-gold">+${transaction.points}</p>
                        </td>
                        <td class="p-4">
                            <p class="text-sm">${transaction.admin_name || 'System'}</p>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                Completed
                            </span>
                        </td>
                    </tr>
                `;
            });
            
            tableBody.innerHTML = html;
        }
        
        // Check user details by email
        async function checkUserDetails() {
            const email = document.getElementById('customerEmail').value.trim();
            
            if (!email || !isValidEmail(email)) {
                hideClearButton();
                clearUserCheckResult();
                return;
            }
            
            try {
                const response = await fetch('get_user_info',{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        partner_id : email
                    })
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.status) {
                    currentUser = data;
                    showClearButton();
                    showUserCheckResult(data, true);
                } else {
                    currentUser = null;
                    hideClearButton();
                    showUserCheckResult(null, false, data.error || 'User not found');
                }
                
            } catch (error) {
                console.error('Error checking user:', error);
                currentUser = null;
                hideClearButton();
                showUserCheckResult(null, false, 'Error checking user');
            }
        }
        
        // Show user check result
        function showUserCheckResult(user, found, error = '') {
            const container = document.getElementById('userCheckResult');
            
            if (found && user) {
                container.innerHTML = `
                    <div class="flex items-center justify-between p-3 bg-green-50 border border-green-100 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                            <div>
                                <p class="font-medium text-green-800">${user.first_name} ${user.last_name}</p>
                                <p class="text-sm text-green-600">${user.points_balance || 0} current points</p>
                            </div>
                        </div>
                        <button onclick="showUserModal()" class="text-sm text-orchid-dark hover:text-orchid-gold">
                            View Details <i class="fas fa-chevron-right ml-1"></i>
                        </button>
                    </div>
                `;
            } else {
                container.innerHTML = `
                    <div class="flex items-center p-3 bg-yellow-50 border border-yellow-100 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                        <div>
                            <p class="font-medium text-yellow-800">${error || 'User not found'}</p>
                            <p class="text-sm text-yellow-600">Please check the email address or register the user first</p>
                        </div>
                    </div>
                `;
            }
        }
        
        // Clear user check result
        function clearUserCheckResult() {
            document.getElementById('userCheckResult').innerHTML = '';
        }
        
        // Show clear button
        function showClearButton() {
            document.getElementById('clearCustomerBtn').style.display = 'block';
        }
        
        // Hide clear button
        function hideClearButton() {
            document.getElementById('clearCustomerBtn').style.display = 'none';
        }
        
        // Clear customer field
        function clearCustomer() {
            document.getElementById('customerEmail').value = '';
            currentUser = null;
            hideClearButton();
            clearUserCheckResult();
        }
        
        // Calculate points based on sales amount
        function calculatePoints() {
            const amountInput = document.getElementById('salesAmount');
            const amount = parseFloat(amountInput.value) || 0;
            
            // Update display amount
            document.getElementById('displayAmount').textContent = 
                `\u20A6${amount.toFixed(2)}`;
            
            // Calculate points
            let points = Math.floor(amount * currentRate);
            
            // Apply maximum points limit
            if (points > maxPoints) {
                points = maxPoints;
            }
            
            // Update calculated points
            document.getElementById('calculatedPoints').textContent = points;
            
            // Validate minimum purchase
            if (amount > 0 && amount < minPurchase) {
                amountInput.setCustomValidity(`Minimum purchase is $${minPurchase.toFixed(2)}`);
            } else {
                amountInput.setCustomValidity('');
            }
        }
        
        // Submit award form
        async function submitAwardForm(event) {
            event.preventDefault();
            
            if (isLoading) return;
            
            const email = document.getElementById('customerEmail').value.trim();
            const amount = parseFloat(document.getElementById('salesAmount').value);
            const notes = document.getElementById('awardNotes').value.trim();
            
            // Validation
            if (!isValidEmail(email)) {
                showNotification('Please enter a valid email address', 'warning');
                return;
            }
            
            if (isNaN(amount) || amount <= 0) {
                showNotification('Please enter a valid amount', 'warning');
                return;
            }
            
            try {
                // Show loading
                setLoading(true);
                
                // Prepare data
                const data = {
                    user_email: email,
                    amount: amount,
                    points: Math.floor(amount * currentRate),
                };
                
                // Submit to API
                const response = await fetch('process_point_award', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams(data),
                });
                
                const result = await response.json();
                
                if (result.status) {
                    // Show success modal
                    showSuccessModal(result.data);
                    
                    // Reset form
                    resetForm();
                    
                    // Refresh data
                } else {
                    throw new Error(result.error || 'Failed to award points');
                }
                
            } catch (error) {
                console.error('Error awarding points:', error);
                showNotification(error.message || 'Failed to award points', 'error');
            } finally {
                setLoading(false);
            }
        }
        
        // Show success modal
        function showSuccessModal(data) {
            document.getElementById('successMessage').textContent = 
                `Points have been successfully awarded to ${data.user_email}.`;
            document.getElementById('awardedPoints').textContent = `+${data.points_awarded}`;
            document.getElementById('awardedCustomer').textContent = data.user_name || data.user_email;
            document.getElementById('newBalance').textContent = data.new_balance;
            document.getElementById('successModal').classList.add('active');
        }
        
        // Close success modal
        function closeSuccessModal() {
            document.getElementById('successModal').classList.remove('active');
        }
        
        // Reset form
        function resetForm() {
            document.getElementById('customerEmail').value = '';
            document.getElementById('salesAmount').value = '';
            document.getElementById('awardNotes').value = '';
            currentUser = null;
            hideClearButton();
            clearUserCheckResult();
            calculatePoints();
        }
        
        // Show user modal
        async function showUserModal() {
            if (!currentUser) return;
            
            try {
                const response = await fetch('get_user_info',{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        partner_id: currentUser.id
                    })
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.status) {
                    updateUserModal(data);
                    document.getElementById('userModal').classList.add('active');
                }
                
            } catch (error) {
                console.error('Error fetching user details:', error);
                showNotification('Failed to load user details', 'error');
            }
        }
        
        // Update user modal
        function updateUserModal(user) {
            document.getElementById('userName').textContent = user.first_name + ' ' + user.last_name || 'Unknown User';
            document.getElementById('userEmail').textContent = user.email || 'No email';
            document.getElementById('userCurrentPoints').textContent = user.points_balance || 0;
            document.getElementById('userTotalEarned').textContent = user.total_points_earned || 0;
            document.getElementById('userStatus').textContent = 
                user.status === 'active' ? 'Active' : 'Inactive';
            document.getElementById('userJoinDate').textContent = formatDate(user.created_at);
        }
        
        // Close user modal
        function closeUserModal() {
            document.getElementById('userModal').classList.remove('active');
        }
        
        // Use user for award
        function useUserForAward() {
            if (currentUser) {
                document.getElementById('customerEmail').value = currentUser.email;
                closeUserModal();
                document.getElementById('salesAmount').focus();
            }
        }
        
        // Quick action (predefined amounts)
        function quickAction(amount) {
            document.getElementById('salesAmount').value = amount;
            calculatePoints();
            
            if (!document.getElementById('customerEmail').value) {
                document.getElementById('customerEmail').focus();
                showNotification('Please enter customer email first', 'info');
            }
        }
        
        // Bulk award modal
        function openBulkAwardModal() {
            document.getElementById('bulkModal').classList.add('active');
            resetBulkForm();
        }
        
        function closeBulkModal() {
            document.getElementById('bulkModal').classList.remove('active');
        }
        
        function resetBulkForm() {
            document.getElementById('csvFile').value = '';
            document.getElementById('csvPreview').classList.add('hidden');
            document.getElementById('bulkSubmitBtn').disabled = true;
        }
        
        // Handle CSV upload
        function handleCSVUpload(input) {
            const file = input.files[0];
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const csv = e.target.result;
                const records = parseCSV(csv);
                previewCSV(records);
            };
            reader.readAsText(file);
        }
        
        // Parse CSV
        function parseCSV(csv) {
            const lines = csv.split('\n');
            const records = [];
            
            for (let i = 0; i < lines.length; i++) {
                const line = lines[i].trim();
                if (!line || i === 0) continue; // Skip header and empty lines
                
                const parts = line.split(',');
                if (parts.length >= 2) {
                    records.push({
                        email: parts[0].trim(),
                        amount: parseFloat(parts[1]) || 0,
                        notes: parts[2] ? parts[2].trim() : ''
                    });
                }
            }
            
            return records;
        }
        
        // Preview CSV
        function previewCSV(records) {
            const previewContainer = document.getElementById('csvPreview');
            const previewTable = document.getElementById('previewTable');
            const previewCount = document.getElementById('previewCount');
            const previewTotalPoints = document.getElementById('previewTotalPoints');
            const submitBtn = document.getElementById('bulkSubmitBtn');
            
            if (records.length === 0) {
                previewContainer.classList.add('hidden');
                submitBtn.disabled = true;
                return;
            }
            
            let totalPoints = 0;
            let tableHTML = '';
            
            records.forEach((record, index) => {
                const points = Math.floor(record.amount * currentRate);
                totalPoints += points;
                
                tableHTML += `
                    <tr class="${index % 2 === 0 ? 'bg-white' : 'bg-gray-50'}">
                        <td class="py-2 px-1">${record.email}</td>
                        <td class="py-2 px-1">$${record.amount.toFixed(2)}</td>
                        <td class="py-2 px-1">+${points}</td>
                        <td class="py-2 px-1">
                            <span class="px-2 py-1 rounded-full text-xs ${isValidEmail(record.email) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                ${isValidEmail(record.email) ? 'Valid' : 'Invalid'}
                            </span>
                        </td>
                    </tr>
                `;
            });
            
            previewTable.innerHTML = tableHTML;
            previewCount.textContent = `${records.length} record${records.length !== 1 ? 's' : ''}`;
            previewTotalPoints.textContent = `${totalPoints} total points`;
            
            previewContainer.classList.remove('hidden');
            submitBtn.disabled = false;
        }
        
        // Submit bulk award
        async function submitBulkAward(event) {
            event.preventDefault();
            
            const fileInput = document.getElementById('csvFile');
            if (!fileInput.files[0]) {
                showNotification('Please select a CSV file', 'warning');
                return;
            }
            
            try {
                // Show loading
                document.getElementById('bulkSubmitText').textContent = 'Processing...';
                document.getElementById('bulkSubmitLoading').classList.remove('hidden');
                document.getElementById('bulkSubmitBtn').disabled = true;
                
                const formData = new FormData();
                formData.append('csv_file', fileInput.files[0]);
                
                const response = await fetch('/api/bulk_award_points', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(`Successfully awarded points to ${result.processed} customers`, 'success');
                    closeBulkModal();
                    
                    // Refresh data
                    fetchStatistics();
                    fetchRecentAwards();
                    fetchRecentTransactions();
                } else {
                    throw new Error(result.error || 'Failed to process bulk award');
                }
                
            } catch (error) {
                console.error('Error processing bulk award:', error);
                showNotification(error.message || 'Failed to process bulk award', 'error');
            } finally {
                // Reset button
                document.getElementById('bulkSubmitText').textContent = 'Process Bulk Award';
                document.getElementById('bulkSubmitLoading').classList.add('hidden');
                document.getElementById('bulkSubmitBtn').disabled = false;
            }
        }
        
        // Refresh rate
        function refreshRate() {
            fetchPointsRate();
            showNotification('Points rate refreshed', 'info');
        }
        
        // Set loading state
        function setLoading(loading) {
            isLoading = loading;
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitLoading = document.getElementById('submitLoading');
            const refreshBtn = document.getElementById('refreshBtn');
            
            if (loading) {
                submitBtn.disabled = true;
                submitText.textContent = 'Processing...';
                submitLoading.classList.remove('hidden');
                refreshBtn.classList.add('fa-spin');
            } else {
                submitBtn.disabled = false;
                submitText.textContent = 'Award Points';
                submitLoading.classList.add('hidden');
                refreshBtn.classList.remove('fa-spin');
            }
        }
        
        // Helper functions
        function isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        }
        
        // Notification function
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${type === 'success' ? 'bg-green-100 text-green-800 border-l-4 border-green-500' : type === 'warning' ? 'bg-orange-100 text-orange-800 border-l-4 border-orange-500' : type === 'error' ? 'bg-red-100 text-red-800 border-l-4 border-red-500' : 'bg-blue-100 text-blue-800 border-l-4 border-blue-500'}`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'warning' ? 'fa-exclamation-triangle' : type === 'error' ? 'fa-times-circle' : 'fa-info-circle'} mr-3"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Remove notification after 5 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 5000);
        }
    </script>
</body>
</html>
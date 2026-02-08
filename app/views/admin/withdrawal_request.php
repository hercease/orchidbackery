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
        
        /* Status badge styles */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        /* Progress bar styles */
        .progress-bar {
            height: 6px;
            border-radius: 3px;
            background-color: #e5e7eb;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 0.3s ease;
        }
        
        /* Loading skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
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
    
    <!-- Process Withdrawal Modal -->
    <div id="processModal" class="modal">
        <div class="bg-white rounded-xl shadow-lg max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800" id="processModalTitle">Process Withdrawal</h3>
                    <button onclick="closeProcessModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm text-gray-600">Request ID</p>
                        <p class="font-medium" id="processRequestId">-</p>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm text-gray-600">Amount</p>
                        <p class="text-lg font-bold text-orchid-gold" id="processAmount">$0.00</p>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm text-gray-600">User</p>
                        <div class="text-right">
                            <p class="font-medium" id="processUserName">-</p>
                            <p class="text-sm text-gray-500" id="processUserEmail">-</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm text-gray-600">Request Date</p>
                        <p class="text-sm text-gray-600" id="processDate">-</p>
                    </div>
                    <div id="processDescription" class="mb-4 p-3 bg-gray-50 rounded-lg hidden">
                        <p class="text-sm font-medium text-gray-600 mb-1">Description:</p>
                        <p class="text-sm text-gray-800" id="processDescText">-</p>
                    </div>
                </div>
                
                <form id="processForm" onsubmit="submitWithdrawalAction(event)">
                    <input type="hidden" id="processWithdrawalId">
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Action *</label>
                        <select id="processAction" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent" required onchange="toggleRejectionReason()">
                            <option value="">Select Action</option>
                            <option value="completed">Approve & Complete</option>
                            <option value="processing">Mark as Processing</option>
                            <option value="cancelled">Cancel Request</option>
                            <option value="pending">Mark as Pending</option>
                        </select>
                    </div>
                    
                    <div id="rejectionReason" class="mb-6 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cancellation Reason *</label>
                        <textarea id="processReason" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent" placeholder="Please provide a reason for cancellation..."></textarea>
                        <p class="text-xs text-gray-500 mt-2">This reason will be shared with the user</p>
                    </div>
                    
                    <div id="paymentDetails" class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Status</label>
                        <div class="border border-gray-300 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">Status:</span>
                                <span id="currentStatusBadge" class="status-badge bg-gray-100 text-gray-800">-</span>
                            </div>
                            <div id="currentReference" class="mb-2">
                                <span class="text-sm text-gray-600">Reference:</span>
                                <span class="text-sm font-mono text-gray-800 ml-2" id="referenceText">-</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-2" id="statusNote">-</p>
                        </div>
                    </div>
                    
                    <div class="flex space-x-4">
                        <button type="button" onclick="closeProcessModal()" class="flex-1 py-3 px-4 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="flex-1 py-3 px-4 rounded-lg btn-primary" id="submitActionBtn">
                            <span id="submitActionText">Submit Action</span>
                            <span id="submitLoading" class="hidden">
                                <i class="fas fa-spinner fa-spin ml-2"></i>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bulk Action Modal -->
    <div id="bulkModal" class="modal">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 mx-auto mb-4">
                    <i class="fas fa-tasks text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center mb-2">Bulk Action</h3>
                <p class="text-gray-600 text-center mb-6" id="bulkModalText">Apply action to <span id="selectedCount">0</span> selected withdrawals</p>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Action *</label>
                    <select id="bulkAction" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                        <option value="">Select Action</option>
                        <option value="completed">Approve Selected</option>
                        <option value="cancelled">Reject Selected</option>
                        <option value="processing">Mark as Processing</option>
                        <option value="pending">Mark as Pending</option>
                    </select>
                </div>
                
                <div class="flex space-x-4">
                    <button onclick="closeBulkModal()" class="flex-1 py-3 px-4 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50">Cancel</button>
                    <button onclick="processBulkAction()" class="flex-1 py-3 px-4 rounded-lg btn-primary">
                        <span id="bulkSubmitText">Apply</span>
                        <span id="bulkSubmitLoading" class="hidden">
                            <i class="fas fa-spinner fa-spin ml-2"></i>
                        </span>
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
                        <h2 class="text-xl font-semibold text-gray-800">Withdrawal Requests</h2>
                        <p class="text-sm text-gray-500" id="lastUpdated">Review and process user withdrawal requests</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="refreshWithdrawals()" class="p-2 rounded-lg border border-gray-300 hover:bg-gray-50" id="refreshBtn">
                        <i class="fas fa-sync-alt text-gray-600"></i>
                    </button>
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-medium" id="currentDate"><?php echo date('l, d M Y'); ?></p>
                    </div>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Stats will be loaded dynamically -->
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Pending Requests</p>
                                <p class="text-3xl font-bold mt-2 text-orange-500" id="statPending">0</p>
                                <p class="text-xs text-gray-500 mt-1" id="statPendingText">Loading...</p>
                            </div>
                            <div class="p-3 rounded-full bg-orange-100">
                                <i class="fas fa-clock text-orange-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Completed This Week</p>
                                <p class="text-3xl font-bold mt-2 text-green-600" id="statCompleted">0</p>
                                <p class="text-xs text-gray-500 mt-1" id="statCompletedText">This week</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Total Amount</p>
                                <p class="text-3xl font-bold mt-2 text-orchid-gold" id="statAmount">$0</p>
                                <p class="text-xs text-gray-500 mt-1" id="statAmountText">In pending requests</p>
                            </div>
                            <div class="p-3 rounded-full bg-orchid-gold/10">
                                <i class="fas fa-money-bill-wave text-orchid-gold text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Avg Processing Time</p>
                                <p class="text-3xl font-bold mt-2 text-blue-600" id="statAvgTime">0</p>
                                <p class="text-xs text-gray-500 mt-1" id="statAvgTimeText">Days</p>
                            </div>
                            <div class="p-3 rounded-full bg-blue-100">
                                <i class="fas fa-business-time text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Search and Action Bar -->
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" id="searchWithdrawals" placeholder="Search by user name, request ID, or amount..." 
                                       class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent"
                                       onkeyup="debouncedFilterWithdrawals()">
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <select id="statusFilter" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent" onchange="filterWithdrawals()">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <select id="dateFilter" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent" onchange="filterWithdrawals()">
                                <option value="">All Dates</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                                <option value="older">Older</option>
                            </select>
                            <button onclick="exportWithdrawals()" class="px-4 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                                <i class="fas fa-download mr-2"></i> Export
                            </button>
                            <button onclick="openBulkModal()" id="bulkActionBtn" class="px-4 py-3 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 hidden">
                                <i class="fas fa-tasks mr-2"></i> Bulk Action
                            </button>
                        </div>
                    </div>
                    
                    <!-- Processing Progress -->
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-sm font-medium text-gray-700">Weekly Processing Progress</p>
                            <p class="text-sm font-medium text-orchid-dark" id="progressPercent">0%</p>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-orchid-dark" id="progressBar" style="width: 0%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-2">
                            <span id="progressText">0 of 0 requests processed</span>
                            <span>Target: 90% weekly</span>
                        </div>
                    </div>
                </div>
                
                <!-- Withdrawals Table -->
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-gray-800">Withdrawal Requests</h3>
                            <p class="text-sm text-gray-500" id="withdrawalCount">Loading...</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="selectAll" class="h-5 w-5 text-orchid-dark rounded border-gray-300" onchange="toggleSelectAll()">
                                <label for="selectAll" class="ml-2 text-sm text-gray-600">Select All</label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-600">Show:</span>
                                <select id="pageSize" class="px-3 py-2 border border-gray-300 rounded-lg text-sm" onchange="changePageSize()">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600 w-12">
                                        <!-- Checkbox column -->
                                    </th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Request ID</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">User</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Amount</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Request Date</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Status</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="withdrawalsTableBody">
                                <!-- Loading skeleton -->
                                <tr id="loadingRow">
                                    <td colspan="7" class="p-8">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div class="w-12 h-12 rounded-full bg-orchid-dark/10 flex items-center justify-center">
                                                <i class="fas fa-spinner fa-spin text-orchid-dark text-xl"></i>
                                            </div>
                                            <p class="text-gray-600">Loading withdrawal requests...</p>
                                            <p class="text-sm text-gray-500">Fetching data from server</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="p-4 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center">
                        <div class="text-sm text-gray-500 mb-4 md:mb-0">
                            Showing <span id="startRow">0</span> to <span id="endRow">0</span> of <span id="totalRows">0</span> entries
                        </div>
                        <div class="flex items-center space-x-2">
                            <button id="prevPage" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" onclick="changePage(-1)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <div class="flex items-center space-x-1" id="pageNumbers">
                                <!-- Page numbers will be populated by JavaScript -->
                            </div>
                            <button id="nextPage" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" onclick="changePage(1)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Financial Summary -->
                <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Monthly Withdrawal Summary</h3>
                        <div class="space-y-4" id="financialSummary">
                            <!-- Will be populated by JavaScript -->
                            <div class="text-center py-8">
                                <i class="fas fa-chart-pie text-gray-300 text-3xl mb-3"></i>
                                <p class="text-gray-500">Loading financial data...</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-gray-800">Recent Activity</h3>
                            <a href="activity-log.html" class="text-sm text-orchid-dark font-medium">View All</a>
                        </div>
                        <div class="space-y-4" id="recentActivity">
                            <!-- Will be populated by JavaScript -->
                            <div class="text-center py-8">
                                <i class="fas fa-history text-gray-300 text-3xl mb-3"></i>
                                <p class="text-gray-500">Loading recent activity...</p>
                            </div>
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

    <script>
        // Global variables
        let currentPage = 1;
        let pageSize = 10;
        let allWithdrawals = [];
        let filteredWithdrawals = [];
        let selectedWithdrawals = new Set();
        let withdrawalToProcess = null;
        let isLoading = false;
        let filterTimeout = null;
        
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
        
        // Fetch withdrawals from API
        async function fetchWithdrawals() {
            if (isLoading) return;
            
            try {
                showLoading();
                
                const searchTerm = document.getElementById('searchWithdrawals').value;
                const statusFilter = document.getElementById('statusFilter').value;
                const dateFilter = document.getElementById('dateFilter').value;
                
                // Build query parameters
                const params = new URLSearchParams({
                    page: currentPage,
                    limit: pageSize,
                    search: searchTerm || '',
                    status: statusFilter || '',
                    date_filter: dateFilter || ''
                });
                
                const response = await fetch('fetch_withdrawal_requests',{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: params
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.status) {
                    allWithdrawals = data.withdrawals || [];
                    filteredWithdrawals = data.withdrawals || [];
                    
                    // Update statistics
                    updateStatistics(data.stats || {});
                    updateFinancialSummary(data.financial_summary || {});
                    updateRecentActivity(data.recent_activity || []);
                    updateProgress(data.progress || {});
                    
                    // Render withdrawals
                    renderWithdrawals();
                    updateLastUpdated();
                } else {
                    throw new Error(data.error || 'Failed to fetch withdrawals');
                }
                
            } catch (error) {
                console.error('Error fetching withdrawals:', error);
                showError('Failed to load withdrawal requests. Please try again.');
            } finally {
                hideLoading();
            }
        }
        
        // Update statistics
        function updateStatistics(stats) {
            document.getElementById('statPending').textContent = stats.pending_count || 0;
            document.getElementById('statCompleted').textContent = stats.completed_this_week || 0;
            document.getElementById('statAmount').textContent = `$${stats.total_pending_amount || 0}`;
            document.getElementById('statAvgTime').textContent = stats.avg_processing_time || 0;
            
            // Update text descriptions
            document.getElementById('statPendingText').textContent = stats.pending_count > 0 ? 'Awaiting review' : 'No pending requests';
            document.getElementById('statCompletedText').textContent = `This week`;
            document.getElementById('statAmountText').textContent = `In pending requests`;
            document.getElementById('statAvgTimeText').textContent = stats.avg_processing_time > 1 ? 'Days' : 'Day';
        }
        
        // Update financial summary
        function updateFinancialSummary(summary) {
            const container = document.getElementById('financialSummary');
            
            if (Object.keys(summary).length === 0) {
                container.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-chart-pie text-gray-300 text-2xl mb-2"></i>
                        <p class="text-gray-500">No financial data available</p>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = `
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Processed</span>
                        <span class="font-bold text-green-600">$${summary.total_processed || 0}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Pending Approval</span>
                        <span class="font-bold text-orange-500">$${summary.pending_amount || 0}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Cancelled</span>
                        <span class="font-bold text-red-600">$${summary.cancelled_amount || 0}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <span class="font-medium text-gray-800">Net Processed</span>
                        <span class="font-bold text-orchid-gold text-lg">$${summary.net_processed || 0}</span>
                    </div>
                </div>
            `;
        }
        
        // Update recent activity
        function updateRecentActivity(activities) {
            const container = document.getElementById('recentActivity');
            
            if (!activities || activities.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-history text-gray-300 text-2xl mb-2"></i>
                        <p class="text-gray-500">No recent activity</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            activities.forEach(activity => {
                const colors = {
                    completed: { bg: 'bg-green-50', border: 'border-green-100', icon: 'fa-check', iconColor: 'text-green-600' },
                    pending: { bg: 'bg-orange-50', border: 'border-orange-100', icon: 'fa-clock', iconColor: 'text-orange-500' },
                    processing: { bg: 'bg-blue-50', border: 'border-blue-100', icon: 'fa-sync-alt', iconColor: 'text-blue-600' },
                    cancelled: { bg: 'bg-red-50', border: 'border-red-100', icon: 'fa-times', iconColor: 'text-red-600' }
                };
                
                const color = colors[activity.status] || colors.pending;
                
                html += `
                    <div class="flex items-center justify-between p-3 rounded-lg ${color.bg} border ${color.border}">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full ${color.bg} flex items-center justify-center mr-3">
                                <i class="fas ${color.icon} ${color.iconColor}"></i>
                            </div>
                            <div>
                                <p class="font-medium">${activity.title}</p>
                                <p class="text-sm text-gray-500">${activity.description}</p>
                            </div>
                        </div>
                        <span class="text-sm text-gray-500">${activity.time_ago}</span>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }
        
        // Update progress
        function updateProgress(progress) {
            const percent = progress.percent || 0;
            const processed = progress.processed || 0;
            const total = progress.total || 0;
            
            document.getElementById('progressPercent').textContent = `${percent}%`;
            document.getElementById('progressBar').style.width = `${percent}%`;
            document.getElementById('progressText').textContent = `${processed} of ${total} requests processed`;
        }
        
        // Render withdrawals table
        function renderWithdrawals() {
            const tableBody = document.getElementById('withdrawalsTableBody');
            
            if (filteredWithdrawals.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="p-8 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-inbox text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-600">No withdrawal requests found</p>
                                <p class="text-sm text-gray-500">Try adjusting your filters or check back later</p>
                            </div>
                        </td>
                    </tr>
                `;
                
                updatePaginationInfo();
                return;
            }
            
            let tableHTML = '';
            filteredWithdrawals.forEach(withdrawal => {
                const isSelected = selectedWithdrawals.has(withdrawal.id);
                tableHTML += `
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="p-4">
                            <input type="checkbox" class="withdrawal-checkbox h-5 w-5 text-orchid-dark rounded border-gray-300" 
                                   ${isSelected ? 'checked' : ''}
                                   onchange="toggleWithdrawalSelection(${withdrawal.id}, this)">
                        </td>
                        <td class="p-4">
                            <p class="font-medium text-gray-800">${withdrawal.reference || `WR-${withdrawal.id.toString().padStart(4, '0')}`}</p>
                            <p class="text-xs text-gray-500">${withdrawal.description || 'No description'}</p>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                <div>
                                    <p class="font-medium">${withdrawal.user_name || 'Unknown User'}</p>
                                    <p class="text-xs text-gray-500">${withdrawal.user_email || 'No email'}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <p class="font-bold text-orchid-gold text-lg">$${parseFloat(withdrawal.amount).toFixed(2)}</p>
                        </td>
                        <td class="p-4">
                            <p class="text-gray-700">${formatDate(withdrawal.created_at)}</p>
                            ${withdrawal.processed_at ? `<p class="text-xs text-gray-500">Processed: ${formatDate(withdrawal.processed_at)}</p>` : ''}
                        </td>
                        <td class="p-4">
                            ${getStatusBadge(withdrawal.status)}
                        </td>
                        <td class="p-4">
                            <div class="flex space-x-2">
                                <button onclick="openProcessModal(${withdrawal.id})" class="w-8 h-8 rounded-lg ${withdrawal.status === 'pending' ? 'bg-green-100 text-green-600 hover:bg-green-200' : 'bg-blue-100 text-blue-600 hover:bg-blue-200'}" title="${withdrawal.status === 'pending' ? 'Review Request' : 'View Details'}">
                                    <i class="fas ${withdrawal.status === 'pending' ? 'fa-eye' : 'fa-info-circle'} text-sm"></i>
                                </button>
                                ${withdrawal.status === 'pending' ? `
                                <button onclick="quickAction(${withdrawal.id}, 'completed')" class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-200" title="Quick Approve">
                                    <i class="fas fa-check text-sm"></i>
                                </button>
                                <button onclick="quickAction(${withdrawal.id}, 'cancelled')" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-200" title="Quick Reject">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                                ` : ''}
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            tableBody.innerHTML = tableHTML;
            updatePaginationInfo();
        }
        
        // Update pagination information
        function updatePaginationInfo() {
            const totalRows = filteredWithdrawals.length;
            const startRow = totalRows > 0 ? 1 : 0;
            const endRow = totalRows;
            
            document.getElementById('startRow').textContent = startRow;
            document.getElementById('endRow').textContent = endRow;
            document.getElementById('totalRows').textContent = totalRows;
            document.getElementById('withdrawalCount').textContent = `Showing ${totalRows} request${totalRows !== 1 ? 's' : ''}`;
            
            // Update pagination buttons
            document.getElementById('prevPage').disabled = true;
            document.getElementById('nextPage').disabled = true;
            
            // Clear page numbers
            document.getElementById('pageNumbers').innerHTML = '';
        }
        
        // Format date
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        }
        
        // Get status badge
        function getStatusBadge(status) {
            const statusConfig = {
                pending: { color: 'orange', text: 'Pending', icon: 'fa-clock' },
                processing: { color: 'blue', text: 'Processing', icon: 'fa-sync-alt' },
                completed: { color: 'green', text: 'Completed', icon: 'fa-check-circle' },
                cancelled: { color: 'red', text: 'Cancelled', icon: 'fa-times-circle' }
            };
            
            const config = statusConfig[status] || { color: 'gray', text: 'Unknown', icon: 'fa-question' };
            return `
                <div class="flex items-center">
                    <span class="status-badge bg-${config.color}-100 text-${config.color}-800">
                        <i class="fas ${config.icon} mr-1"></i> ${config.text}
                    </span>
                </div>
            `;
        }
        
        // Modal functions
        async function openProcessModal(withdrawalId) {
            try {
                const withdrawal = allWithdrawals.find(w => w.id === withdrawalId);
                if (!withdrawal) {
                    showNotification('Withdrawal request not found', 'error');
                    return;
                }
                
                withdrawalToProcess = withdrawal;
                
                // Set modal content
                document.getElementById('processWithdrawalId').value = withdrawal.id;
                document.getElementById('processRequestId').textContent = withdrawal.reference || `WR-${withdrawal.id.toString().padStart(4, '0')}`;
                document.getElementById('processAmount').textContent = `$${parseFloat(withdrawal.amount).toFixed(2)}`;
                document.getElementById('processUserName').textContent = withdrawal.user_name || 'Unknown User';
                document.getElementById('processUserEmail').textContent = withdrawal.user_email || 'No email';
                document.getElementById('processDate').textContent = formatDate(withdrawal.created_at);
                
                // Show description if available
                const descContainer = document.getElementById('processDescription');
                const descText = document.getElementById('processDescText');
                if (withdrawal.description) {
                    descText.textContent = withdrawal.description;
                    descContainer.classList.remove('hidden');
                } else {
                    descContainer.classList.add('hidden');
                }
                
                // Set current status
                const statusBadge = document.getElementById('currentStatusBadge');
                statusBadge.textContent = withdrawal.status.charAt(0).toUpperCase() + withdrawal.status.slice(1);
                statusBadge.className = `status-badge ${getStatusColorClass(withdrawal.status)}`;
                
                // Set reference
                const referenceText = document.getElementById('referenceText');
                referenceText.textContent = withdrawal.reference || 'N/A';
                
                // Set status note
                const statusNote = document.getElementById('statusNote');
                statusNote.textContent = getStatusNote(withdrawal.status);
                
                // Reset form
                document.getElementById('processAction').value = '';
                document.getElementById('processReason').value = '';
                document.getElementById('rejectionReason').classList.add('hidden');
                
                // Update submit button text based on current status
                const submitText = document.getElementById('submitActionText');
                if (withdrawal.status === 'pending') {
                    submitText.textContent = 'Submit Action';
                } else {
                    submitText.textContent = 'Update Status';
                }
                
                document.getElementById('processModal').classList.add('active');
                
            } catch (error) {
                console.error('Error opening process modal:', error);
                showNotification('Failed to load withdrawal details', 'error');
            }
        }
        
        function closeProcessModal() {
            withdrawalToProcess = null;
            document.getElementById('processModal').classList.remove('active');
        }
        
        function toggleRejectionReason() {
            const action = document.getElementById('processAction').value;
            const rejectionReason = document.getElementById('rejectionReason');
            
            if (action === 'cancelled') {
                rejectionReason.classList.remove('hidden');
            } else {
                rejectionReason.classList.add('hidden');
            }
        }
        
        async function submitWithdrawalAction(event) {
            event.preventDefault();
            
            if (!withdrawalToProcess) return;
            
            const action = document.getElementById('processAction').value;
            const reason = document.getElementById('processReason').value;
            
            if (!action) {
                showNotification('Please select an action', 'warning');
                return;
            }
            
            if (action === 'cancelled' && !reason.trim()) {
                showNotification('Please provide a cancellation reason', 'warning');
                return;
            }
            
            try {
                // Show loading
                const submitBtn = document.getElementById('submitActionBtn');
                const submitText = document.getElementById('submitActionText');
                const submitLoading = document.getElementById('submitLoading');
                
                submitBtn.disabled = true;
                submitText.textContent = 'Processing...';
                submitLoading.classList.remove('hidden');
                
                // Prepare data
                const data = {
                    withdrawal_id: withdrawalToProcess.id,
                    action: action,
                    reason: action === 'cancelled' ? reason : null
                };
                
                // Send update request
                const response = await fetch('/api/update_withdrawal', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(`Withdrawal ${withdrawalToProcess.reference} updated successfully`, 'success');
                    
                    // Refresh data
                    await fetchWithdrawals();
                    closeProcessModal();
                } else {
                    throw new Error(result.error || 'Failed to update withdrawal');
                }
                
            } catch (error) {
                console.error('Error updating withdrawal:', error);
                showNotification(error.message || 'Failed to update withdrawal', 'error');
            } finally {
                // Reset button
                const submitBtn = document.getElementById('submitActionBtn');
                const submitText = document.getElementById('submitActionText');
                const submitLoading = document.getElementById('submitLoading');
                
                submitBtn.disabled = false;
                submitText.textContent = 'Submit Action';
                submitLoading.classList.add('hidden');
            }
        }
        
        // Quick action
        async function quickAction(withdrawalId, action) {
            if (!confirm(`Are you sure you want to ${action === 'completed' ? 'approve' : 'reject'} this withdrawal request?`)) {
                return;
            }
            
            try {
                const withdrawal = allWithdrawals.find(w => w.id === withdrawalId);
                if (!withdrawal) return;
                
                const data = {
                    withdrawal_id: withdrawalId,
                    action: action,
                    reason: action === 'cancelled' ? 'Quick rejection by admin' : null
                };
                
                const response = await fetch('/api/update_withdrawal', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    const actionText = action === 'completed' ? 'approved' : 'rejected';
                    showNotification(`Withdrawal ${withdrawal.reference} ${actionText} successfully`, 'success');
                    await fetchWithdrawals();
                } else {
                    throw new Error(result.error || 'Failed to update withdrawal');
                }
                
            } catch (error) {
                console.error('Error performing quick action:', error);
                showNotification(error.message || 'Failed to update withdrawal', 'error');
            }
        }
        
        // Bulk action functions
        function openBulkModal() {
            const count = selectedWithdrawals.size;
            if (count === 0) {
                showNotification('Please select at least one withdrawal', 'warning');
                return;
            }
            
            document.getElementById('selectedCount').textContent = count;
            document.getElementById('bulkAction').value = '';
            document.getElementById('bulkModal').classList.add('active');
        }
        
        function closeBulkModal() {
            document.getElementById('bulkModal').classList.remove('active');
        }
        
        async function processBulkAction() {
            const action = document.getElementById('bulkAction').value;
            if (!action) {
                showNotification('Please select an action', 'warning');
                return;
            }
            
            if (action === 'cancelled') {
                showNotification('Bulk cancellation requires individual review. Please process each cancellation separately.', 'warning');
                return;
            }
            
            try {
                // Show loading
                const bulkSubmitBtn = document.getElementById('bulkSubmitText');
                const bulkSubmitLoading = document.getElementById('bulkSubmitLoading');
                
                bulkSubmitBtn.textContent = 'Processing...';
                bulkSubmitLoading.classList.remove('hidden');
                
                const withdrawalIds = Array.from(selectedWithdrawals);
                
                const data = {
                    withdrawal_ids: withdrawalIds,
                    action: action
                };
                
                const response = await fetch('/api/bulk_update_withdrawals', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(`${withdrawalIds.length} withdrawal(s) updated successfully`, 'success');
                    
                    // Clear selection
                    selectedWithdrawals.clear();
                    document.getElementById('selectAll').checked = false;
                    updateBulkActionButton();
                    
                    // Refresh data
                    await fetchWithdrawals();
                    closeBulkModal();
                } else {
                    throw new Error(result.error || 'Failed to update withdrawals');
                }
                
            } catch (error) {
                console.error('Error processing bulk action:', error);
                showNotification(error.message || 'Failed to update withdrawals', 'error');
            } finally {
                // Reset button
                const bulkSubmitBtn = document.getElementById('bulkSubmitText');
                const bulkSubmitLoading = document.getElementById('bulkSubmitLoading');
                
                bulkSubmitBtn.textContent = 'Apply';
                bulkSubmitLoading.classList.add('hidden');
            }
        }
        
        // Selection functions
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll').checked;
            const checkboxes = document.querySelectorAll('.withdrawal-checkbox');
            
            if (selectAll) {
                // Select all visible withdrawals
                filteredWithdrawals.forEach(w => selectedWithdrawals.add(w.id));
                checkboxes.forEach(cb => cb.checked = true);
            } else {
                // Deselect all
                selectedWithdrawals.clear();
                checkboxes.forEach(cb => cb.checked = false);
            }
            
            updateBulkActionButton();
        }
        
        function toggleWithdrawalSelection(withdrawalId, checkbox) {
            if (checkbox.checked) {
                selectedWithdrawals.add(withdrawalId);
            } else {
                selectedWithdrawals.delete(withdrawalId);
                document.getElementById('selectAll').checked = false;
            }
            
            updateBulkActionButton();
        }
        
        function updateBulkActionButton() {
            const bulkBtn = document.getElementById('bulkActionBtn');
            if (selectedWithdrawals.size > 0) {
                bulkBtn.classList.remove('hidden');
                bulkBtn.innerHTML = `<i class="fas fa-tasks mr-2"></i> Bulk Action (${selectedWithdrawals.size})`;
            } else {
                bulkBtn.classList.add('hidden');
            }
        }
        
        // Filter and search functions
        function debouncedFilterWithdrawals() {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(filterWithdrawals, 500);
        }
        
        function filterWithdrawals() {
            // Reset to page 1 when filtering
            currentPage = 1;
            fetchWithdrawals();
        }
        
        // Pagination functions
        function changePageSize() {
            pageSize = parseInt(document.getElementById('pageSize').value);
            currentPage = 1;
            selectedWithdrawals.clear();
            document.getElementById('selectAll').checked = false;
            updateBulkActionButton();
            fetchWithdrawals();
        }
        
        function changePage(direction) {
            // Note: With API pagination, we need to fetch new data
            // For now, we'll just refetch with updated page
            // In a real implementation, the API would handle pagination
            currentPage += direction;
            if (currentPage < 1) currentPage = 1;
            fetchWithdrawals();
        }
        
        // Export function
        function exportWithdrawals() {
            // Build export URL with current filters
            const searchTerm = document.getElementById('searchWithdrawals').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;
            
            const params = new URLSearchParams({
                format: 'csv',
                search: searchTerm || '',
                status: statusFilter || '',
                date_filter: dateFilter || ''
            });
            
            const exportUrl = `/api/export_withdrawals?${params}`;
            
            // Create temporary link to trigger download
            const link = document.createElement('a');
            link.href = exportUrl;
            link.download = `withdrawals_${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        // Refresh function
        function refreshWithdrawals() {
            fetchWithdrawals();
        }
        
        // Update last updated timestamp
        function updateLastUpdated() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('lastUpdated').textContent = `Last updated: ${timeString}`;
        }
        
        // Loading states
        function showLoading() {
            isLoading = true;
            document.getElementById('loadingRow').style.display = 'table-row';
            document.getElementById('refreshBtn').classList.add('fa-spin');
        }
        
        function hideLoading() {
            isLoading = false;
            document.getElementById('loadingRow').style.display = 'none';
            document.getElementById('refreshBtn').classList.remove('fa-spin');
        }
        
        // Show error
        function showError(message) {
            const tableBody = document.getElementById('withdrawalsTableBody');
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="p-8 text-center">
                        <div class="flex flex-col items-center justify-center space-y-3">
                            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                            </div>
                            <p class="text-red-600">${message}</p>
                            <button onclick="fetchWithdrawals()" class="text-sm text-orchid-dark hover:text-orchid-gold">
                                <i class="fas fa-redo mr-1"></i>Try Again
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }
        
        // Helper functions
        function getStatusColorClass(status) {
            const colors = {
                pending: 'bg-orange-100 text-orange-800',
                processing: 'bg-blue-100 text-blue-800',
                completed: 'bg-green-100 text-green-800',
                cancelled: 'bg-red-100 text-red-800'
            };
            return colors[status] || 'bg-gray-100 text-gray-800';
        }
        
        function getStatusNote(status) {
            const notes = {
                pending: 'Awaiting review by admin',
                processing: 'Payment is being processed',
                completed: 'Payment has been sent successfully',
                cancelled: 'Request has been cancelled'
            };
            return notes[status] || 'Unknown status';
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
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch initial data
            fetchWithdrawals();
            
            // Handle window resize for sidebar
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    closeSidebar();
                }
            });
            
            // Close modals with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeProcessModal();
                    closeBulkModal();
                    closeSidebar();
                }
            });
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo$metaTags ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
        
        /* Activity log specific styles */
        .action-badge {
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 12px;
            font-weight: 600;
        }
        
        .log-details {
            max-width: 400px;
            word-wrap: break-word;
        }
        
        .filter-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 10;
            min-width: 200px;
        }
        
        .filter-dropdown.show {
            display: block;
        }
        
        .flatpickr-input {
            background-color: white;
        }
        
        .pagination-link {
            padding: 6px 12px;
            border: 1px solid #e5e7eb;
            color: #4b5563;
            cursor: pointer;
            user-select: none;
        }
        
        .pagination-link.active {
            background-color: #013220;
            color: white;
            border-color: #013220;
        }
        
        .pagination-link:hover:not(.active) {
            background-color: #f3f4f6;
        }
        
        .loading-row {
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" onclick="closeSidebar()"></div>
    
    <div class="flex h-screen">
        <!-- Sidebar -->
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
                        <h2 id="dashboardTitle" class="text-xl font-semibold text-gray-800">Activity Log</h2>
                        <p class="text-sm text-gray-500" id="lastUpdated">Loading...</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="refreshActivityLog()" class="p-2 rounded-lg border border-gray-300 hover:bg-gray-50" id="refreshBtn">
                        <i class="fas fa-sync-alt text-gray-600"></i>
                    </button>
                    <!--<button onclick="exportActivityLog()" class="px-4 py-2 text-sm font-medium rounded-lg btn-primary">
                        <i class="fas fa-download mr-2"></i>Export CSV
                    </button>-->
                </div>
            </header>
            
            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Filter & Search Section -->
                <div class="bg-white rounded-xl shadow p-5 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            <input type="text" id="searchInput" placeholder="Search activities..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark/20 focus:border-orchid-dark">
                        </div>
                        
                        <!-- Date Range -->
                        <div class="relative">
                            <i class="fas fa-calendar-alt absolute left-3 top-3 text-gray-400"></i>
                            <input type="text" id="dateRangePicker" placeholder="Select date range..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark/20 focus:border-orchid-dark">
                        </div>
                        
                        <!-- Action Type Filter -->
                        <div class="relative">
                            <button onclick="toggleFilterDropdown('actionFilter')" 
                                    class="w-full flex justify-between items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <span id="actionFilterText">All Actions</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            <div id="actionFilter" class="filter-dropdown mt-1 p-3">
                                <div class="space-y-2" id="actionFilterOptions">
                                    <!-- Action options will be populated by JavaScript -->
                                </div>
                                <div class="flex justify-between mt-3 pt-3 border-t">
                                    <button onclick="selectAllActions()" class="text-sm text-gray-600 hover:text-orchid-dark">Select All</button>
                                    <button onclick="applyFilters()" class="text-sm btn-primary px-3 py-1 rounded">Apply</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Admin Filter -->
                        <div class="relative">
                            <button onclick="toggleFilterDropdown('adminFilter')" 
                                    class="w-full flex justify-between items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <span id="adminFilterText">All Admins</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            <div id="adminFilter" class="filter-dropdown mt-1 p-3">
                                <div class="space-y-2" id="adminFilterOptions">
                                    <!-- Admin options will be populated by JavaScript -->
                                </div>
                                <div class="flex justify-between mt-3 pt-3 border-t">
                                    <button onclick="selectAllAdmins()" class="text-sm text-gray-600 hover:text-orchid-dark">Select All</button>
                                    <button onclick="applyFilters()" class="text-sm btn-primary px-3 py-1 rounded">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Activity Log Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Total Activities</p>
                                <p class="text-3xl font-bold mt-2" id="totalActivities">0</p>
                            </div>
                            <div class="p-3 rounded-full bg-orchid-dark/10">
                                <i class="fas fa-history text-orchid-dark text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Today's Activities</p>
                                <p class="text-3xl font-bold mt-2" id="todaysActivities">0</p>
                                <p class="text-xs text-gray-500 mt-1" id="currentDate"></p>
                            </div>
                            <div class="p-3 rounded-full bg-orchid-gold/10">
                                <i class="fas fa-calendar-day text-orchid-gold text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Most Active Admin</p>
                                <p class="text-lg font-bold mt-2" id="mostActiveAdmin">-</p>
                                <p class="text-xs text-gray-500 mt-1" id="mostActiveCount">Loading...</p>
                            </div>
                            <div class="p-3 rounded-full bg-orchid-dark/10">
                                <i class="fas fa-user-shield text-orchid-dark text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Most Common Action</p>
                                <p class="text-lg font-bold mt-2" id="mostCommonAction">-</p>
                                <p class="text-xs text-gray-500 mt-1" id="mostCommonPercentage">Loading...</p>
                            </div>
                            <div class="p-3 rounded-full bg-orchid-gold/10">
                                <i class="fas fa-tasks text-orchid-gold text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Activity Log Table -->
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800">Admin Activities</h3>
                        <div class="text-sm text-gray-500">
                            Showing <span id="showingCount">0-0</span> of <span id="totalCount">0</span> activities
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Timestamp</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Admin</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Action</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Details</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">IP Address</th>
                                </tr>
                            </thead>
                            <tbody id="activityLogTable">
                                <!-- Data will be populated by JavaScript -->
                                <tr id="loadingRow">
                                    <td colspan="5" class="p-8 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <div class="w-12 h-12 rounded-full bg-orchid-dark/10 flex items-center justify-center">
                                                <i class="fas fa-spinner fa-spin text-orchid-dark text-xl"></i>
                                            </div>
                                            <p class="text-gray-600">Loading activity logs...</p>
                                            <p class="text-sm text-gray-500">Fetching data from server</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="p-5 border-t border-gray-100 flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            Page <span id="currentPage">1</span> of <span id="totalPages">1</span>
                        </div>
                        <div class="flex space-x-1" id="paginationContainer">
                            <!-- Pagination will be generated by JavaScript -->
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">Show</span>
                            <select id="itemsPerPage" class="border border-gray-300 rounded-lg px-3 py-1 text-sm" onchange="changeItemsPerPage()">
                                <option value="10">10</option>
                                <option value="25" selected>25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span class="text-sm text-gray-500">entries</span>
                        </div>
                    </div>
                </div>
                
                <!-- Activity Insights -->
                <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Activity by Action Type -->
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="p-5 border-b border-gray-100">
                            <h3 class="font-bold text-gray-800">Activity by Action Type</h3>
                        </div>
                        <div class="p-5 space-y-4" id="actionDistribution">
                            <!-- Will be populated by JavaScript -->
                            <div class="text-center py-8">
                                <i class="fas fa-chart-pie text-gray-300 text-3xl mb-3"></i>
                                <p class="text-gray-500">Loading distribution data...</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Admins Activity -->
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="p-5 border-b border-gray-100">
                            <h3 class="font-bold text-gray-800">Recent Admins Activity</h3>
                        </div>
                        <div class="p-5 space-y-4" id="recentAdmins">
                            <!-- Will be populated by JavaScript -->
                            <div class="text-center py-8">
                                <i class="fas fa-users text-gray-300 text-3xl mb-3"></i>
                                <p class="text-gray-500">Loading admin data...</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Peak Activity Hours -->
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="p-5 border-b border-gray-100">
                            <h3 class="font-bold text-gray-800">Peak Activity Hours</h3>
                        </div>
                        <div class="p-5" id="peakHours">
                            <!-- Will be populated by JavaScript -->
                            <div class="text-center py-8">
                                <i class="fas fa-chart-bar text-gray-300 text-3xl mb-3"></i>
                                <p class="text-gray-500">Loading peak hours data...</p>
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

    <!-- Activity Details Modal -->
    <div id="activityModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-lg w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800">Activity Details</h3>
                <button onclick="closeActivityModal()" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div id="modalContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end">
                <button onclick="closeActivityModal()" class="px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 hover:bg-gray-50">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentPage = 1;
        let itemsPerPage = 25;
        let totalActivities = 0;
        let allActivities = [];
        let filteredActivities = [];
        let currentFilters = {
            search: '',
            dateRange: null,
            actions: [],
            admins: []
        };
        
        // Define action types with display names and colors
        const actionTypes = {
            'create_partner': { 
                name: 'Create Partner', 
                color: 'bg-purple-100 text-purple-800',
                icon: 'fa-store'
            },
            'create_admin': { 
                name: 'Create Admin', 
                color: 'bg-blue-100 text-blue-800',
                icon: 'fa-user-shield'
            },
            'balance_adjustment': { 
                name: 'Balance Adjustment', 
                color: 'bg-yellow-100 text-yellow-800',
                icon: 'fa-coins'
            },
            'update_account_status': { 
                name: 'Update Account Status', 
                color: 'bg-green-100 text-green-800',
                icon: 'fa-user-check'
            },
            'update_user': { 
                name: 'Update User', 
                color: 'bg-indigo-100 text-indigo-800',
                icon: 'fa-user-edit'
            },
            'update_point_configuration': { 
                name: 'Update Point Configuration', 
                color: 'bg-pink-100 text-pink-800',
                icon: 'fa-cog'
            }
        };
        
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
            document.querySelectorAll('.sidebar-link').forEach(l => {
                l.classList.remove('bg-orchid-gold/10');
            });
            
            if (!link.querySelector('.fa-sign-out-alt')) {
                link.classList.add('bg-orchid-gold/10');
                
            }
            
            if (window.innerWidth < 768) {
                closeSidebar();
            }
        }
        
        // Fetch activity logs from API
        async function fetchActivityLogs() {
            try {
                showLoading();
                
                // Build query parameters
                const params = new URLSearchParams({
                    page: currentPage,
                    limit: itemsPerPage,
                    search: currentFilters.search,
                    actions: currentFilters.actions.join(','),
                    admins: currentFilters.admins.join(','),
                    date_from: currentFilters.dateRange ? currentFilters.dateRange[0] : '',
                    date_to: currentFilters.dateRange ? currentFilters.dateRange[1] : ''
                });
                
                const response = await fetch('fetch_activity_logs', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body : params
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                // Store activities and update UI
                allActivities = data.activities || [];
                totalActivities = data.total || 0;
                
                updateActivityTable();
                updateStats(data.stats || {});
                updateFilters(data.filters || {});
                updatePagination();
                updateInsights(data.insights || {});
                
                updateLastUpdated();
                
            } catch (error) {
                console.error('Error fetching activity logs:', error);
                showError('Failed to load activity logs. Please try again.');
            } finally {
                hideLoading();
            }
        }
        
        // Update activity table with fetched data
        function updateActivityTable() {
            const tableBody = document.getElementById('activityLogTable');
            
            if (allActivities.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="p-8 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-inbox text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-600">No activities found</p>
                                <p class="text-sm text-gray-500">Try adjusting your filters or check back later</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }
            
            let tableHTML = '';
            
            allActivities.forEach(activity => {
                const actionType = actionTypes[activity.action] || { 
                    name: activity.action, 
                    color: 'bg-gray-100 text-gray-800',
                    icon: 'fa-info-circle'
                };
                
                const formattedDate = new Date(activity.created_at).toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });
                
                const formattedTime = new Date(activity.created_at).toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                tableHTML += `
                    <tr class="border-b border-gray-100 hover:bg-gray-50" 
                        data-action="${activity.action}"
                        data-admin="${activity.admin_id}">
                        <td class="p-4">
                            <div class="text-sm font-medium text-gray-900">${formattedDate}</div>
                            <div class="text-xs text-gray-500">${formattedTime}</div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-orchid-dark/10 flex items-center justify-center mr-3">
                                    <i class="fas fa-user-shield text-orchid-dark text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium">${activity.admin_name || `Admin ${activity.admin_id}`}</p>
                                    <p class="text-xs text-gray-500">ID: ${activity.admin_id}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="action-badge ${actionType.color}">
                                <i class="fas ${actionType.icon} mr-1"></i>
                                ${actionType.name}
                            </span>
                        </td>
                        <td class="p-4 log-details">
                            <p class="text-sm">${activity.details || 'No details available'}</p>
                        </td>
                        <td class="p-4">
                            <button onclick="showActivityDetails(${activity.id})" 
                                    class="text-xs text-orchid-dark hover:text-orchid-gold mt-1">
                                <i class="fas fa-info-circle mr-1"></i>Details
                            </button>
                        </td>
                    </tr>
                `;
            });
            
            tableBody.innerHTML = tableHTML;
        }
        
        // Update statistics
        function updateStats(stats) {
            document.getElementById('totalActivities').textContent = stats.total || 0;
            document.getElementById('todaysActivities').textContent = stats.today || 0;
            document.getElementById('mostActiveAdmin').textContent = stats.most_active_admin?.name || '-';
            document.getElementById('mostActiveCount').textContent = stats.most_active_admin?.count ? 
                `${stats.most_active_admin.count} activities` : 'Loading...';
            document.getElementById('mostCommonAction').textContent = stats.most_common_action?.name || '-';
            document.getElementById('mostCommonPercentage').textContent = stats.most_common_action?.percentage ? 
                `${stats.most_common_action.percentage}% of all activities` : 'Loading...';
            
            // Update showing count
            const start = ((currentPage - 1) * itemsPerPage) + 1;
            const end = Math.min(currentPage * itemsPerPage, totalActivities);
            document.getElementById('showingCount').textContent = `${start}-${end}`;
            document.getElementById('totalCount').textContent = totalActivities;
        }
        
        // Update filter options
        function updateFilters(filters) {
            // Update action filter options
            const actionOptionsContainer = document.getElementById('actionFilterOptions');
            let actionOptionsHTML = '<div class="space-y-2">';
            
            actionOptionsHTML += `
                <label class="flex items-center">
                    <input type="checkbox" value="all" class="mr-2 rounded text-orchid-dark focus:ring-orchid-dark" 
                           onchange="toggleAllActions(this)" ${currentFilters.actions.length === 0 ? 'checked' : ''}>
                    <span class="text-sm">All Actions</span>
                </label>
            `;
            
            Object.keys(actionTypes).forEach(action => {
                const isChecked = currentFilters.actions.includes(action) || currentFilters.actions.length === 0;
                actionOptionsHTML += `
                    <label class="flex items-center">
                        <input type="checkbox" value="${action}" class="mr-2 rounded text-orchid-dark focus:ring-orchid-dark"
                               onchange="updateActionFilter()" ${isChecked ? 'checked' : ''}>
                        <span class="text-sm">${actionTypes[action].name}</span>
                    </label>
                `;
            });
            
            actionOptionsHTML += '</div>';
            actionOptionsContainer.innerHTML = actionOptionsHTML;
            
            // Update selected actions text
            updateActionFilterText();
            
            // Update admin filter options
            const adminOptionsContainer = document.getElementById('adminFilterOptions');
            let adminOptionsHTML = '<div class="space-y-2">';
            
            adminOptionsHTML += `
                <label class="flex items-center">
                    <input type="checkbox" value="all" class="mr-2 rounded text-orchid-dark focus:ring-orchid-dark"
                           onchange="toggleAllAdmins(this)" ${currentFilters.admins.length === 0 ? 'checked' : ''}>
                    <span class="text-sm">All Admins</span>
                </label>
            `;
            
            if (filters.admins && filters.admins.length > 0) {
                filters.admins.forEach(admin => {
                    const isChecked = currentFilters.admins.includes(admin.id.toString()) || currentFilters.admins.length === 0;
                    adminOptionsHTML += `
                        <label class="flex items-center">
                            <input type="checkbox" value="${admin.id}" class="mr-2 rounded text-orchid-dark focus:ring-orchid-dark"
                                   onchange="updateAdminFilter()" ${isChecked ? 'checked' : ''}>
                            <span class="text-sm">${admin.name}</span>
                        </label>
                    `;
                });
            }
            
            adminOptionsHTML += '</div>';
            adminOptionsContainer.innerHTML = adminOptionsHTML;
            
            // Update selected admins text
            updateAdminFilterText();
        }
        
        // Update action filter text
        function updateActionFilterText() {
            const checkboxes = document.querySelectorAll('#actionFilterOptions input[type="checkbox"]:checked');
            const allCheckbox = document.querySelector('#actionFilterOptions input[value="all"]');
            
            if (allCheckbox && allCheckbox.checked) {
                document.getElementById('actionFilterText').textContent = 'All Actions';
            } else {
                const selectedCount = checkboxes.length - (allCheckbox && allCheckbox.checked ? 1 : 0);
                document.getElementById('actionFilterText').textContent = 
                    selectedCount > 0 ? `${selectedCount} selected` : 'Select Actions';
            }
        }
        
        // Update admin filter text
        function updateAdminFilterText() {
            const checkboxes = document.querySelectorAll('#adminFilterOptions input[type="checkbox"]:checked');
            const allCheckbox = document.querySelector('#adminFilterOptions input[value="all"]');
            
            if (allCheckbox && allCheckbox.checked) {
                document.getElementById('adminFilterText').textContent = 'All Admins';
            } else {
                const selectedCount = checkboxes.length - (allCheckbox && allCheckbox.checked ? 1 : 0);
                document.getElementById('adminFilterText').textContent = 
                    selectedCount > 0 ? `${selectedCount} selected` : 'Select Admins';
            }
        }
        
        // Toggle all actions
        function toggleAllActions(checkbox) {
            const actionCheckboxes = document.querySelectorAll('#actionFilterOptions input[type="checkbox"]');
            actionCheckboxes.forEach(cb => {
                cb.checked = checkbox.checked;
            });
            updateActionFilter();
        }
        
        // Toggle all admins
        function toggleAllAdmins(checkbox) {
            const adminCheckboxes = document.querySelectorAll('#adminFilterOptions input[type="checkbox"]');
            adminCheckboxes.forEach(cb => {
                cb.checked = checkbox.checked;
            });
            updateAdminFilter();
        }
        
        // Select all actions
        function selectAllActions() {
            const allCheckbox = document.querySelector('#actionFilterOptions input[value="all"]');
            allCheckbox.checked = true;
            toggleAllActions(allCheckbox);
        }
        
        // Select all admins
        function selectAllAdmins() {
            const allCheckbox = document.querySelector('#adminFilterOptions input[value="all"]');
            allCheckbox.checked = true;
            toggleAllAdmins(allCheckbox);
        }
        
        // Update action filter
        function updateActionFilter() {
            const checkboxes = document.querySelectorAll('#actionFilterOptions input[type="checkbox"]');
            const allCheckbox = document.querySelector('#actionFilterOptions input[value="all"]');
            
            if (allCheckbox.checked) {
                currentFilters.actions = [];
            } else {
                currentFilters.actions = Array.from(checkboxes)
                    .filter(cb => cb.checked && cb.value !== 'all')
                    .map(cb => cb.value);
            }
            
            updateActionFilterText();
        }
        
        // Update admin filter
        function updateAdminFilter() {
            const checkboxes = document.querySelectorAll('#adminFilterOptions input[type="checkbox"]');
            const allCheckbox = document.querySelector('#adminFilterOptions input[value="all"]');
            
            if (allCheckbox.checked) {
                currentFilters.admins = [];
            } else {
                currentFilters.admins = Array.from(checkboxes)
                    .filter(cb => cb.checked && cb.value !== 'all')
                    .map(cb => cb.value);
            }
            
            updateAdminFilterText();
        }
        
        // Update pagination
        function updatePagination() {
            const totalPages = Math.ceil(totalActivities / itemsPerPage);
            const paginationContainer = document.getElementById('paginationContainer');
            
            document.getElementById('currentPage').textContent = currentPage;
            document.getElementById('totalPages').textContent = totalPages;
            
            let paginationHTML = '';
            
            // Previous button
            paginationHTML += `
                <button onclick="changePage(${currentPage - 1})" 
                        class="pagination-link rounded-l-lg ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}"
                        ${currentPage === 1 ? 'disabled' : ''}>
                    <i class="fas fa-chevron-left"></i>
                </button>
            `;
            
            // Page numbers
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
            
            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }
            
            for (let i = startPage; i <= endPage; i++) {
                paginationHTML += `
                    <button onclick="changePage(${i})" 
                            class="pagination-link ${i === currentPage ? 'active' : ''}">
                        ${i}
                    </button>
                `;
            }
            
            // Next button
            paginationHTML += `
                <button onclick="changePage(${currentPage + 1})" 
                        class="pagination-link rounded-r-lg ${currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : ''}"
                        ${currentPage === totalPages ? 'disabled' : ''}>
                    <i class="fas fa-chevron-right"></i>
                </button>
            `;
            
            paginationContainer.innerHTML = paginationHTML;
        }
        
        // Update insights
        function updateInsights(insights) {
            // Update action distribution
            const actionDistributionContainer = document.getElementById('actionDistribution');
            if (insights.action_distribution) {
                let distributionHTML = '';
                
                Object.entries(insights.action_distribution).forEach(([action, percentage]) => {
                    const actionType = actionTypes[action] || { name: action, color: 'bg-gray-500' };
                    distributionHTML += `
                        <div class="flex justify-between items-center">
                            <span class="font-medium">${actionType.name}</span>
                            <div class="flex items-center">
                                <div class="w-32 h-2 bg-gray-200 rounded-full mr-3">
                                    <div class="h-full ${actionType.color.split(' ')[0]} rounded-full" style="width: ${percentage}%"></div>
                                </div>
                                <span class="text-sm font-medium">${percentage}%</span>
                            </div>
                        </div>
                    `;
                });
                
                actionDistributionContainer.innerHTML = distributionHTML;
            }
            
            // Update recent admins
            const recentAdminsContainer = document.getElementById('recentAdmins');
            if (insights.recent_admins) {
                let adminsHTML = '';
                
                insights.recent_admins.forEach(admin => {
                    adminsHTML += `
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-orchid-dark/10 flex items-center justify-center mr-3">
                                    <i class="fas fa-user-shield text-orchid-dark"></i>
                                </div>
                                <div>
                                    <p class="font-medium">${admin.name}</p>
                                    <p class="text-xs text-gray-500">${admin.activity_count} activities today</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 rounded-full text-xs ${admin.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                                    ${admin.status === 'active' ? 'Online' : 'Offline'}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">${admin.last_activity || 'No recent activity'}</p>
                            </div>
                        </div>
                    `;
                });
                
                recentAdminsContainer.innerHTML = adminsHTML;
            }
            
            // Update peak hours
            const peakHoursContainer = document.getElementById('peakHours');
            if (insights.peak_hours) {
                let peakHoursHTML = '<div class="space-y-3">';
                
                insights.peak_hours.forEach(hourData => {
                    const width = (hourData.activity_count / 100) * 100; // Assuming max 100 activities per hour for scaling
                    peakHoursHTML += `
                        <div class="flex items-center">
                            <span class="text-sm font-medium w-16">${hourData.hour}</span>
                            <div class="flex-1 h-4 bg-gray-200 rounded-full mx-3 relative">
                                <div class="h-full bg-orchid-gold rounded-full" style="width: ${width}%"></div>
                                <div class="absolute right-0 top-full mt-1 text-xs text-gray-500">
                                    ${hourData.activity_count} activities
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                peakHoursHTML += '</div>';
                peakHoursContainer.innerHTML = peakHoursHTML;
            }
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
        
        // Show loading state
        function showLoading() {
            //document.getElementById('loadingRow').style.display = 'table-row';
            document.getElementById('refreshBtn').classList.add('fa-spin');
        }
        
        // Hide loading state
        function hideLoading() {
            //document.getElementById('loadingRow').style.display = 'none';
            document.getElementById('refreshBtn').classList.remove('fa-spin');
        }
        
        // Show error message
        function showError(message) {
            const tableBody = document.getElementById('activityLogTable');
            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="p-8 text-center">
                        <div class="flex flex-col items-center justify-center space-y-3">
                            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                            </div>
                            <p class="text-red-600">${message}</p>
                            <button onclick="fetchActivityLogs()" class="text-sm text-orchid-dark hover:text-orchid-gold">
                                <i class="fas fa-redo mr-1"></i>Try Again
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }
        
        // Filter dropdown functionality
        function toggleFilterDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('show');
            
            // Close other dropdowns
            document.querySelectorAll('.filter-dropdown').forEach(d => {
                if (d.id !== id) {
                    d.classList.remove('show');
                }
            });
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                document.querySelectorAll('.filter-dropdown').forEach(d => {
                    d.classList.remove('show');
                });
            }
        });
        
        // Initialize date range picker
        let datePicker;
        document.addEventListener('DOMContentLoaded', function() {
            datePicker = flatpickr("#dateRangePicker", {
                mode: "range",
                dateFormat: "Y-m-d",
                maxDate: "today",
                onChange: function(selectedDates, dateStr, instance) {
                    currentFilters.dateRange = selectedDates;
                    applyFilters();
                }
            });
        });
        
        // Apply filters
        function applyFilters() {
            currentPage = 1; // Reset to first page when filters change
            fetchActivityLogs();
            
            // Close dropdowns
            document.querySelectorAll('.filter-dropdown').forEach(d => {
                d.classList.remove('show');
            });
        }
        
        // Clear all filters
        function clearFilters() {
            currentFilters = {
                search: '',
                dateRange: null,
                actions: [],
                admins: []
            };
            
            document.getElementById('searchInput').value = '';
            if (datePicker) {
                datePicker.clear();
            }
            
            selectAllActions();
            selectAllAdmins();
            
            applyFilters();
        }
        
        // Refresh activity log
        function refreshActivityLog() {
            fetchActivityLogs();
        }
        
        // Change page
        function changePage(page) {
            if (page < 1 || page > Math.ceil(totalActivities / itemsPerPage)) {
                return;
            }
            
            currentPage = page;
            fetchActivityLogs();
        }
        
        // Change items per page
        function changeItemsPerPage() {
            itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
            currentPage = 1; // Reset to first page
            fetchActivityLogs();
        }
        
        // Export activity log
        function exportActivityLog() {
            // Build export URL with current filters
            const params = new URLSearchParams({
                format: 'csv',
                search: currentFilters.search,
                actions: currentFilters.actions.join(','),
                admins: currentFilters.admins.join(','),
                date_from: currentFilters.dateRange ? currentFilters.dateRange[0].toISOString().split('T')[0] : '',
                date_to: currentFilters.dateRange ? currentFilters.dateRange[1].toISOString().split('T')[0] : ''
            });
            
            const exportUrl = `/api/export_activity_log?${params}`;
            
            // Create temporary link to trigger download
            const link = document.createElement('a');
            link.href = exportUrl;
            link.download = `activity_log_${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        // Show activity details modal
        function showActivityDetails(id) {
            // Find activity by ID
            const activity = allActivities.find(a => a.id === id);
            
            if (!activity) {
                alert('Activity not found');
                return;
            }
            
            const actionType = actionTypes[activity.action] || { name: activity.action, color: 'bg-gray-100 text-gray-800' };
            const formattedDate = new Date(activity.created_at).toLocaleString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            const modalContent = document.getElementById('modalContent');
            modalContent.innerHTML = `
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Activity ID</h4>
                        <p class="text-lg font-bold text-gray-800">ACT-${activity.id}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Timestamp</h4>
                        <p class="text-gray-800">${formattedDate}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Admin</h4>
                        <p class="text-gray-800">${activity.admin_name || `Admin ${activity.admin_id}`}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Action Type</h4>
                        <span class="px-3 py-1 rounded-full text-sm ${actionType.color}">
                            <i class="fas ${actionType.icon || 'fa-info-circle'} mr-1"></i>
                            ${actionType.name}
                        </span>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Details</h4>
                        <p class="text-gray-800 bg-gray-50 p-3 rounded-lg">
                            ${activity.details || 'No details available'}
                        </p>
                    </div>
                </div>
            `;
            
            document.getElementById('activityModal').classList.remove('hidden');
            document.getElementById('activityModal').classList.add('flex');
        }
        
        // Close activity modal
        function closeActivityModal() {
            document.getElementById('activityModal').classList.add('hidden');
            document.getElementById('activityModal').classList.remove('flex');
        }
        
        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Set up search input
            const searchInput = document.getElementById('searchInput');
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    currentFilters.search = this.value;
                    applyFilters();
                }, 500);
            });
            
            // Set active page in sidebar
            const activityLink = document.querySelector('[href*="activity-log"]');
            if (activityLink) {
                setActiveLink(activityLink.closest('.sidebar-link'));
            }
            
            // Set current date
            const currentDateElement = document.getElementById('currentDate');
            if (currentDateElement) {
                const today = new Date();
                currentDateElement.textContent = today.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });
            }
            
            // Close sidebar with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeSidebar();
                    closeActivityModal();
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    closeSidebar();
                }
            });
            
            // Initial data fetch
            fetchActivityLogs();
        });
    </script>
</body>
</html>
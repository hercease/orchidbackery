<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $metaTags; ?>
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

        /* Table styles */
        .table-container {
            max-width: 100%;
            overflow-x: auto;
        }

        .table-responsive {
            min-width: 1000px;
        }

        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-inactive {
            background-color: #f3f4f6;
            color: #374151;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-suspended {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .account-customer {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .account-partner {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        .account-admin {
            background-color: #f3e8ff;
            color: #5b21b6;
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
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background-color: white;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Loading spinner */
        .loading-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Pagination styles */
        .pagination-item.active {
            background-color: #013220;
            color: white;
        }

        .pagination-item:hover:not(.disabled) {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" onclick="closeSidebar()"></div>
    
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '../../includes/admin_sidebar.php'; ?>
        
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
                        <h2 id="dashboardTitle" class="text-xl font-semibold text-gray-800">Users Management</h2>
                        <p class="text-sm text-gray-500">Manage all registered users</p>
                    </div>
                </div>
                <!--<div class="flex items-center space-x-4">
                    <button onclick="exportUsers()" class="px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 hover:bg-gray-50">
                        <i class="fas fa-download mr-2"></i>Export CSV
                    </button>
                    <button onclick="openAddUserModal()" class="px-4 py-2 text-sm font-medium rounded-lg btn-primary">
                        <i class="fas fa-user-plus mr-2"></i>Add User
                    </button>
                </div>-->
            </header>
            
            <!-- Users Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Filters Section -->
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <div class="relative">
                                <input type="text" 
                                       id="searchInput" 
                                       placeholder="Search by name, email, or phone..."
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent"
                                       onkeyup="handleSearch(event)">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Filter -->
                        <div>
                            <select id="statusFilter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent" onchange="loadUsers()">
                                <option value="all">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Advanced Filters (Collapsible) -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <button onclick="toggleAdvancedFilters()" class="text-sm text-orchid-dark font-medium flex items-center">
                            <i class="fas fa-filter mr-2"></i>
                            <span id="advancedFiltersText">Show Advanced Filters</span>
                            <i class="fas fa-chevron-down ml-2 text-xs" id="advancedFiltersIcon"></i>
                        </button>
                        
                        <div id="advancedFilters" class="hidden mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Date Range -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Registration Date</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="date" id="dateFrom" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" onchange="loadUsers()">
                                    <input type="date" id="dateTo" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" onchange="loadUsers()">
                                </div>
                            </div>
                            
                            <!-- Sort By -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                                <select id="sortBy" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" onchange="loadUsers()">
                                    <option value="created_at:desc">Newest First</option>
                                    <option value="created_at:asc">Oldest First</option>
                                    <option value="first_name:asc">Name A-Z</option>
                                    <option value="first_name:desc">Name Z-A</option>
                                    <option value="points_balance:desc">Highest Points</option>
                                    <option value="points_balance:asc">Lowest Points</option>
                                </select>
                            </div>
                            
                            <!-- Results Per Page -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Results Per Page</label>
                                <select id="perPage" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" onchange="loadUsers()">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Users Table -->
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-gray-800">Registered Users</h3>
                            <p id="resultsInfo" class="text-sm text-gray-500 mt-1">Loading...</p>
                        </div>
                        <!--<div class="flex items-center space-x-2">
                            <select id="bulkActions" class="px-3 py-2 border border-gray-300 rounded-lg text-sm" onchange="handleBulkAction(this)">
                                <option value="">Bulk Actions</option>
                                <option value="activate">Activate Selected</option>
                                <option value="deactivate">Deactivate Selected</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                            <button onclick="applyBulkAction()" class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
                                Apply
                            </button>
                        </div>-->
                    </div>
                    
                    <div class="table-container">
                        <table class="w-full table-responsive">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">
                                        <input type="checkbox" id="selectAll" class="rounded border-gray-300" onchange="toggleSelectAll(this)">
                                    </th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">User</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Account Type</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Points Balance</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Status</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Registered</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                <!-- Users will be loaded here -->
                                <tr>
                                    <td colspan="7" class="p-8 text-center">
                                        <div class="inline-block loading-spinner rounded-full h-8 w-8 border-t-2 border-b-2 border-orchid-dark"></div>
                                        <p class="mt-2 text-gray-600">Loading users...</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div id="paginationContainer" class="p-5 border-t border-gray-100">
                        <!-- Pagination will be loaded here -->
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

    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Edit User</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="editUserForm" onsubmit="updateUser(event)">
                    <input type="hidden" id="editUserId">
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                <input type="text" id="editFirstName" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                <input type="text" id="editLastName" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" id="editEmail" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="tel" id="editPhone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                        </div>
                        
                        <!--<div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Account Type *</label>
                                <select id="editAccountType" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                                    <option value="customer">Customer</option>
                                    <option value="partner">Partner</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                                <select id="editStatus" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="pending">Pending</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Points Balance</label>
                            <input type="number" id="editPointsBalance" min="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                        </div>-->
                        
                        <!-- Password Reset (optional)
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-sm font-medium text-gray-700">Reset Password</label>
                                <button type="button" onclick="togglePasswordReset()" class="text-sm text-orchid-dark font-medium">
                                    <i class="fas fa-key mr-1"></i>
                                    Reset Password
                                </button>
                            </div>
                            <div id="passwordResetFields" class="hidden space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                    <input type="password" id="editPassword" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                                    <input type="password" id="editPasswordConfirm" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                                </div>
                            </div>
                        </div>-->
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" onclick="closeEditModal()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 bg-orchid-dark text-white rounded-lg font-medium hover:bg-orchid-dark/90">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content max-w-md">
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Delete User</h3>
                <p class="text-gray-600 mb-6" id="deleteMessage">Are you sure you want to delete this user? This action cannot be undone.</p>
                
                <div class="flex justify-center space-x-3">
                    <button onclick="closeDeleteModal()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
                        Cancel
                    </button>
                    <button onclick="confirmDelete()" class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>
                        Delete User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Add New User</h3>
                    <button onclick="closeAddUserModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="addUserForm" onsubmit="createUser(event)">
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                <input type="text" id="addFirstName" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                <input type="text" id="addLastName" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" id="addEmail" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="tel" id="addPhone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Account Type *</label>
                                <select id="addAccountType" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                                    <option value="customer">Customer</option>
                                    <option value="partner">Partner</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                                <select id="addStatus" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                                <input type="password" id="addPassword" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                                <input type="password" id="addPasswordConfirm" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Initial Points Balance</label>
                            <input type="number" id="addPointsBalance" min="0" value="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" onclick="closeAddUserModal()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 bg-orchid-dark text-white rounded-lg font-medium hover:bg-orchid-dark/90">
                            <i class="fas fa-user-plus mr-2"></i>
                            Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // State management
        let currentPage = 1;
        let selectedUsers = new Set();
        let userToDelete = null;
        let bulkAction = '';
        let searchTimeout = null;
        
        // DOM Elements
        const usersTableBody = document.getElementById('usersTableBody');
        const paginationContainer = document.getElementById('paginationContainer');
        const resultsInfo = document.getElementById('resultsInfo');
        const editUserModal = document.getElementById('editUserModal');
        const deleteModal = document.getElementById('deleteModal');
        const addUserModal = document.getElementById('addUserModal');
        const selectAllCheckbox = document.getElementById('selectAll');

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadUsers();
            updateDateTime();
            setInterval(updateDateTime, 60000);
        });

        // Sidebar functionality
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.add('active');
        }
        
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('active');
        }

        // Update date and time
        function updateDateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateString = now.toLocaleDateString('en-US', options);
            const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
            
            if (document.getElementById('currentDate')) {
                document.getElementById('currentDate').textContent = dateString;
            }
            if (document.getElementById('currentTime')) {
                document.getElementById('currentTime').textContent = timeString;
            }
        }

        // Toggle advanced filters
        function toggleAdvancedFilters() {
            const filters = document.getElementById('advancedFilters');
            const text = document.getElementById('advancedFiltersText');
            const icon = document.getElementById('advancedFiltersIcon');
            
            if (filters.classList.contains('hidden')) {
                filters.classList.remove('hidden');
                text.textContent = 'Hide Advanced Filters';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                filters.classList.add('hidden');
                text.textContent = 'Show Advanced Filters';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }

        // Handle search with debounce
        function handleSearch(event) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentPage = 1;
                loadUsers();
            }, 500);
        }

        // Load users function
        function loadUsers() {
            const search = document.getElementById('searchInput').value;
            //const accountType = document.getElementById('accountTypeFilter').value;
            const status = document.getElementById('statusFilter').value;
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;
            const sortBy = document.getElementById('sortBy').value;
            const perPage = document.getElementById('perPage').value;
            
            // Show loading state
            usersTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="p-8 text-center">
                        <div class="inline-block loading-spinner rounded-full h-8 w-8 border-t-2 border-b-2 border-orchid-dark"></div>
                        <p class="mt-2 text-gray-600">Loading users...</p>
                    </td>
                </tr>
            `;
            
            // Prepare request data
            const formData = new FormData();
            formData.append('page', currentPage);
            formData.append('per_page', perPage);
            formData.append('search', search);
            formData.append('acct_type', 'user');
            formData.append('status', status);
            formData.append('date_from', dateFrom);
            formData.append('date_to', dateTo);
            formData.append('sort_by', sortBy.split(':')[0]);
            formData.append('sort_order', sortBy.split(':')[1] || 'desc');
            
            // Send AJAX request
            fetch('fetchallusers', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    renderUsersTable(data.users);
                    renderPagination(data.pagination);
                    renderResultsInfo(data.pagination, data.filters);
                    selectedUsers.clear();
                    selectAllCheckbox.checked = false;
                } else {
                    showError('Failed to load users: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Network error occurred while loading users');
            });
        }

        // Render users table
        function renderUsersTable(users) {
            if (users.length === 0) {
                usersTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="p-8 text-center">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-users text-gray-400 text-xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-2">No Users Found</h4>
                            <p class="text-gray-500 mb-4">Try adjusting your search or filter criteria</p>
                            <button onclick="resetFilters()" class="px-4 py-2 text-orchid-dark border border-orchid-dark rounded-lg hover:bg-orchid-dark/5">
                                <i class="fas fa-redo mr-2"></i>Reset Filters
                            </button>
                        </td>
                    </tr>
                `;
                return;
            }
            
            let html = '';
            users.forEach(user => {
                const isSelected = selectedUsers.has(user.id);
                const statusClass = getStatusClass(user.status);
                const accountTypeClass = getAccountTypeClass(user.acct_type);
                const initials = (user.first_name.charAt(0) + user.last_name.charAt(0)).toUpperCase();
                const registeredDate = new Date(user.created_at).toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });
                
                html += `
                    <tr class="border-b border-gray-100 hover:bg-gray-50 ${isSelected ? 'bg-blue-50' : ''}">
                        <td class="p-4">
                            <input type="checkbox" 
                                   class="user-checkbox rounded border-gray-300" 
                                   value="${user.id}"
                                   ${isSelected ? 'checked' : ''}
                                   onchange="toggleUserSelection(${user.id}, this.checked)">
                        </td>
                        <td class="p-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orchid-dark to-orchid-dark/80 flex items-center justify-center text-white font-semibold mr-3">
                                    ${initials}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">${user.first_name} ${user.last_name}</div>
                                    <div class="text-sm text-gray-500">${user.email}</div>
                                    ${user.phone ? `<div class="text-xs text-gray-400">${user.phone}</div>` : ''}
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium ${accountTypeClass}">
                                ${user.acct_type.charAt(0).toUpperCase() + user.acct_type.slice(1)}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-gray-900">${user.points_balance.toLocaleString()}</div>
                            <div class="text-xs text-gray-500">points</div>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium ${statusClass}">
                                ${user.status.charAt(0).toUpperCase() + user.status.slice(1)}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="text-sm text-gray-900">${registeredDate}</div>
                            <div class="text-xs text-gray-500">${formatRelativeTime(user.created_at)}</div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center space-x-2">
                                <button onclick="editUser(${user.id})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteUser(${user.id}, '${user.first_name} ${user.last_name}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                ${user.status === 'active' ? `
                                    <button onclick="deactivateUser(${user.id})" class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg" title="Deactivate">
                                        <i class="fas fa-user-slash"></i>
                                    </button>
                                ` : `
                                    <button onclick="activateUser(${user.id})" class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Activate">
                                        <i class="fas fa-user-check"></i>
                                    </button>
                                `}
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            usersTableBody.innerHTML = html;
        }

        // Render pagination
        function renderPagination(pagination) {
            let html = `
                <div class="flex items-center justify-between">
                    <div class="flex-1 flex justify-between sm:hidden">
                        ${pagination.has_previous_page ? `
                            <button onclick="changePage(${pagination.current_page - 1})" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </button>
                        ` : ''}
                        ${pagination.has_next_page ? `
                            <button onclick="changePage(${pagination.current_page + 1})" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </button>
                        ` : ''}
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing <span class="font-medium">${pagination.from}</span> to 
                                <span class="font-medium">${pagination.to}</span> of 
                                <span class="font-medium">${pagination.total_users}</span> results
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            `;
            
            // Previous button
            html += pagination.has_previous_page ? `
                <button onclick="changePage(${pagination.current_page - 1})" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <span class="sr-only">Previous</span>
                    <i class="fas fa-chevron-left h-5 w-5"></i>
                </button>
            ` : `
                <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                    <i class="fas fa-chevron-left h-5 w-5"></i>
                </span>
            `;
            
            // Page numbers
            const totalPages = pagination.total_pages;
            const currentPage = pagination.current_page;
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, currentPage + 2);
            
            if (currentPage <= 3) {
                endPage = Math.min(5, totalPages);
            }
            
            if (currentPage >= totalPages - 2) {
                startPage = Math.max(1, totalPages - 4);
            }
            
            // Show first page if not already showing
            if (startPage > 1) {
                html += `
                    <button onclick="changePage(1)" class="pagination-item relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        1
                    </button>
                `;
                if (startPage > 2) {
                    html += `
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                            ...
                        </span>
                    `;
                }
            }
            
            // Show page numbers
            for (let i = startPage; i <= endPage; i++) {
                if (i === currentPage) {
                    html += `
                        <button aria-current="page" class="pagination-item active relative inline-flex items-center px-4 py-2 border border-orchid-dark bg-orchid-dark text-white text-sm font-medium">
                            ${i}
                        </button>
                    `;
                } else {
                    html += `
                        <button onclick="changePage(${i})" class="pagination-item relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            ${i}
                        </button>
                    `;
                }
            }
            
            // Show last page if not already showing
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    html += `
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                            ...
                        </span>
                    `;
                }
                html += `
                    <button onclick="changePage(${totalPages})" class="pagination-item relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        ${totalPages}
                    </button>
                `;
            }
            
            // Next button
            html += pagination.has_next_page ? `
                <button onclick="changePage(${pagination.current_page + 1})" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <span class="sr-only">Next</span>
                    <i class="fas fa-chevron-right h-5 w-5"></i>
                </button>
            ` : `
                <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                    <i class="fas fa-chevron-right h-5 w-5"></i>
                </span>
            `;
            
            html += `
                            </nav>
                        </div>
                    </div>
                </div>
            `;
            
            paginationContainer.innerHTML = html;
        }

        // Render results info
        function renderResultsInfo(pagination, filters) {
            let info = `Showing ${pagination.from}-${pagination.to} of ${pagination.total_users} users`;
            
            if (filters.search) {
                info += ` for "${filters.search}"`;
            }
            
            if (filters.acct_type !== 'all') {
                info += ` (${filters.acct_type} accounts)`;
            }
            
            if (filters.status !== 'all') {
                info += `, ${filters.status} status`;
            }
            
            resultsInfo.textContent = info;
        }

        // Change page
        function changePage(page) {
            currentPage = page;
            loadUsers();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Reset filters
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('accountTypeFilter').value = 'all';
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('dateFrom').value = '';
            document.getElementById('dateTo').value = '';
            document.getElementById('sortBy').value = 'created_at:desc';
            document.getElementById('perPage').value = '10';
            currentPage = 1;
            loadUsers();
        }

        // User selection
        function toggleSelectAll(checkbox) {
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            userCheckboxes.forEach(cb => {
                cb.checked = checkbox.checked;
                const userId = parseInt(cb.value);
                if (checkbox.checked) {
                    selectedUsers.add(userId);
                } else {
                    selectedUsers.delete(userId);
                }
            });
        }

        function toggleUserSelection(userId, isChecked) {
            if (isChecked) {
                selectedUsers.add(userId);
            } else {
                selectedUsers.delete(userId);
                selectAllCheckbox.checked = false;
            }
        }

        // Bulk actions
        function handleBulkAction(select) {
            bulkAction = select.value;
        }

        function applyBulkAction() {
            if (selectedUsers.size === 0) {
                alert('Please select at least one user');
                return;
            }

            if (!bulkAction) {
                alert('Please select an action');
                return;
            }

            if (confirm(`Are you sure you want to ${bulkAction} ${selectedUsers.size} user(s)?`)) {
                const formData = new FormData();
                formData.append('action', 'bulk_action');
                formData.append('user_ids', Array.from(selectedUsers).join(','));
                formData.append('bulk_action', bulkAction);

                fetch('bulk_users.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        alert(data.message || 'Action completed successfully');
                        loadUsers();
                    } else {
                        alert(data.message || 'Failed to perform action');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Network error occurred');
                });
            }

            // Reset bulk action
            document.getElementById('bulkActions').value = '';
            bulkAction = '';
        }

        // Edit user
        function editUser(userId) {
            // Fetch user data
            const formData = new FormData();
            formData.append('action', 'get_user');
            formData.append('partner_id', userId);

            fetch('get_user_info', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    const user = data;
                    document.getElementById('editUserId').value = user.id;
                    document.getElementById('editFirstName').value = user.first_name;
                    document.getElementById('editLastName').value = user.last_name;
                    document.getElementById('editEmail').value = user.email;
                    document.getElementById('editPhone').value = user.phone || '';
                    
                    // Hide password reset fields
                    /*document.getElementById('passwordResetFields').classList.add('hidden');
                    document.getElementById('editPassword').value = '';
                    document.getElementById('editPasswordConfirm').value = '';*/
                    
                    openEditModal();
                } else {
                    alert(data.message || 'Failed to load user data');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error occurred');
            });
        }

        function openEditModal() {
            editUserModal.classList.add('active');
        }

        function closeEditModal() {
            editUserModal.classList.remove('active');
        }

        function togglePasswordReset() {
            const fields = document.getElementById('passwordResetFields');
            fields.classList.toggle('hidden');
        }

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed z-[9999] top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${type === 'success' ? 'bg-green-100 text-green-800 border-l-4 border-green-500' : type === 'warning' ? 'bg-orange-100 text-orange-800 border-l-4 border-orange-500' : type === 'error' ? 'bg-red-100 text-red-800 border-l-4 border-red-500' : 'bg-blue-100 text-blue-800 border-l-4 border-blue-500'}`;
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

        function updateUser(event) {
            event.preventDefault();
            
            const userId = document.getElementById('editUserId').value;
        
            const formData = new FormData();
            formData.append('user_id', userId);
            formData.append('first_name', document.getElementById('editFirstName').value);
            formData.append('last_name', document.getElementById('editLastName').value);
            formData.append('email', document.getElementById('editEmail').value);
            formData.append('phone', document.getElementById('editPhone').value);
            
            // Show loading
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            submitBtn.disabled = true;
            
            fetch('update_user', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    showNotification('User updated successfully', 'success');
                    closeEditModal();
                    loadUsers();
                } else {
                    alert(data.message || 'Failed to update user');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error occurred');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }

        // Delete user
        function deleteUser(userId, userName) {
            userToDelete = { id: userId, name: userName };
            document.getElementById('deleteMessage').textContent = 
                `Are you sure you want to delete "${userName}"? This action cannot be undone and will permanently remove the user account.`;
            deleteModal.classList.add('active');
        }

        function openDeleteModal() {
            deleteModal.classList.add('active');
        }

        function closeDeleteModal() {
            deleteModal.classList.remove('active');
            userToDelete = null;
        }

        function confirmDelete() {
            if (!userToDelete) return;
            
            const formData = new FormData();
            formData.append('action', 'delete_user');
            formData.append('id', userToDelete.id);
            
            fetch('delete_user', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    showNotification(`User "${userToDelete.name}" deleted successfully`, 'success');
                    closeDeleteModal();
                    loadUsers();
                } else {
                    alert(data.message || 'Failed to delete user');
                    showNotification(data.message || 'Failed to delete user', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error occurred');
            });
        }

        // Add user
        function openAddUserModal() {
            addUserModal.classList.add('active');
        }

        function closeAddUserModal() {
            addUserModal.classList.remove('active');
            document.getElementById('addUserForm').reset();
        }

        function createUser(event) {
            event.preventDefault();
            
            const password = document.getElementById('addPassword').value;
            const passwordConfirm = document.getElementById('addPasswordConfirm').value;
            
            if (password !== passwordConfirm) {
                alert('Passwords do not match');
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'create_user');
            formData.append('first_name', document.getElementById('addFirstName').value);
            formData.append('last_name', document.getElementById('addLastName').value);
            formData.append('email', document.getElementById('addEmail').value);
            formData.append('phone', document.getElementById('addPhone').value);
            formData.append('acct_type', document.getElementById('addAccountType').value);
            formData.append('status', document.getElementById('addStatus').value);
            formData.append('password', password);
            formData.append('points_balance', document.getElementById('addPointsBalance').value);
            
            // Show loading
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
            submitBtn.disabled = true;
            
            fetch('create_user.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    alert('User created successfully');
                    closeAddUserModal();
                    loadUsers();
                } else {
                    alert(data.message || 'Failed to create user');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error occurred');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }

        // User status actions
        function activateUser(userId) {
            showStatusConfirmationModal('Activate User', 'Are you sure you want to activate this user?', () => {
                updateUserStatus(userId, 'active');
            });
        }

        function deactivateUser(userId) {
            showStatusConfirmationModal('Deactivate User', 'Are you sure you want to deactivate this user?', () => {
                updateUserStatus(userId, 'inactive');
            });
        }

        function showStatusConfirmationModal(title, message, onConfirm) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">${title}</h3>
                        <p class="text-gray-600 mb-6">${message}</p>
                        <div class="flex justify-end space-x-3">
                            <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
                                Cancel
                            </button>
                            <button onclick="this.closest('.fixed').remove(); arguments[0]();" class="px-4 py-2 bg-orchid-dark text-white rounded-lg hover:bg-orchid-dark/90 font-medium">
                                Confirm
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            // Execute callback on confirm button click
            modal.querySelector('button:last-child').onclick = () => {
                modal.remove();
                onConfirm();
            };
        }

        function updateUserStatus(userId, status) {
            const formData = new FormData();
            formData.append('partner_id', userId);
            formData.append('status', status);
            
            fetch('update_account_status', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    showNotification(`User ${status === 'active' ? 'activated' : 'deactivated'} successfully`, 'success');
                    loadUsers();
                } else {
                    showNotification(data.message || 'Failed to update user status', 'error')
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error occurred');
            });
        }

        // View user details
        function viewUser(userId) {
            window.location.href = `user_details.php?id=${userId}`;
        }

        // Export users
        function exportUsers() {
            const search = document.getElementById('searchInput').value;
            const accountType = document.getElementById('accountTypeFilter').value;
            const status = document.getElementById('statusFilter').value;
            
            let url = `export_users.php?search=${encodeURIComponent(search)}&acct_type=${accountType}&status=${status}`;
            window.open(url, '_blank');
        }

        // Utility functions
        function getStatusClass(status) {
            switch(status) {
                case 'active': return 'status-active';
                case 'inactive': return 'status-inactive';
                case 'pending': return 'status-pending';
                case 'suspended': return 'status-suspended';
                default: return 'status-inactive';
            }
        }

        function getAccountTypeClass(acctType) {
            switch(acctType) {
                case 'customer': return 'account-customer';
                case 'partner': return 'account-partner';
                case 'admin': return 'account-admin';
                default: return 'account-customer';
            }
        }

        function formatRelativeTime(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffMs = now - date;
            const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
            
            if (diffDays === 0) {
                const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
                if (diffHours === 0) {
                    const diffMinutes = Math.floor(diffMs / (1000 * 60));
                    return diffMinutes <= 1 ? 'just now' : `${diffMinutes} minutes ago`;
                }
                return `${diffHours} hour${diffHours > 1 ? 's' : ''} ago`;
            } else if (diffDays === 1) {
                return 'yesterday';
            } else if (diffDays < 7) {
                return `${diffDays} days ago`;
            } else if (diffDays < 30) {
                const weeks = Math.floor(diffDays / 7);
                return `${weeks} week${weeks > 1 ? 's' : ''} ago`;
            }
            return '';
        }

        function showError(message) {
            usersTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="p-8 text-center">
                        <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Error Loading Users</h4>
                        <p class="text-gray-500 mb-4">${message}</p>
                        <button onclick="loadUsers()" class="px-4 py-2 bg-orchid-dark text-white rounded-lg hover:bg-orchid-dark/90">
                            <i class="fas fa-redo mr-2"></i>Try Again
                        </button>
                    </td>
                </tr>
            `;
        }
    </script>
</body>
</html>
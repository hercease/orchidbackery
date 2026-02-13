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
        
        /* Card styles */
        .admin-card {
            transition: all 0.3s ease;
            border-radius: 12px;
        }
        
        .admin-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        /* Permission tag styles */
        .permission-tag {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            margin: 4px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            user-select: none;
        }
        
        .permission-tag:hover {
            transform: translateY(-1px);
        }
        
        .permission-tag.active {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .permission-tag.inactive {
            background-color: #f3f4f6;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }
        
        .permission-tag.active:hover {
            background-color: #a7f3d0;
        }
        
        .permission-tag.inactive:hover {
            background-color: #e5e7eb;
        }
        
        /* Checkbox indicator */
        .permission-check {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            margin-right: 6px;
            border-radius: 4px;
            font-size: 10px;
        }
        
        .permission-check.active {
            background-color: #10b981;
            color: white;
        }
        
        .permission-check.inactive {
            background-color: #9ca3af;
            color: white;
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
    
    <!-- Confirm Permission Modal -->
    <div id="confirmModal" class="modal">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-orchid-dark/10 mx-auto mb-4">
                    <i class="fas fa-exclamation-circle text-orchid-dark text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center mb-2" id="confirmTitle"></h3>
                <p class="text-gray-600 text-center mb-6" id="confirmMessage"></p>
                
                <div class="flex space-x-4">
                    <button onclick="closeConfirmModal()" 
                            class="flex-1 py-3 px-4 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50">
                        Cancel
                    </button>
                    <button onclick="processPermissionChange()" 
                            class="flex-1 py-3 px-4 rounded-lg btn-primary font-medium"
                            id="confirmActionBtn">
                        <span id="confirmActionText">Confirm</span>
                        <span id="confirmActionLoading" class="hidden ml-2">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Admin Modal -->
    <div id="addAdminModal" class="modal">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Add New Admin</h3>
                    <button onclick="closeAddAdminModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="addAdminForm" onsubmit="submitAddAdminForm(event)">
                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                FirstName *
                            </label>
                            <input type="text" 
                                   id="firstName"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent"
                                   name="firstName"
                                   required />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                LastName *
                            </label>
                            <input type="text" 
                                   id="lastName"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent"
                                   name="lastName"
                                   required />
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address *
                            </label>
                             <input type="email" 
                                   id="adminEmail"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent"
                                   name="adminEmail"
                                   required />
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full py-3 px-4 rounded-lg btn-primary text-lg font-medium"
                                    id="addAdminBtn">
                                <i class="fas fa-user-plus mr-2"></i>
                                <span id="addAdminText">Create Admin</span>
                                <span id="addAdminLoading" class="hidden ml-2">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
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
                        <h2 class="text-xl font-semibold text-gray-800">Access Control</h2>
                        <p class="text-sm text-gray-500">Manage admin permissions</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="openAddAdminModal()" class="px-4 py-2 rounded-lg btn-primary">
                        <i class="fas fa-user-plus mr-2"></i> Add Admin
                    </button>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-7xl mx-auto">
                    <!-- Stats Overview -->
                    <div class="mb-8">
                        <div class="bg-white rounded-xl shadow p-5 max-w-xs">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500">Total Admins</p>
                                    <p class="text-3xl font-bold mt-2 text-orchid-dark" id="totalAdmins">0</p>
                                </div>
                                <div class="p-3 rounded-full bg-orchid-dark/10">
                                    <i class="fas fa-users text-orchid-dark text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="bg-white rounded-xl shadow p-6 mb-6">
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" 
                                   id="searchAdmins" 
                                   placeholder="Search admins by name or email..." 
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent"
                                   onkeyup="filterAdmins()">
                        </div>
                    </div>
                    
                    <!-- Admins Cards -->
                    <div id="adminsContainer">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="adminsGrid">
                            <!-- Admin cards will be loaded here -->
                        </div>
                        
                        <!-- Loading State -->
                        <div id="loadingState" class="text-center py-12">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 rounded-full bg-orchid-dark/10 flex items-center justify-center">
                                    <i class="fas fa-spinner fa-spin text-orchid-dark text-2xl"></i>
                                </div>
                                <p class="text-gray-600">Loading admin data...</p>
                                <p class="text-sm text-gray-500">Fetching data from server</p>
                            </div>
                        </div>
                        
                        <!-- Empty State -->
                        <div id="emptyState" class="hidden text-center py-12">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-user-slash text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-600">No admins found</p>
                                <p class="text-sm text-gray-500">Try adjusting your search or add new admins</p>
                                <button onclick="openAddAdminModal()" class="mt-4 px-4 py-2 rounded-lg btn-primary">
                                    <i class="fas fa-user-plus mr-2"></i> Add Admin
                                </button>
                            </div>
                        </div>
                        
                        <!-- Error State -->
                        <div id="errorState" class="hidden text-center py-12">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                                </div>
                                <p class="text-red-600">Failed to load admin data</p>
                                <p class="text-sm text-gray-500">Please check your connection and try again</p>
                                <button onclick="fetchAdmins()" class="mt-4 px-4 py-2 rounded-lg bg-orchid-dark/10 text-orchid-dark font-medium hover:bg-orchid-dark/20">
                                    <i class="fas fa-redo mr-2"></i> Try Again
                                </button>
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
        let allAdmins = [];
        let filteredAdmins = [];
        let pendingPermissionChange = null;
        
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
            fetchAdmins();
            
            // Handle window resize for sidebar
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    closeSidebar();
                }
            });
            
            // Close modals with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAddAdminModal();
                    closeConfirmModal();
                    closeSidebar();
                }
            });
        });
        
        // Fetch admins
        async function fetchAdmins() {
            try {
                showLoading();
                
                const response = await fetch('fetch_admins_with_permissions', {
                    method: 'POST',
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log(data);
                
                allAdmins = data || [];
                filteredAdmins = [...allAdmins];
                
                renderAdmins();
                updateStats();
                
            } catch (error) {
                console.error('Error fetching admins:', error);
                showError();
                showNotification('Failed to load admin data', 'error');
            } finally {
                hideLoading();
            }
        }
        
        // Refresh data
        function refreshData() {
            fetchAdmins();
            showNotification('Data refreshed successfully', 'success');
        }
        
        // Update statistics
        function updateStats() {
            document.getElementById('totalAdmins').textContent = allAdmins.length;
        }
        
        // Render admins as cards
        function renderAdmins() {
            const container = document.getElementById('adminsGrid');
            
            if (filteredAdmins.length === 0) {
                showEmptyState();
                return;
            }
            
            let cardsHTML = '';
            
            filteredAdmins.forEach(admin => {
                const activePermissions = admin.permissions ? admin.permissions.filter(p => p.active).length : 0;
                const totalPermissions = admin.permissions ? admin.permissions.length : 0;
                
                // Count permissions by category for summary
                const permissionSummary = {};
                if (admin.permissions) {
                    admin.permissions.forEach(permission => {
                        // Extract category from permission_key (e.g., "users.create" -> "users")
                        const category = permission.permission_key.split('.')[0];
                        if (!permissionSummary[category]) {
                            permissionSummary[category] = { total: 0, active: 0 };
                        }
                        permissionSummary[category].total++;
                        if (permission.active) {
                            permissionSummary[category].active++;
                        }
                    });
                }
                
                cardsHTML += `
                    <div class="admin-card bg-white rounded-xl shadow border border-gray-200 overflow-hidden">
                        <!-- Card Header -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-full bg-orchid-dark/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-user-shield text-orchid-dark"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800 text-lg">${admin.name}</h3>
                                    <p class="text-gray-600 text-sm mt-1">${admin.email}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="px-2 py-1 rounded-full text-xs ${admin.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                                            ${admin.status === 'active' ? 'Active' : 'Inactive'}
                                        </span>
                                        <span class="ml-2 text-xs text-gray-500">
                                            ${activePermissions}/${totalPermissions} permissions
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card Body - Permission Summary -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-medium text-gray-700">Permissions Summary</h4>
                                <span class="text-xs text-gray-500">Click to toggle</span>
                            </div>
                            ${Object.keys(permissionSummary).length > 0 ? `
                                <div class="space-y-3">
                                    ${Object.keys(permissionSummary).map(category => {
                                        const summary = permissionSummary[category];
                                        return `
                                            <div>
                                                <div class="flex justify-between items-center mb-1">
                                                    <span class="text-xs font-medium text-gray-600">${category.charAt(0).toUpperCase() + category.slice(1)}</span>
                                                    <span class="text-xs text-gray-500">${summary.active}/${summary.total}</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                    <div class="bg-orchid-dark h-1.5 rounded-full" style="width: ${(summary.active / summary.total) * 100}%"></div>
                                                </div>
                                            </div>
                                        `;
                                    }).join('')}
                                </div>
                            ` : `
                                <p class="text-sm text-gray-500 text-center py-2">No permissions assigned</p>
                            `}
                        </div>
                        
                        <!-- Card Body - Permission Tags -->
                        <div class="p-6">
                            <h4 class="font-medium text-gray-700 mb-3">All Permissions</h4>
                            <div class="flex flex-wrap">
                `;
                
                // Render permission tags
                if (admin.permissions && admin.permissions.length > 0) {
                    admin.permissions.forEach(permission => {
                        cardsHTML += `
                            <span class="permission-tag ${permission.active ? 'active' : 'inactive'}"
                                  onclick="showPermissionConfirm(${admin.id}, ${permission.id}, '${permission.name}', ${!permission.active})"
                                  title="Click to ${permission.active ? 'deactivate' : 'activate'}">
                                <span class="permission-check ${permission.active ? 'active' : 'inactive'}">
                                    <i class="fas fa-${permission.active ? 'check' : 'times'}"></i>
                                </span>
                                ${permission.name}
                            </span>
                        `;
                    });
                } else {
                    cardsHTML += `
                        <p class="text-sm text-gray-500">No permissions available</p>
                    `;
                }
                
                cardsHTML += `
                            </div>
                        </div>
                        
                        <!-- Card Footer - Actions -->
                        ${admin.isAdmin === false ? `
                        <div class="p-6 bg-gray-50 border-t border-gray-100">
                            <div class="flex space-x-3">
                                <button onclick="toggleAdminStatus(${admin.id}, '${admin.name}')" 
                                        class="flex-1 py-2 px-4 rounded-lg ${admin.status === 'active' ? 'bg-yellow-100 text-yellow-600 hover:bg-yellow-200' : 'bg-green-100 text-green-600 hover:bg-green-200'} font-medium transition-colors">
                                    <i class="fas fa-power-off mr-2"></i>
                                    ${admin.status === 'active' ? 'Deactivate' : 'Activate'}
                                </button>
                                <button onclick="deleteAdmin(${admin.id}, '${admin.name}')" 
                                        class="flex-1 py-2 px-4 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 font-medium transition-colors">
                                    <i class="fas fa-trash mr-2"></i>
                                    Delete
                                </button>
                            </div>
                        </div>
                        ` : ''}
                    </div>
                `;
            });
            
            container.innerHTML = cardsHTML;
            hideEmptyState();
            hideErrorState();
        }
        
        // Show permission confirmation modal
        function showPermissionConfirm(userId, permissionId, permissionName, newActiveState) {
            const action = newActiveState ? 'activate' : 'deactivate';
            
            pendingPermissionChange = {
                userId: userId,
                permissionId: permissionId,
                permissionName: permissionName,
                newActiveState: newActiveState
            };
            
            document.getElementById('confirmTitle').textContent = `Confirm Permission ${action}`;
            document.getElementById('confirmMessage').textContent = 
                `Are you sure you want to ${action} the "${permissionName}" permission?`;
            document.getElementById('confirmActionText').textContent = 
                newActiveState ? 'Activate Permission' : 'Deactivate Permission';
            
            document.getElementById('confirmModal').classList.add('active');
        }
        
        // Close confirm modal
        function closeConfirmModal() {
            pendingPermissionChange = null;
            document.getElementById('confirmModal').classList.remove('active');
        }
        
        // Process permission change
        async function processPermissionChange() {
            if (!pendingPermissionChange) return;
            
            try {
                // Show loading
                const actionBtn = document.getElementById('confirmActionBtn');
                const actionText = document.getElementById('confirmActionText');
                const actionLoading = document.getElementById('confirmActionLoading');
                
                actionBtn.disabled = true;
                actionText.textContent = 'Processing...';
                actionLoading.classList.remove('hidden');
                
                // Prepare data
                const data = {
                    user_id: pendingPermissionChange.userId,
                    permission_id: pendingPermissionChange.permissionId,
                    active: pendingPermissionChange.newActiveState
                };
                
                // Submit to API
                const response = await fetch('update_role_permissions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams(data)
                });
                
                const result = await response.json();
                
                if (result.status) {
                    const action = pendingPermissionChange.newActiveState ? 'activated' : 'deactivated';
                    showNotification(`Permission ${action} successfully`, 'success');
                    
                    // Refresh data
                    await fetchAdmins();
                } else {
                    throw new Error(result.error || 'Failed to update permission');
                }
                
            } catch (error) {
                console.error('Error updating permission:', error);
                showNotification(error.message || 'Failed to update permission', 'error');
            } finally {
                // Reset button
                const actionBtn = document.getElementById('confirmActionBtn');
                const actionText = document.getElementById('confirmActionText');
                const actionLoading = document.getElementById('confirmActionLoading');
                
                actionBtn.disabled = false;
                actionText.textContent = pendingPermissionChange.newActiveState ? 'Activate Permission' : 'Deactivate Permission';
                actionLoading.classList.add('hidden');
                
                // Close modal
                closeConfirmModal();
            }
        }
        
        // Filter admins
        function filterAdmins() {
            const searchTerm = document.getElementById('searchAdmins').value.toLowerCase();
            
            filteredAdmins = allAdmins.filter(admin => {
                return !searchTerm || 
                    admin.name.toLowerCase().includes(searchTerm) ||
                    admin.email.toLowerCase().includes(searchTerm);
            });
            
            renderAdmins();
        }
        
        // Add Admin Modal
        function openAddAdminModal() {
            document.getElementById('addAdminForm').reset();
            document.getElementById('addAdminModal').classList.add('active');
        }
        
        function closeAddAdminModal() {
            document.getElementById('addAdminModal').classList.remove('active');
        }
        
        async function submitAddAdminForm(event) {
            event.preventDefault();
            
            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const email = document.getElementById('adminEmail').value.trim();
            
            if (!firstName || !lastName || !email) {
                showNotification('Please fill in all required fields', 'warning');
                return;
            }
            
            try {
                // Show loading
                const addBtn = document.getElementById('addAdminBtn');
                const addText = document.getElementById('addAdminText');
                const addLoading = document.getElementById('addAdminLoading');
                
                addBtn.disabled = true;
                addText.textContent = 'Creating...';
                addLoading.classList.remove('hidden');
                
                // Prepare data
                const data = {
                    firstname: firstName,
                    email: email,
                    lastname: lastName
                };
                
                // Submit to API
                const response = await fetch('create_admin_account', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams(data)
                });
                
                const result = await response.json();
                console.log(result);
                
                if (result.status) {
                    showNotification(`Admin ${firstName} created successfully`, 'success');
                    closeAddAdminModal();
                    
                    // Refresh data
                    await fetchAdmins();
                } else {
                    throw new Error(result.message || 'Failed to create admin');
                }
                
            } catch (error) {
                console.error('Error creating admin:', error);
                showNotification(error.message || 'Failed to create admin', 'error');
            } finally {
                // Reset button
                const addBtn = document.getElementById('addAdminBtn');
                const addText = document.getElementById('addAdminText');
                const addLoading = document.getElementById('addAdminLoading');
                
                addBtn.disabled = false;
                addText.textContent = 'Create Admin';
                addLoading.classList.add('hidden');
            }
        }
        
        // Toggle admin status
        async function toggleAdminStatus(adminId, adminName) {
            if (!confirm(`Are you sure you want to toggle status for ${adminName}?`)) return;
            
            try {
                const response = await fetch('update_account_status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        partner_id: adminId,
                        status: allAdmins.find(admin => admin.id === adminId).status === 'active' ? 'inactive' : 'active',
                        // status: allAdmins.find(admin => admin.id === adminId).status === 'active' ? 'inactive' : 'active'
                    })
                });
                
                const result = await response.json();
                
                if (result.status) {
                    showNotification(`Admin status toggled successfully`, 'success');
                    await fetchAdmins();
                } else {
                    throw new Error(result.message || 'Failed to toggle admin status');
                }
                
            } catch (error) {
                console.error('Error toggling admin status:', error);
                showNotification(error.message || 'Failed to toggle admin status', 'error');
            }
        }
        
        // Delete admin
        async function deleteAdmin(adminId, adminName) {
            if (!confirm(`Permanently delete ${adminName}? This action cannot be undone.`)) return;
            
            try {
                const response = await fetch('delete_user', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        id : adminId,
                        action: 'delete_admin'
                    })
                });
                
                const result = await response.json();
                
                if (result.status) {
                    showNotification(`Admin deleted successfully`, 'success');
                    await fetchAdmins();
                } else {
                    throw new Error(result.message || 'Failed to delete admin');
                }
                
            } catch (error) {
                console.error('Error deleting admin:', error);
                showNotification(error.message || 'Failed to delete admin', 'error');
            }
        }
        
        // State management functions
        function showLoading() {
            document.getElementById('loadingState').classList.remove('hidden');
            document.getElementById('adminsGrid').innerHTML = '';
            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('errorState').classList.add('hidden');
            //document.getElementById('refreshBtn').classList.add('fa-spin');
        }
        
        function hideLoading() {
            document.getElementById('loadingState').classList.add('hidden');
            //document.getElementById('refreshBtn').classList.remove('fa-spin');
        }
        
        function showEmptyState() {
            document.getElementById('emptyState').classList.remove('hidden');
            document.getElementById('adminsGrid').innerHTML = '';
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('errorState').classList.add('hidden');
        }
        
        function hideEmptyState() {
            document.getElementById('emptyState').classList.add('hidden');
        }
        
        function showError() {
            document.getElementById('errorState').classList.remove('hidden');
            document.getElementById('adminsGrid').innerHTML = '';
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('emptyState').classList.add('hidden');
        }
        
        function hideErrorState() {
            document.getElementById('errorState').classList.add('hidden');
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
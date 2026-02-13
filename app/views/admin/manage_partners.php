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

        /* Partner logo */
        .partner-logo {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        /* Wallet balance styling */
        .wallet-balance {
            font-family: 'Courier New', monospace;
        }

        /* File upload styles */
        .file-upload-area {
            transition: all 0.3s ease;
        }

        .file-upload-area:hover {
            border-color: #CC9933;
            background-color: rgba(204, 153, 51, 0.05);
        }

        .file-upload-area.dragover {
            border-color: #013220;
            background-color: rgba(1, 50, 32, 0.1);
        }

        /* Logo preview */
        .logo-preview {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        /* Progress bar */
        .upload-progress {
            width: 100%;
            height: 4px;
            background-color: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
            margin-top: 8px;
        }

        .upload-progress-bar {
            height: 100%;
            background-color: #013220;
            transition: width 0.3s ease;
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
                        <h2 id="dashboardTitle" class="text-xl font-semibold text-gray-800">Partners Management</h2>
                        <p class="text-sm text-gray-500">Manage all registered partners</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Add Partner Button -->
                    <button onclick="openAddPartnerModal()" class="px-4 py-2 text-sm font-medium rounded-lg btn-primary">
                        <i class="fas fa-handshake mr-2"></i>Add Partner
                    </button>
                </div>
            </header>
            
            <!-- Partners Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Partners -->
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Total Partners</p>
                                <p class="text-3xl font-bold mt-2" id="totalPartnersCount">0</p>
                                <p class="text-xs text-gray-500 mt-1">All registered partners</p>
                            </div>
                            <div class="p-3 rounded-full bg-orchid-dark/10">
                                <i class="fas fa-handshake text-orchid-dark text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Wallet Balance -->
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Total Wallet Balance</p>
                                <p class="text-3xl font-bold mt-2" id="totalWalletBalance">₦0.00</p>
                                <p class="text-xs text-gray-500 mt-1">Across all partners</p>
                            </div>
                            <div class="p-3 rounded-full bg-orchid-gold/10">
                                <i class="fas fa-wallet text-orchid-gold text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Active Partners -->
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Active Partners</p>
                                <p class="text-3xl font-bold mt-2" id="activePartnersCount">0</p>
                                <p class="text-xs text-green-600 mt-1">
                                    <i class="fas fa-chart-line mr-1"></i>
                                    <span id="activePercentage">0%</span> of total
                                </p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Average Balance -->
                    <div class="stat-card bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Average Balance</p>
                                <p class="text-3xl font-bold mt-2" id="averageBalance">₦0.00</p>
                                <p class="text-xs text-gray-500 mt-1">Per partner</p>
                            </div>
                            <div class="p-3 rounded-full bg-blue-100">
                                <i class="fas fa-calculator text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Filters Section -->
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <div class="relative">
                                <input type="text" 
                                       id="searchInput" 
                                       placeholder="Search partners by name, email, phone, or location..."
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent"
                                       onkeyup="handleSearch(event)">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Filter -->
                        <div>
                            <select id="statusFilter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent" onchange="loadPartners()">
                                <option value="all">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                        
                        <!-- Balance Filter -->
                        <div>
                            <select id="balanceFilter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent" onchange="loadPartners()">
                                <option value="all">All Balances</option>
                                <option value="positive">Positive Balance</option>
                                <option value="zero">Zero Balance</option>
                                <option value="negative">Negative Balance</option>
                                <option value="high">High Balance (₦10K+)</option>
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
                                    <input type="date" id="dateFrom" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" onchange="loadPartners()">
                                    <input type="date" id="dateTo" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" onchange="loadPartners()">
                                </div>
                            </div>
                            
                            <!-- Sort By -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                                <select id="sortBy" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" onchange="loadPartners()">
                                    <option value="created_at:desc">Newest First</option>
                                    <option value="created_at:asc">Oldest First</option>
                                    <option value="first_name:asc">Name A-Z</option>
                                    <option value="first_name:desc">Name Z-A</option>
                                    <option value="wallet_balance:desc">Highest Balance</option>
                                    <option value="wallet_balance:asc">Lowest Balance</option>
                                </select>
                            </div>
                            
                            <!-- Results Per Page -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Results Per Page</label>
                                <select id="perPage" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" onchange="loadPartners()">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Partners Table -->
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-gray-800">Registered Partners</h3>
                            <p id="resultsInfo" class="text-sm text-gray-500 mt-1">Loading...</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <!-- Bulk Actions 
                            <select id="bulkActions" class="px-3 py-2 border border-gray-300 rounded-lg text-sm" onchange="handleBulkAction(this)">
                                <option value="">Bulk Actions</option>
                                <option value="activate">Activate Selected</option>
                                <option value="deactivate">Deactivate Selected</option>
                                <option value="add_balance">Add Balance</option>
                                <option value="deduct_balance">Deduct Balance</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                            <button onclick="applyBulkAction()" class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
                                Apply
                            </button>-->
                        </div>
                    </div>
                    
                    <div class="table-container">
                        <table class="w-full table-responsive">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">
                                        <input type="checkbox" id="selectAll" class="rounded border-gray-300" onchange="toggleSelectAll(this)">
                                    </th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Partner</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Contact Info</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Wallet Balance</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Status</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Registered</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="partnersTableBody">
                                <!-- Partners will be loaded here -->
                                <tr>
                                    <td colspan="7" class="p-8 text-center">
                                        <div class="inline-block loading-spinner rounded-full h-8 w-8 border-t-2 border-b-2 border-orchid-dark"></div>
                                        <p class="mt-2 text-gray-600">Loading partners...</p>
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

    <!-- Edit Partner Modal -->
    <div id="editPartnerModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Edit Partner</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="editPartnerForm" onsubmit="updatePartner(event)" enctype="multipart/form-data">
                    <input type="hidden" id="editPartnerId">
                    <input type="hidden" id="editCurrentLogo" value="">
                    
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                            <input type="tel" id="editPhone" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Location/Address</label>
                            <input type="text" id="editLocation" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                        </div>
                        
                        <!-- Logo Section -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Partner Logo</label>
                            
                            <!-- Logo Preview Container -->
                            <div id="editlogoPreviewContainer" class="mb-3 hidden">
                                <p class="text-sm text-gray-600 mb-2">Logo Preview:</p>
                                <div class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center overflow-hidden">
                                    <img id="editlogoPreview" src="" alt="Logo Preview" class="max-w-full max-h-full object-contain">
                                </div>
                            </div>
                            
                            <!-- File Upload Area -->
                            <div class="mt-2">
                                <div class="flex items-center justify-center w-full">
                                    <label for="editlogoUpload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                            <p class="mb-2 text-sm text-gray-500">
                                                <span class="font-semibold">Click to upload</span> or drag and drop
                                            </p>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                        </div>
                                        <input id="editlogoUpload" name="editlogo" type="file" class="hidden" accept=".jpg,.jpeg,.png,.gif,.webp" onchange="previewEditLogo(event)">
                                    </label>
                                </div>
                                
                                <!-- File Info -->
                                <div id="editfileInfo" class="mt-2 text-sm text-gray-500 hidden">
                                    <div class="flex items-center justify-between">
                                        <span id="editfileName"></span>
                                        <button type="button" onclick="removeEditLogo()" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-times"></i> Remove
                                        </button>
                                    </div>
                                    <div id="editfileSize" class="text-xs text-gray-400 mt-1"></div>
                                </div>
                            </div>
                        </div>
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
                <h3 class="text-xl font-bold text-gray-800 mb-2">Delete Partner</h3>
                <p class="text-gray-600 mb-6" id="deleteMessage">Are you sure you want to delete this partner? This action cannot be undone.</p>
                
                <div class="flex justify-center space-x-3">
                    <button onclick="closeDeleteModal()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
                        Cancel
                    </button>
                    <button onclick="confirmDelete()" class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Partner
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Partner Modal -->
    <div id="addPartnerModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Add New Partner</h3>
                    <button onclick="closeAddPartnerModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <form id="addPartnerForm" onsubmit="createPartner(event)" enctype="multipart/form-data">
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                            <input type="tel" id="addPhone" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Location/Address</label>
                            <input type="text" id="addLocation" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                        </div>
                        
                        <!-- Logo Upload Section -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Partner Logo</label>
                            
                            <!-- Logo Preview Container -->
                            <div id="logoPreviewContainer" class="mb-3 hidden">
                                <p class="text-sm text-gray-600 mb-2">Logo Preview:</p>
                                <div class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center overflow-hidden">
                                    <img id="logoPreview" src="" alt="Logo Preview" class="max-w-full max-h-full object-contain">
                                </div>
                            </div>
                            
                            <!-- File Upload Area -->
                            <div class="mt-2">
                                <div class="flex items-center justify-center w-full">
                                    <label for="logoUpload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                            <p class="mb-2 text-sm text-gray-500">
                                                <span class="font-semibold">Click to upload</span> or drag and drop
                                            </p>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                        </div>
                                        <input id="logoUpload" name="logo" type="file" class="hidden" accept=".jpg,.jpeg,.png,.gif,.webp" onchange="previewLogo(event)">
                                    </label>
                                </div>
                                
                                <!-- File Info -->
                                <div id="fileInfo" class="mt-2 text-sm text-gray-500 hidden">
                                    <div class="flex items-center justify-between">
                                        <span id="fileName"></span>
                                        <button type="button" onclick="removeLogo()" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-times"></i> Remove
                                        </button>
                                    </div>
                                    <div id="fileSize" class="text-xs text-gray-400 mt-1"></div>
                                </div>
                            </div>
                            
                            <!-- Alternative URL Input (Optional) -->
                            <div class="mt-4">
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" id="useUrlInstead" class="mr-2" onchange="toggleUrlInput()">
                                    <label for="useUrlInstead" class="text-sm text-gray-600">Or enter logo URL instead</label>
                                </div>
                                <input type="url" id="logoUrl" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent hidden" placeholder="https://example.com/logo.png">
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" onclick="closeAddPartnerModal()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 bg-orchid-dark text-white rounded-lg font-medium hover:bg-orchid-dark/90">
                            <i class="fas fa-handshake mr-2"></i>
                            Create Partner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Balance Adjustment Modal -->
    <div id="balanceModal" class="modal">
        <div class="modal-content max-w-md">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Adjust Wallet Balance</h3>
                    <button onclick="closeBalanceModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="balanceForm" onsubmit="adjustBalance(event)">
                    <input type="hidden" id="balancePartnerId">
                    <input type="hidden" id="balancePartnerName">
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Partner</p>
                            <p class="font-medium" id="balancePartnerInfo">Loading...</p>
                            <p class="text-sm text-gray-600 mt-1">Current Balance: <span id="currentBalance" class="font-bold">₦0.00</span></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Adjustment Type *</label>
                            <select id="balanceAdjustmentType" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                                <option value="add">Add Funds to Wallet</option>
                                <option value="deduct">Deduct Funds from Wallet</option>
                                <option value="set">Set Specific Amount</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Amount (₦) *</label>
                            <input type="number" id="balanceAmount" required min="0" step="0.01" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Adjustment *</label>
                            <textarea id="balanceReason" required rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent" placeholder="Enter reason for this balance adjustment..."></textarea>
                        </div>
                        
                        <div id="balancePreview" class="bg-blue-50 p-4 rounded-lg hidden">
                            <p class="text-sm font-medium text-blue-800">Preview</p>
                            <p class="text-sm text-blue-600 mt-1" id="balancePreviewText"></p>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" onclick="closeBalanceModal()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 bg-orchid-dark text-white rounded-lg font-medium hover:bg-orchid-dark/90">
                            <i class="fas fa-exchange-alt mr-2"></i>
                            Apply Adjustment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // State management
        let currentPage = 1;
        let selectedPartners = new Set();
        let partnerToDelete = null;
        let partnerToAdjust = null;
        let bulkAction = '';
        let searchTimeout = null;
        
        // DOM Elements
        const partnersTableBody = document.getElementById('partnersTableBody');
        const paginationContainer = document.getElementById('paginationContainer');
        const resultsInfo = document.getElementById('resultsInfo');
        const editPartnerModal = document.getElementById('editPartnerModal');
        const deleteModal = document.getElementById('deleteModal');
        const addPartnerModal = document.getElementById('addPartnerModal');
        const balanceModal = document.getElementById('balanceModal');
        const selectAllCheckbox = document.getElementById('selectAll');
        
        // Stats elements
        const totalPartnersCount = document.getElementById('totalPartnersCount');
        const totalWalletBalance = document.getElementById('totalWalletBalance');
        const activePartnersCount = document.getElementById('activePartnersCount');
        const activePercentage = document.getElementById('activePercentage');
        const averageBalance = document.getElementById('averageBalance');

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadPartners();
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
                loadPartners();
            }, 500);
        }

        // Load partners function
        function loadPartners() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const balanceFilter = document.getElementById('balanceFilter').value;
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;
            const sortBy = document.getElementById('sortBy').value;
            const perPage = document.getElementById('perPage').value;
            
            // Show loading state
            partnersTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="p-8 text-center">
                        <div class="inline-block loading-spinner rounded-full h-8 w-8 border-t-2 border-b-2 border-orchid-dark"></div>
                        <p class="mt-2 text-gray-600">Loading partners...</p>
                    </td>
                </tr>
            `;
            
            // Prepare request data
            const formData = new FormData();
            formData.append('page', currentPage);
            formData.append('per_page', perPage);
            formData.append('search', search);
            formData.append('acct_type', 'partner'); // Always partner for this page
            formData.append('status', status);
            formData.append('balance_filter', balanceFilter);
            formData.append('date_from', dateFrom);
            formData.append('date_to', dateTo);
            formData.append('sort_by', sortBy.split(':')[0]);
            formData.append('sort_order', sortBy.split(':')[1] || 'desc');
            
            // Send AJAX request
            fetch('fetchallpartners', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status) {
                    renderPartnersTable(data.partners);
                    renderPagination(data.pagination);
                    renderResultsInfo(data.pagination, data.filters);
                    updateStats(data.stats);
                    selectedPartners.clear();
                    selectAllCheckbox.checked = false;
                } else {
                    showError('Failed to load partners: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Network error occurred while loading partners');
            });
        }

        // Update statistics
        function updateStats(stats) {
            if (!stats) return;
            
            totalPartnersCount.textContent = stats.total_partners || '0';
            totalWalletBalance.textContent = formatCurrency(stats.total_wallet_balance || 0);
            activePartnersCount.textContent = stats.active_partners || '0';
            activePercentage.textContent = stats.active_percentage || '0%';
            averageBalance.textContent = formatCurrency(stats.average_balance || 0);
        }

        // Render partners table
        function renderPartnersTable(partners) {
            if (partners.length === 0) {
                partnersTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="p-8 text-center">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-handshake text-gray-400 text-xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-2">No Partners Found</h4>
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
            partners.forEach(partner => {
                const isSelected = selectedPartners.has(partner.id);
                const statusClass = getStatusClass(partner.status);
                const initials = (partner.first_name.charAt(0) + partner.last_name.charAt(0)).toUpperCase();
                const registeredDate = new Date(partner.created_at).toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });
                const balance = parseFloat(partner.wallet_balance) || 0;
                const balanceClass = balance >= 0 ? 'text-green-600' : 'text-red-600';
                
                html += `
                    <tr class="border-b border-gray-100 hover:bg-gray-50 ${isSelected ? 'bg-blue-50' : ''}">
                        <td class="p-4">
                            <input type="checkbox" 
                                   class="partner-checkbox rounded border-gray-300" 
                                   value="${partner.id}"
                                   ${isSelected ? 'checked' : ''}
                                   onchange="togglePartnerSelection(${partner.id}, this.checked)">
                        </td>
                        <td class="p-4">
                            <div class="flex items-center">
                                ${partner.logo ? `
                                    <img src="public/images/${partner.logo}" alt="${partner.first_name} ${partner.last_name}" class="partner-logo mr-3">
                                ` : `
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orchid-dark to-orchid-dark/80 flex items-center justify-center text-white font-semibold mr-3">
                                        ${initials}
                                    </div>
                                `}
                                <div>
                                    <div class="font-medium text-gray-900">${partner.first_name} ${partner.last_name}</div>
                                    ${partner.location ? `<div class="text-sm text-gray-500">${partner.location}</div>` : ''}
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="text-sm text-gray-900">${partner.email}</div>
                            ${partner.phone ? `<div class="text-sm text-gray-500">${partner.phone}</div>` : ''}
                        </td>
                        <td class="p-4">
                            <div class="font-bold ${balanceClass} wallet-balance">${formatCurrency(balance)}</div>
                            <div class="text-xs text-gray-500">
                                ${balance >= 0 ? 'Available balance' : 'Negative balance'}
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium ${statusClass}">
                                ${partner.status.charAt(0).toUpperCase() + partner.status.slice(1)}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="text-sm text-gray-900">${registeredDate}</div>
                            <div class="text-xs text-gray-500">${formatRelativeTime(partner.created_at)}</div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center space-x-2">
                                <button onclick="editPartner(${partner.id})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deletePartner(${partner.id}, '${partner.first_name} ${partner.last_name}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <!-- <button onclick="viewPartner(${partner.id})" class="p-2 text-orchid-dark hover:bg-gray-100 rounded-lg" title="View Details"> -->
                                <!--     <i class="fas fa-eye"></i> -->
                                <!-- </button> -->
                                <button onclick="adjustPartnerBalance(${partner.id}, '${partner.first_name} ${partner.last_name}', ${balance})" class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Adjust Balance">
                                    <i class="fas fa-wallet"></i>
                                </button>
                                ${partner.status === 'active' ? `
                                    <button onclick="deactivatePartner(${partner.id})" class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg" title="Deactivate">
                                        <i class="fas fa-user-slash"></i>
                                    </button>
                                ` : `
                                    <button onclick="activatePartner(${partner.id})" class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Activate">
                                        <i class="fas fa-user-check"></i>
                                    </button>
                                `}
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            partnersTableBody.innerHTML = html;
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
                                <span class="font-medium">${pagination.total_partners}</span> results
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
            let info = `Showing ${pagination.from}-${pagination.to} of ${pagination.total_partners} partners`;
            
            if (filters.search) {
                info += ` for "${filters.search}"`;
            }
            
            if (filters.status !== 'all') {
                info += `, ${filters.status} status`;
            }
            
            resultsInfo.textContent = info;
        }

        // Change page
        function changePage(page) {
            currentPage = page;
            loadPartners();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Reset filters
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('balanceFilter').value = 'all';
            document.getElementById('dateFrom').value = '';
            document.getElementById('dateTo').value = '';
            document.getElementById('sortBy').value = 'created_at:desc';
            document.getElementById('perPage').value = '10';
            currentPage = 1;
            loadPartners();
        }

        // Partner selection
        function toggleSelectAll(checkbox) {
            const partnerCheckboxes = document.querySelectorAll('.partner-checkbox');
            partnerCheckboxes.forEach(cb => {
                cb.checked = checkbox.checked;
                const partnerId = parseInt(cb.value);
                if (checkbox.checked) {
                    selectedPartners.add(partnerId);
                } else {
                    selectedPartners.delete(partnerId);
                }
            });
        }

        function togglePartnerSelection(partnerId, isChecked) {
            if (isChecked) {
                selectedPartners.add(partnerId);
            } else {
                selectedPartners.delete(partnerId);
                selectAllCheckbox.checked = false;
            }
        }

        // Bulk actions
        function handleBulkAction(select) {
            bulkAction = select.value;
        }

        function applyBulkAction() {
            if (selectedPartners.size === 0) {
                alert('Please select at least one partner');
                return;
            }

            if (!bulkAction) {
                alert('Please select an action');
                return;
            }

            if (bulkAction === 'add_balance' || bulkAction === 'deduct_balance') {
                openBulkBalanceModal();
                return;
            }

            if (confirm(`Are you sure you want to ${bulkAction} ${selectedPartners.size} partner(s)?`)) {
                const formData = new FormData();
                formData.append('action', 'bulk_partner_action');
                formData.append('partner_ids', Array.from(selectedPartners).join(','));
                formData.append('bulk_action', bulkAction);

                fetch('bulk_partners.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        alert(data.message || 'Action completed successfully');
                        loadPartners();
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

        // Edit partner
        function editPartner(partnerId) {
            // Fetch partner data
            const formData = new FormData();
            formData.append('action', 'get_partner');
            formData.append('partner_id', partnerId);

            fetch('get_user_info', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    const partner = data;
                    document.getElementById('editPartnerId').value = partner.id;
                    document.getElementById('editFirstName').value = partner.first_name;
                    document.getElementById('editLastName').value = partner.last_name;
                    document.getElementById('editEmail').value = partner.email;
                    document.getElementById('editPhone').value = partner.phone || '';
                    document.getElementById('editLocation').value = partner.location || '';
                    
                    
                    openEditModal();
                } else {
                    alert(data.message || 'Failed to load partner data');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error occurred');
            });
        }


        function openEditModal() {
            editPartnerModal.classList.add('active');
        }

        function closeEditModal() {
            editPartnerModal.classList.remove('active');
        }

        function updatePartner(event) {
            event.preventDefault();
            
            const partnerId = document.getElementById('editPartnerId').value;
            //const adjustmentAmount = parseFloat(document.getElementById('adjustmentAmount').value) || 0;
            //const adjustmentType = document.getElementById('adjustmentType').value;
            //const adjustmentReason = document.getElementById('adjustmentReason').value;
            const logoFile = document.getElementById('editlogoUpload').files[0];
            
            const formData = new FormData();
            formData.append('partner_id', partnerId);
            formData.append('first_name', document.getElementById('editFirstName').value);
            formData.append('last_name', document.getElementById('editLastName').value);
            formData.append('email', document.getElementById('editEmail').value);
            formData.append('phone', document.getElementById('editPhone').value);
            formData.append('location', document.getElementById('editLocation').value);
            formData.append('logo', logoFile);
            
            // Show loading
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            submitBtn.disabled = true;
            
            fetch('update_partner',{
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    showNotification('Partner updated successfully', 'success');
                    closeEditModal();
                    loadPartners();
                } else {
                    showNotification(data.message || 'Failed to update partner', 'error');
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

        // Delete partner
        function deletePartner(partnerId, partnerName) {
            partnerToDelete = { id: partnerId, name: partnerName };
            document.getElementById('deleteMessage').textContent = 
                `Are you sure you want to delete "${partnerName}"? This action cannot be undone and will permanently remove the partner account.`;
            deleteModal.classList.add('active');
        }

        function openDeleteModal() {
            deleteModal.classList.add('active');
        }

        function closeDeleteModal() {
            deleteModal.classList.remove('active');
            partnerToDelete = null;
        }

        function confirmDelete() {
            if (!partnerToDelete) return;
            
            const formData = new FormData();
            formData.append('id', partnerToDelete.id);
            formData.append('action', 'delete_partners');
            
            fetch('delete_user', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    showNotification(`Partner "${partnerToDelete.name}" deleted successfully`, 'success');
                    closeDeleteModal();
                    loadPartners();
                } else {
                    showNotification(data.message || 'Failed to delete partner', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error occurred');
            });
        }

        // Add partner
        function openAddPartnerModal() {
            addPartnerModal.classList.add('active');
        }

        function closeAddPartnerModal() {
            addPartnerModal.classList.remove('active');
            document.getElementById('addPartnerForm').reset();
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

        // Logo upload functionality
        function previewLogo(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('logoPreviewContainer');
            const previewImage = document.getElementById('logoPreview');
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            
            // Hide URL input if visible
            document.getElementById('logoUrl').classList.add('hidden');
            document.getElementById('useUrlInstead').checked = false;
            
            if (file) {
                // Validate file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    showNotification('Please upload a valid image file (JPEG, PNG, JPG)', 'error');
                    event.target.value = '';
                    return;
                }
                
                // Validate file size (2MB limit)
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                if (file.size > maxSize) {
                    showNotification('File size must be less than 2MB', 'error');
                    event.target.value = '';
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
                
                // Show file info
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                fileInfo.classList.remove('hidden');
            } else {
                previewContainer.classList.add('hidden');
                fileInfo.classList.add('hidden');
            }
        }

        function removeLogo() {
            const fileInput = document.getElementById('logoUpload');
            const previewContainer = document.getElementById('logoPreviewContainer');
            const fileInfo = document.getElementById('fileInfo');
            const logoUrl = document.getElementById('logoUrl');
            
            fileInput.value = '';
            previewContainer.classList.add('hidden');
            fileInfo.classList.add('hidden');
            logoUrl.classList.add('hidden');
            document.getElementById('useUrlInstead').checked = false;
        }

        function previewEditLogo(event) {
            const file = event.target.files[0];
            const editPreviewContainer = document.getElementById('editlogoPreviewContainer');
            const editPreviewImage = document.getElementById('editlogoPreview');
            const editFileInfo = document.getElementById('editfileInfo');
            const editFileName = document.getElementById('editfileName');
            const editFileSize = document.getElementById('editfileSize');
            
            if (file) {
                // Validate file type
                const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!validImageTypes.includes(file.type)) {
                    showNotification('Please upload a valid image file (JPEG, PNG, JPG)', 'error');
                    event.target.value = '';
                    return;
                }
                
                // Validate file size (2MB limit)
                const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
                if (file.size > maxFileSize) {
                    showNotification('File size must be less than 2MB', 'error');
                    event.target.value = '';
                    return;
                }
                
                // Show preview
                const fileReader = new FileReader();
                fileReader.onload = function(e) {
                    editPreviewImage.src = e.target.result;
                    editPreviewContainer.classList.remove('hidden');
                }
                fileReader.readAsDataURL(file);
                
                // Show file info
                editFileName.textContent = file.name;
                editFileSize.textContent = formatFileSize(file.size);
                editFileInfo.classList.remove('hidden');
            } else {
                editPreviewContainer.classList.add('hidden');
                editFileInfo.classList.add('hidden');
            }
        }

        function removeEditLogo() {
            const editFileInput = document.getElementById('editlogoUpload');
            const editPreviewContainer = document.getElementById('editlogoPreviewContainer');
            const editFileInfo = document.getElementById('editfileInfo');
            
            editFileInput.value = '';
            editPreviewContainer.classList.add('hidden');
            editFileInfo.classList.add('hidden');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Updated createPartner function
        function createPartner(event) {
            event.preventDefault();
            
            const logoFile = document.getElementById('logoUpload').files[0];
            const logoUrl = document.getElementById('logoUrl').value;
            const useUrl = document.getElementById('useUrlInstead').checked;
            
            
            // Validate logo - either file or URL should be provided
            if (!logoFile) {
                showNotification('Please upload a logo', 'error');
                return;
            }
            
            // Create FormData for file upload
            const formData = new FormData();
            formData.append('first_name', document.getElementById('addFirstName').value);
            formData.append('last_name', document.getElementById('addLastName').value);
            formData.append('email', document.getElementById('addEmail').value);
            formData.append('phone', document.getElementById('addPhone').value);
            formData.append('location', document.getElementById('addLocation').value);
            formData.append('logo', logoFile);
            // Add logo based on input method
           
            // Show loading
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Creating...';
            submitBtn.disabled = true;
            
            // Send request
            fetch('addpartner', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    showNotification('Partner created successfully', 'success');
                    closeAddPartnerModal();
                    loadPartners();
                } else {
                    //alert(data.message || 'Failed to create partner');
                    showNotification(data.message || 'Failed to create partner', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Network error occurred', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }

        // Partner status actions
        function activatePartner(partnerId) {
            openStatusConfirmModal(partnerId, 'active', 'Activate this partner?', 'Are you sure you want to activate this partner?');
        }

        function deactivatePartner(partnerId) {
            openStatusConfirmModal(partnerId, 'inactive', 'Deactivate this partner?', 'Are you sure you want to deactivate this partner?');
        }

        function openStatusConfirmModal(partnerId, status, title, message) {
            const modal = document.createElement('div');
            modal.className = 'modal active';
            modal.innerHTML = `
                <div class="modal-content max-w-md">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 rounded-full ${status === 'active' ? 'bg-green-100' : 'bg-orange-100'} flex items-center justify-center mx-auto mb-4">
                            <i class="fas ${status === 'active' ? 'fa-check-circle text-green-500' : 'fa-user-slash text-orange-500'} text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">${title}</h3>
                        <p class="text-gray-600 mb-6">${message}</p>
                        
                        <div class="flex justify-center space-x-3">
                            <button onclick="this.closest('.modal').remove()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
                                Cancel
                            </button>
                            <button onclick="updatePartnerStatus(${partnerId}, '${status}'); this.closest('.modal').remove()" class="px-6 py-3 ${status === 'active' ? 'bg-green-600 hover:bg-green-700' : 'bg-orange-600 hover:bg-orange-700'} text-white rounded-lg font-medium">
                                <i class="fas ${status === 'active' ? 'fa-check-circle' : 'fa-user-slash'} mr-2"></i>
                                ${status === 'active' ? 'Activate' : 'Deactivate'}
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        function updatePartnerStatus(partnerId, status) {
            const formData = new FormData();
            formData.append('partner_id', partnerId);
            formData.append('status', status);
            
            fetch('update_account_status', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    showNotification(`Partner ${status === 'active' ? 'activated' : 'deactivated'} successfully`, 'success');
                    loadPartners();
                } else {
                    showNotification(data.message || 'Failed to update partner status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Network error occurred', 'error');
            });
        }

        // Balance adjustment
        function adjustPartnerBalance(partnerId, partnerName, currentBalance) {
            partnerToAdjust = { id: partnerId, name: partnerName, balance: currentBalance };
            document.getElementById('balancePartnerId').value = partnerId;
            document.getElementById('balancePartnerName').value = partnerName;
            document.getElementById('balancePartnerInfo').textContent = partnerName;
            document.getElementById('currentBalance').textContent = formatCurrency(currentBalance);
            
            // Reset form
            document.getElementById('balanceAdjustmentType').value = 'add';
            document.getElementById('balanceAmount').value = '';
            document.getElementById('balanceReason').value = '';
            document.getElementById('balancePreview').classList.add('hidden');
            
            balanceModal.classList.add('active');
        }

        function closeBalanceModal() {
            balanceModal.classList.remove('active');
            partnerToAdjust = null;
        }

        function adjustBalance(event) {
            event.preventDefault();
            
            if (!partnerToAdjust) return;
            
            const amount = parseFloat(document.getElementById('balanceAmount').value);
            const type = document.getElementById('balanceAdjustmentType').value;
            const reason = document.getElementById('balanceReason').value;
            
            if (amount <= 0) {
                showNotification('Please enter a valid amount', 'error');
                return;
            }
            
            if (!reason.trim()) {
                showNotification('Please enter a reason for this adjustment', 'error');
                return;
            }
            
            const formData = new FormData();
            formData.append('partner_id', partnerToAdjust.id);
            formData.append('amount', amount);
            formData.append('type', type);
            formData.append('reason', reason);
            
            // Show loading
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
            submitBtn.disabled = true;
            
            fetch('adjust_partner_balance', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    showNotification('Balance adjusted successfully', 'success');
                    closeBalanceModal();
                    loadPartners();
                } else {
                    showNotification(data.message || 'Failed to adjust balance', 'error');
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

        // Bulk balance modal
        function openBulkBalanceModal() {
            // This would open a separate modal for bulk balance adjustments
            alert(`Bulk balance adjustment for ${selectedPartners.size} partners.\n\nIn a real implementation, this would open a modal to enter amount and reason.`);
            
            // Reset bulk action
            document.getElementById('bulkActions').value = '';
            bulkAction = '';
        }

        // View partner details
        function viewPartner(partnerId) {
            window.location.href = `partner_details.php?id=${partnerId}`;
        }

        // Export partners
        function exportPartners() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const balanceFilter = document.getElementById('balanceFilter').value;
            
            let url = `export_partners.php?search=${encodeURIComponent(search)}&status=${status}&balance_filter=${balanceFilter}`;
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

        function formatCurrency(amount) {
            return new Intl.NumberFormat('en-NG', {
                style: 'currency',
                currency: 'NGN',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(amount);
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
            partnersTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="p-8 text-center">
                        <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Error Loading Partners</h4>
                        <p class="text-gray-500 mb-4">${message}</p>
                        <button onclick="loadPartners()" class="px-4 py-2 bg-orchid-dark text-white rounded-lg hover:bg-orchid-dark/90">
                            <i class="fas fa-redo mr-2"></i>Try Again
                        </button>
                    </td>
                </tr>
            `;
        }
    </script>
</body>
</html>
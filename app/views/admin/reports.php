<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orchid Bakery - Reports & Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        
        /* Chart container styles */
        .chart-container {
            position: relative;
            height: 300px;
        }
        
        /* Date picker styles */
        .date-range-picker {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem;
            background-color: white;
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
    
    <!-- Report Generation Modal -->
    <div id="reportModal" class="modal">
        <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Generate Custom Report</h3>
                    <button onclick="closeReportModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="reportForm" onsubmit="generateCustomReport(event)">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Report Type *</label>
                        <select id="reportType" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent" required>
                            <option value="">Select Report Type</option>
                            <option value="user_activity">User Activity Report</option>
                            <option value="partner_performance">Partner Performance Report</option>
                            <option value="financial_summary">Financial Summary Report</option>
                            <option value="points_analysis">Points Analysis Report</option>
                            <option value="redemption_trends">Redemption Trends Report</option>
                            <option value="withdrawal_analysis">Withdrawal Analysis Report</option>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date Range *</label>
                            <select id="dateRange" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent" required>
                                <option value="last_7_days">Last 7 Days</option>
                                <option value="last_30_days">Last 30 Days</option>
                                <option value="last_quarter">Last Quarter (90 Days)</option>
                                <option value="last_year">Last Year</option>
                                <option value="month_to_date">Month to Date</option>
                                <option value="quarter_to_date">Quarter to Date</option>
                                <option value="year_to_date">Year to Date</option>
                                <option value="custom">Custom Range</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Format *</label>
                            <select id="reportFormat" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent" required>
                                <option value="pdf">PDF Document</option>
                                <option value="excel">Excel Spreadsheet</option>
                                <option value="csv">CSV File</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="customDateRange" class="mb-6 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Custom Date Range</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Start Date</label>
                                <input type="date" id="startDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">End Date</label>
                                <input type="date" id="endDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Include Sections</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-orchid-dark rounded border-gray-300" checked>
                                <span class="ml-2 text-sm text-gray-700">Executive Summary</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-orchid-dark rounded border-gray-300" checked>
                                <span class="ml-2 text-sm text-gray-700">Detailed Charts & Graphs</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-orchid-dark rounded border-gray-300" checked>
                                <span class="ml-2 text-sm text-gray-700">Data Tables</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-orchid-dark rounded border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">Raw Data Export</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-orchid-dark rounded border-gray-300" checked>
                                <span class="ml-2 text-sm text-gray-700">Recommendations & Insights</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex space-x-4">
                        <button type="button" onclick="closeReportModal()" class="flex-1 py-3 px-4 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="flex-1 py-3 px-4 rounded-lg btn-primary">
                            <i class="fas fa-download mr-2"></i> Generate Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="flex h-screen">
        <!-- Sidebar Navigation -->
        <div id="sidebar" class="sidebar w-64 bg-orchid-dark text-white flex flex-col h-full">
            <!-- Logo and Close Button -->
            <div class="p-6 border-b border-orchid-gold/30 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-orchid-gold flex items-center justify-center">
                        <i class="fas fa-bread-slice text-orchid-dark"></i>
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
                        <p class="text-xs text-gray-300">Super Administrator</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="dashboard.html" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="pt-4">
                    <p class="text-xs uppercase text-gray-400 tracking-wider mb-2">User Management</p>
                    <a href="manage-users.html" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-users w-5"></i>
                        <span>Manage Users</span>
                    </a>
                    <a href="register-user.html" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-user-plus w-5"></i>
                        <span>Register User</span>
                    </a>
                </div>
                
                <div class="pt-2">
                    <p class="text-xs uppercase text-gray-400 tracking-wider mb-2">Partner Management</p>
                    <a href="manage-partners.html" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-handshake w-5"></i>
                        <span>Manage Partners</span>
                    </a>
                    <a href="register-partner.html" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-store w-5"></i>
                        <span>Register Partner</span>
                    </a>
                </div>
                
                <div class="pt-2">
                    <p class="text-xs uppercase text-gray-400 tracking-wider mb-2">Points & Rewards</p>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-coins w-5"></i>
                        <span>Points Configuration</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-adjust w-5"></i>
                        <span>Adjust Points</span>
                    </a>
                </div>
                
                <div class="pt-2">
                    <p class="text-xs uppercase text-gray-400 tracking-wider mb-2">Financial Management</p>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-wallet w-5"></i>
                        <span>Partner Wallets</span>
                    </a>
                    <a href="withdrawal-requests.html" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-money-check-alt w-5"></i>
                        <span>Withdrawal Requests</span>
                    </a>
                </div>
                
                <div class="pt-2">
                    <p class="text-xs uppercase text-gray-400 tracking-wider mb-2">Reporting</p>
                    <a href="reports-analytics.html" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg bg-orchid-gold/10">
                        <i class="fas fa-chart-bar w-5"></i>
                        <span>Reports & Analytics</span>
                    </a>
                    <a href="transaction-logs.html" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-history w-5"></i>
                        <span>Transaction Logs</span>
                    </a>
                </div>
                
                <div class="pt-2">
                    <p class="text-xs uppercase text-gray-400 tracking-wider mb-2">System</p>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-cog w-5"></i>
                        <span>Settings</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-shield-alt w-5"></i>
                        <span>Access Control</span>
                    </a>
                </div>
            </nav>
            
            <!-- Logout -->
            <div class="p-4 border-t border-orchid-gold/30">
                <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-900/30">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
        
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
                        <h2 class="text-xl font-semibold text-gray-800">Reports & Analytics</h2>
                        <p class="text-sm text-gray-500">Data insights and business intelligence dashboard</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i class="fas fa-bell text-gray-500 text-xl"></i>
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-orchid-gold text-white rounded-full text-xs flex items-center justify-center">2</span>
                    </div>
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-medium" id="currentDate">Monday, 20 Nov 2023</p>
                    </div>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Date Range Selector and Quick Stats -->
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                        <div>
                            <h3 class="font-bold text-gray-800">Platform Performance Dashboard</h3>
                            <p class="text-sm text-gray-500">Last updated: Today, 9:30 AM</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <div class="date-range-picker">
                                <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                <select id="dashboardDateRange" class="border-0 focus:ring-0 text-sm" onchange="updateDashboardCharts()">
                                    <option value="last_7_days">Last 7 Days</option>
                                    <option value="last_30_days" selected>Last 30 Days</option>
                                    <option value="last_quarter">Last Quarter</option>
                                    <option value="last_year">Last Year</option>
                                </select>
                            </div>
                            <button onclick="openReportModal()" class="px-4 py-3 rounded-lg btn-primary font-medium">
                                <i class="fas fa-file-export mr-2"></i> Generate Report
                            </button>
                        </div>
                    </div>
                    
                    <!-- Key Performance Indicators -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-gradient-to-r from-orchid-dark to-orchid-dark/90 rounded-xl p-4 text-white">
                            <p class="text-sm opacity-90">Total Users</p>
                            <p class="text-2xl font-bold mt-2">2,847</p>
                            <p class="text-xs opacity-90 mt-1"><i class="fas fa-arrow-up mr-1"></i>12% growth</p>
                        </div>
                        <div class="bg-gradient-to-r from-orchid-gold to-orchid-gold/90 rounded-xl p-4 text-white">
                            <p class="text-sm opacity-90">Active Partners</p>
                            <p class="text-2xl font-bold mt-2">48</p>
                            <p class="text-xs opacity-90 mt-1"><i class="fas fa-store mr-1"></i>3 new this month</p>
                        </div>
                        <div class="bg-gradient-to-r from-blue-600 to-blue-500 rounded-xl p-4 text-white">
                            <p class="text-sm opacity-90">Points Redeemed</p>
                            <p class="text-2xl font-bold mt-2">124.5K</p>
                            <p class="text-xs opacity-90 mt-1"><i class="fas fa-exchange-alt mr-1"></i>8% increase</p>
                        </div>
                        <div class="bg-gradient-to-r from-green-600 to-green-500 rounded-xl p-4 text-white">
                            <p class="text-sm opacity-90">Revenue Impact</p>
                            <p class="text-2xl font-bold mt-2">$42.8K</p>
                            <p class="text-xs opacity-90 mt-1"><i class="fas fa-chart-line mr-1"></i>15% growth</p>
                        </div>
                    </div>
                </div>
                
                <!-- Main Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- User Growth Chart -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="font-bold text-gray-800">User Growth Trend</h3>
                                <p class="text-sm text-gray-500">New registrations over time</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-arrow-up mr-1"></i>12.5%
                                </span>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                        <div class="mt-4 flex justify-between text-sm text-gray-500">
                            <span>Oct 2023</span>
                            <span>Nov 2023</span>
                        </div>
                    </div>
                    
                    <!-- Points Distribution Chart -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="font-bold text-gray-800">Points Distribution</h3>
                                <p class="text-sm text-gray-500">User points by tier level</p>
                            </div>
                            <div class="text-sm text-gray-500">
                                Total: <span class="font-bold text-orchid-gold">1.2M Points</span>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="pointsDistributionChart"></canvas>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-orchid-dark mr-2"></div>
                                <span>Bronze (0-500)</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-orchid-gold mr-2"></div>
                                <span>Silver (501-2000)</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Partner Performance Section -->
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-bold text-gray-800">Top Performing Partners</h3>
                            <p class="text-sm text-gray-500">Based on redemptions and revenue</p>
                        </div>
                        <a href="#" class="text-sm text-orchid-dark font-medium">View All Partners</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Partner</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Redemptions</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Revenue</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Avg. Points/Redemption</th>
                                    <th class="text-left p-4 text-sm font-medium text-gray-600">Performance Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="p-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center mr-3">
                                                <i class="fas fa-coffee text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">Coffee Haven</p>
                                                <p class="text-xs text-gray-500">Cafe</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold">342</p>
                                        <p class="text-xs text-green-600"><i class="fas fa-arrow-up mr-1"></i>15%</p>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold text-green-600">$12,450.75</p>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold text-orchid-gold">250</p>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-green-500 h-2 rounded-full" style="width: 92%"></div>
                                            </div>
                                            <span class="text-sm font-bold">92%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="p-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center mr-3">
                                                <i class="fas fa-shopping-bag text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">Tech Gadgets Store</p>
                                                <p class="text-xs text-gray-500">Retail</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold">456</p>
                                        <p class="text-xs text-green-600"><i class="fas fa-arrow-up mr-1"></i>22%</p>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold text-green-600">$15,200.00</p>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold text-orchid-gold">500</p>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-green-500 h-2 rounded-full" style="width: 88%"></div>
                                            </div>
                                            <span class="text-sm font-bold">88%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="p-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center mr-3">
                                                <i class="fas fa-utensils text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">Green Leaf Restaurant</p>
                                                <p class="text-xs text-gray-500">Restaurant</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold">178</p>
                                        <p class="text-xs text-green-600"><i class="fas fa-arrow-up mr-1"></i>8%</p>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold text-green-600">$6,500.25</p>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold text-orchid-gold">300</p>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-blue-500 h-2 rounded-full" style="width: 78%"></div>
                                            </div>
                                            <span class="text-sm font-bold">78%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center mr-3">
                                                <i class="fas fa-concierge-bell text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">Sunset Spa</p>
                                                <p class="text-xs text-gray-500">Service</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold">89</p>
                                        <p class="text-xs text-red-600"><i class="fas fa-arrow-down mr-1"></i>5%</p>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold text-green-600">$3,200.75</p>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold text-orchid-gold">450</p>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 65%"></div>
                                            </div>
                                            <span class="text-sm font-bold">65%</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Financial Analytics Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Revenue Trend Chart -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="font-bold text-gray-800">Revenue Trend</h3>
                                <p class="text-sm text-gray-500">Monthly platform revenue</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-green-600">$42,850</p>
                                <p class="text-xs text-gray-500">Year to Date</p>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="revenueTrendChart"></canvas>
                        </div>
                    </div>
                    
                    <!-- Redemption vs Withdrawal Chart -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="font-bold text-gray-800">Redemption vs Withdrawal</h3>
                                <p class="text-sm text-gray-500">Points flow analysis</p>
                            </div>
                            <div class="text-sm">
                                <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 mr-2">Redemption</span>
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-800">Withdrawal</span>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="redemptionWithdrawalChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Report Templates Section -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-bold text-gray-800">Report Templates</h3>
                            <p class="text-sm text-gray-500">Pre-configured reports for quick access</p>
                        </div>
                        <button onclick="openReportModal()" class="px-4 py-2 rounded-lg border border-orchid-dark text-orchid-dark font-medium hover:bg-orchid-dark/5">
                            <i class="fas fa-plus mr-2"></i> Create Custom
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="border border-gray-200 rounded-lg p-5 hover:border-orchid-dark transition-colors">
                            <div class="flex items-start mb-4">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-users text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">User Activity Report</h4>
                                    <p class="text-sm text-gray-500">Registration, engagement & retention</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Updated: Daily</span>
                                <button onclick="generateQuickReport('user_activity')" class="px-3 py-1 rounded-lg bg-blue-100 text-blue-600 text-sm font-medium hover:bg-blue-200">
                                    Generate
                                </button>
                            </div>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-5 hover:border-orchid-dark transition-colors">
                            <div class="flex items-start mb-4">
                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-handshake text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Partner Performance</h4>
                                    <p class="text-sm text-gray-500">Redemptions, revenue & ROI</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Updated: Weekly</span>
                                <button onclick="generateQuickReport('partner_performance')" class="px-3 py-1 rounded-lg bg-green-100 text-green-600 text-sm font-medium hover:bg-green-200">
                                    Generate
                                </button>
                            </div>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-5 hover:border-orchid-dark transition-colors">
                            <div class="flex items-start mb-4">
                                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Financial Summary</h4>
                                    <p class="text-sm text-gray-500">Revenue, costs & profitability</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Updated: Monthly</span>
                                <button onclick="generateQuickReport('financial_summary')" class="px-3 py-1 rounded-lg bg-purple-100 text-purple-600 text-sm font-medium hover:bg-purple-200">
                                    Generate
                                </button>
                            </div>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-5 hover:border-orchid-dark transition-colors">
                            <div class="flex items-start mb-4">
                                <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-coins text-orange-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Points Analysis</h4>
                                    <p class="text-sm text-gray-500">Earning, burning & distribution</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Updated: Weekly</span>
                                <button onclick="generateQuickReport('points_analysis')" class="px-3 py-1 rounded-lg bg-orange-100 text-orange-600 text-sm font-medium hover:bg-orange-200">
                                    Generate
                                </button>
                            </div>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-5 hover:border-orchid-dark transition-colors">
                            <div class="flex items-start mb-4">
                                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-exchange-alt text-red-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Redemption Trends</h4>
                                    <p class="text-sm text-gray-500">Patterns, frequency & preferences</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Updated: Daily</span>
                                <button onclick="generateQuickReport('redemption_trends')" class="px-3 py-1 rounded-lg bg-red-100 text-red-600 text-sm font-medium hover:bg-red-200">
                                    Generate
                                </button>
                            </div>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-5 hover:border-orchid-dark transition-colors">
                            <div class="flex items-start mb-4">
                                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-money-check-alt text-indigo-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Withdrawal Analysis</h4>
                                    <p class="text-sm text-gray-500">Frequency, amounts & processing</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Updated: Weekly</span>
                                <button onclick="generateQuickReport('withdrawal_analysis')" class="px-3 py-1 rounded-lg bg-indigo-100 text-indigo-600 text-sm font-medium hover:bg-indigo-200">
                                    Generate
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Insights & Recommendations -->
                <div class="mt-8 bg-gradient-to-r from-orchid-dark to-orchid-gold rounded-xl shadow p-6 text-white">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="font-bold text-xl">Insights & Recommendations</h3>
                            <p class="opacity-90">AI-powered business intelligence</p>
                        </div>
                        <div class="px-3 py-1 rounded-full bg-white/20 text-sm">
                            <i class="fas fa-brain mr-2"></i> AI Analysis
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white/10 rounded-lg p-4 backdrop-blur-sm">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center mr-3">
                                    <i class="fas fa-thumbs-up text-green-300"></i>
                                </div>
                                <h4 class="font-bold">Top Performing Segment</h4>
                            </div>
                            <p class="text-sm opacity-90">Cafe partners are showing 35% higher redemption rates compared to other categories. Consider expanding cafe partnerships in urban areas.</p>
                        </div>
                        
                        <div class="bg-white/10 rounded-lg p-4 backdrop-blur-sm">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full bg-yellow-500/20 flex items-center justify-center mr-3">
                                    <i class="fas fa-exclamation-triangle text-yellow-300"></i>
                                </div>
                                <h4 class="font-bold">Attention Needed</h4>
                            </div>
                            <p class="text-sm opacity-90">User engagement drops by 40% after 90 days of inactivity. Consider implementing a re-engagement campaign for dormant users.</p>
                        </div>
                        
                        <div class="bg-white/10 rounded-lg p-4 backdrop-blur-sm">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center mr-3">
                                    <i class="fas fa-lightbulb text-blue-300"></i>
                                </div>
                                <h4 class="font-bold">Opportunity Identified</h4>
                            </div>
                            <p class="text-sm opacity-90">Weekend redemptions are 65% higher than weekdays. Consider promoting weekend-specific partner offers to increase engagement.</p>
                        </div>
                        
                        <div class="bg-white/10 rounded-lg p-4 backdrop-blur-sm">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full bg-purple-500/20 flex items-center justify-center mr-3">
                                    <i class="fas fa-chart-pie text-purple-300"></i>
                                </div>
                                <h4 class="font-bold">Trend Analysis</h4>
                            </div>
                            <p class="text-sm opacity-90">Points redemption velocity has increased by 22% month-over-month. Monitor partner liquidity to ensure sufficient funds for withdrawals.</p>
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
        // Chart instances
        let userGrowthChart, pointsDistributionChart, revenueTrendChart, redemptionWithdrawalChart;
        
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
        
        // Modal functions
        function openReportModal() {
            document.getElementById('reportModal').classList.add('active');
            
            // Show/hide custom date range based on selection
            document.getElementById('dateRange').addEventListener('change', function() {
                const customRange = document.getElementById('customDateRange');
                if (this.value === 'custom') {
                    customRange.classList.remove('hidden');
                } else {
                    customRange.classList.add('hidden');
                }
            });
        }
        
        function closeReportModal() {
            document.getElementById('reportModal').classList.remove('active');
        }
        
        function generateCustomReport(event) {
            event.preventDefault();
            
            const reportType = document.getElementById('reportType').value;
            const dateRange = document.getElementById('dateRange').value;
            const format = document.getElementById('reportFormat').value;
            
            if (!reportType) {
                showNotification('Please select a report type', 'warning');
                return;
            }
            
            // In a real app, this would generate and download the report
            showNotification(`Generating ${reportType.replace('_', ' ')} report in ${format.toUpperCase()} format...`, 'info');
            
            // Simulate report generation
            setTimeout(() => {
                showNotification('Report generated successfully! Download will begin shortly.', 'success');
                closeReportModal();
            }, 2000);
        }
        
        function generateQuickReport(reportType) {
            // Quick report generation
            const reportNames = {
                'user_activity': 'User Activity Report',
                'partner_performance': 'Partner Performance Report',
                'financial_summary': 'Financial Summary Report',
                'points_analysis': 'Points Analysis Report',
                'redemption_trends': 'Redemption Trends Report',
                'withdrawal_analysis': 'Withdrawal Analysis Report'
            };
            
            showNotification(`Generating ${reportNames[reportType]}...`, 'info');
            
            // Simulate report generation
            setTimeout(() => {
                showNotification(`${reportNames[reportType]} generated successfully!`, 'success');
            }, 1500);
        }
        
        // Chart initialization and functions
        function initializeCharts() {
            // User Growth Chart (Line Chart)
            const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
            userGrowthChart = new Chart(userGrowthCtx, {
                type: 'line',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8'],
                    datasets: [{
                        label: 'New Users',
                        data: [45, 52, 48, 65, 72, 68, 80, 85],
                        borderColor: '#013220',
                        backgroundColor: 'rgba(1, 50, 32, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Points Distribution Chart (Doughnut Chart)
            const pointsDistributionCtx = document.getElementById('pointsDistributionChart').getContext('2d');
            pointsDistributionChart = new Chart(pointsDistributionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Bronze (0-500)', 'Silver (501-2000)', 'Gold (2001-5000)', 'Platinum (5000+)'],
                    datasets: [{
                        data: [45, 30, 15, 10],
                        backgroundColor: [
                            '#013220', // orchid-dark
                            '#CC9933', // orchid-gold
                            '#6b7280', // gray
                            '#10b981'  // green
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });
            
            // Revenue Trend Chart (Bar Chart)
            const revenueTrendCtx = document.getElementById('revenueTrendChart').getContext('2d');
            revenueTrendChart = new Chart(revenueTrendCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
                    datasets: [{
                        label: 'Revenue ($)',
                        data: [3200, 2800, 3500, 4200, 4800, 5200, 5800, 6200, 6800, 7500, 8200],
                        backgroundColor: '#10b981',
                        borderColor: '#10b981',
                        borderWidth: 0,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Redemption vs Withdrawal Chart (Line Chart)
            const redemptionWithdrawalCtx = document.getElementById('redemptionWithdrawalChart').getContext('2d');
            redemptionWithdrawalChart = new Chart(redemptionWithdrawalCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
                    datasets: [
                        {
                            label: 'Points Redeemed',
                            data: [4500, 5200, 4800, 6100, 7200, 6800, 8000, 8500, 9200, 9800, 10500],
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Withdrawals ($)',
                            data: [1200, 1500, 1300, 1800, 2200, 2000, 2500, 2800, 3000, 3200, 3500],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
        
        function updateDashboardCharts() {
            const dateRange = document.getElementById('dashboardDateRange').value;
            
            // In a real app, this would fetch new data based on the date range
            // For now, we'll just show a notification
            showNotification(`Updating charts for ${dateRange.replace('_', ' ')}...`, 'info');
            
            // Simulate data update
            setTimeout(() => {
                showNotification('Dashboard updated successfully!', 'success');
            }, 1000);
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
            initializeCharts();
            
            // Update date
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
            
            // Handle window resize for sidebar
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    closeSidebar();
                }
            });
        });
    </script>
</body>
</html>
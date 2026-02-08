<!DOCTYPE html>
<html lang="en">
<head>
   <?php echo $metaTags; ?>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Apply Open Sans as default */
        body {
            font-family: 'Open Sans', sans-serif;
            overflow-x: hidden;
        }
        
        /* Font utility classes */
        .font-heading {
            font-family: 'Montserrat', sans-serif;
        }
        .font-body {
            font-family: 'Open Sans', sans-serif;
        }
        
        /* Color variables */
        .orchid-bg {
            background-color: #013220;
        }
        .gold-bg {
            background-color: #CC9933;
        }
        .orchid-gradient {
            background: linear-gradient(135deg, #013220 0%, #0a4d2e 100%);
        }
        .gold-gradient {
            background: linear-gradient(135deg, #CC9933 0%, #e0b450 100%);
        }
        
        /* Sidebar Styles - Fixed for mobile */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            z-index: 1000;
            background-color: #013220;
            color: white;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15);
            will-change: transform;
        }
        
        .sidebar.active {
            transform: translateX(0);
        }
        
        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out;
        }
        
        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Mobile menu button - Fixed position */
        .menu-toggle {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1100;
            transition: transform 0.3s ease;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .menu-toggle.active .bar:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        .menu-toggle.active .bar:nth-child(2) {
            opacity: 0;
        }
        
        .menu-toggle.active .bar:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }
        
        /* Responsive adjustments */
        @media (min-width: 1024px) {
            .sidebar {
                transform: translateX(0);
                width: 280px;
            }
            
            .sidebar-overlay {
                display: none;
            }
            
            .menu-toggle {
                display: none;
            }
            
            main {
                margin-left: 280px;
            }
        }
        
        /* Mobile specific adjustments */
        @media (max-width: 640px) {
            .sidebar {
                width: 85%;
                max-width: 300px;
            }
            
            .menu-toggle {
                top: 0.75rem;
                left: 0.75rem;
                width: 40px;
                height: 40px;
            }
            
            /* Adjust main content padding for mobile */
            
            /* Reduce padding on smaller screens */
            .container-padding {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }
        }
        
        @media (max-width: 1023px) {
            main {
                margin-left: 0 !important;
            }
        }
        
        /* Smooth scroll for sidebar */
        .sidebar-content {
            height: calc(100vh - 180px);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #CC9933 #013220;
            -webkit-overflow-scrolling: touch;
        }
        
        .sidebar-content::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar-content::-webkit-scrollbar-track {
            background: #013220;
        }
        
        .sidebar-content::-webkit-scrollbar-thumb {
            background-color: #CC9933;
            border-radius: 20px;
        }

        /* Card hover effects */
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Progress bar animation */
        .progress-bar {
            transition: width 1s ease-in-out;
        }

        /* Notification pulse */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Prevent horizontal scroll on mobile */
        .no-horizontal-scroll {
            max-width: 100%;
            overflow-x: hidden;
        }
        
        /* Safe area for mobile notches */
        .safe-area-top {
            padding-top: env(safe-area-inset-top);
        }
        
        .safe-area-bottom {
            padding-bottom: env(safe-area-inset-bottom);
        }
        
        /* Mobile optimized buttons */
        .mobile-tap-target {
            min-height: 44px;
            min-width: 44px;
        }
        
        /* Touch-friendly spacing */
        .touch-spacing {
            margin-bottom: 0.75rem;
        }
        
        /* Optimize font sizes for mobile */
        @media (max-width: 640px) {
            .mobile-text-sm {
                font-size: 0.875rem !important;
            }
            
            .mobile-text-base {
                font-size: 1rem !important;
            }
            
            .mobile-text-lg {
                font-size: 1.125rem !important;
            }
            
            .mobile-text-xl {
                font-size: 1.25rem !important;
            }
            
            .mobile-text-2xl {
                font-size: 1.5rem !important;
            }
            
            .mobile-text-3xl {
                font-size: 1.75rem !important;
            }
            
            .mobile-text-4xl {
                font-size: 2rem !important;
            }
            
            .mobile-p-4 {
                padding: 1rem !important;
            }
            
            .mobile-p-6 {
                padding: 1.25rem !important;
            }
        }
        
        /* Partner specific styles */
        .wallet-card {
            background: linear-gradient(135deg, #013220 0%, #0a4d2e 100%);
            border-radius: 16px;
            position: relative;
            overflow: hidden;
        }
        
        .wallet-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.1;
            transform: rotate(30deg);
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            border-color: #013220;
            box-shadow: 0 8px 25px rgba(1, 50, 32, 0.1);
        }
        
        .redemption-history-item {
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s ease;
        }
        
        .redemption-history-item:hover {
            background-color: #f9fafb;
        }
        
        .redemption-history-item:last-child {
            border-bottom: none;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .status-refunded {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        /* Empty state styling */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
            text-align: center;
        }
        
        .empty-state-icon {
            width: 64px;
            height: 64px;
            background-color: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        /* Table responsive styles */
        @media (max-width: 768px) {
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .table-responsive table {
                min-width: 768px;
            }
        }
        
        /* Loading animation */
        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body class="bg-gray-50 font-body no-horizontal-scroll">
    <!-- Mobile Menu Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Mobile Menu Button - Fixed position -->
    <button id="menuToggle" class="menu-toggle mobile-tap-target lg:hidden">
        <div class="w-6 h-6 flex flex-col justify-center items-center">
            <span class="bar w-5 h-0.5 bg-gray-700 mb-1.5 transition-all duration-300"></span>
            <span class="bar w-5 h-0.5 bg-gray-700 mb-1.5 transition-all duration-300"></span>
            <span class="bar w-5 h-0.5 bg-gray-700 transition-all duration-300"></span>
        </div>
    </button>

    <!-- Sidebar -->
    <?php include __DIR__ . '/../includes/partner_sidebar.php'; ?>

    <!-- Main Content - Adjusted for mobile -->
    <main class="min-h-screen transition-all duration-300 lg:ml-[280px] safe-area-top" id="mainContent">
        <!-- Top Bar - Fixed for mobile -->
        <div class="bg-white border-b border-gray-200 px-4 lg:px-6 py-4 fixed top-0 right-0 left-0 z-40 shadow-sm lg:relative lg:top-auto lg:right-auto lg:left-auto">
            <div class="flex justify-between items-center">
                <!-- Mobile: Show page title, Desktop: Show search -->
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-900 font-heading mobile-text-lg lg:ml-[10px] ml-[60px]">Partner Dashboard</h1>
                </div>
                
                <!-- Right side icons -->
                <div class="flex items-center space-x-3 lg:space-x-4">
                    <!-- Wallet Balance Badge -->
                    <div class="hidden lg:flex items-center bg-green-50 px-3 py-1.5 rounded-lg">
                        <i class="fas fa-wallet text-green-600 mr-2"></i>
                        <span class="text-green-700 font-bold font-heading">
                            ₦<?php echo number_format($fetchuserdetails['wallet_balance'] ?? 0, 2); ?>
                        </span>
                    </div>
                   
                    
                    <!-- User Menu -->
                    <div class="relative">
                        <button class="flex items-center space-x-2 p-1 rounded-lg hover:bg-gray-100 transition mobile-tap-target" id="userMenuBtn">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#013220] to-[#0a4d2e] flex items-center justify-center">
                                <span class="text-white text-sm font-bold">
                                    <?php 
                                        echo $initials;
                                    ?>
                                </span>
                            </div>
                         
                            <span class="hidden lg:inline text-gray-700 font-heading"><?php echo $fetchuserdetails['first_name'].' '.$fetchuserdetails['last_name'] ?></span>
                            
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Content - Adjusted padding for mobile -->
        <div class="p-4 lg:p-6 container-padding">
            <!-- Welcome Section -->
            <div class="mb-6 touch-spacing mt-20 lg:mt-0">
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 font-heading mobile-text-2xl">
                    Welcome, <?php echo $fetchuserdetails['first_name']. ' '. $fetchuserdetails['last_name']; ?>! 🏪
                </h1>
                <p class="text-gray-600 mt-2 mobile-text-sm">
                    <?php echo date('l, F j, Y'); ?> • 
                    <span class="text-green-600 font-semibold">
                        <?php echo $fetchuserdetails['status'] == 'active' ? '● Active' : '● Inactive'; ?>
                    </span>
                </p>
            </div>

            <!-- Wallet Balance Card - Stacked on mobile -->
            <div class="wallet-card text-white mb-6 card-hover transition-all duration-300 mobile-p-4 p-6">
                <div class="relative z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between">
                        <div class="mb-4 lg:mb-0">
                            <p class="text-gray-300 font-body mobile-text-sm">Available Wallet Balance</p>
                            <h2 class="text-3xl lg:text-4xl font-bold mt-1 font-heading mobile-text-3xl">
                                ₦<?php echo number_format($fetchuserdetails['wallet_balance'] ?? 0, 2); ?>
                            </h2>
                            <p class="text-gray-300 mt-2 font-body mobile-text-sm">
                                <i class="fas fa-info-circle mr-1"></i>
                                This balance is available for withdrawal
                            </p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="withdraw.php" 
                               class="bg-white text-[#013220] hover:bg-gray-100 px-4 py-3 rounded-lg font-semibold text-center transition-colors duration-200 mobile-tap-target">
                                <i class="fas fa-money-bill-wave mr-2"></i>
                                Withdraw Funds
                            </a>
                            <a href="transactions.php" 
                               class="bg-transparent border-2 border-white hover:bg-white/10 px-4 py-3 rounded-lg font-semibold text-center transition-colors duration-200 mobile-tap-target">
                                <i class="fas fa-history mr-2"></i>
                                View Transactions
                            </a>
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 pt-6 border-t border-white/20">
                        <div>
                            <p class="text-gray-300 font-body text-sm">Pending Withdrawals</p>
                            <p class="text-xl font-bold mt-1 font-heading">
                                ₦<?php echo number_format($partnersStat['pending_withdrawals'] ?? 0, 2); ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-300 font-body text-sm">Total Processed</p>
                            <p class="text-xl font-bold mt-1 font-heading">
                                ₦<?php echo number_format($partnersStat['total_processed'] ?? 0, 2); ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-300 font-body text-sm">Last Withdrawal</p>
                            <p class="text-xl font-bold mt-1 font-heading">
                                <?php 
                                    if (isset($partnersStat['last_withdrawal_date']) && $partnersStat['last_withdrawal_date']) {
                                        echo date('M j, Y', strtotime($partnersStat['last_withdrawal_date']));
                                    } else {
                                        echo 'Never';
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats - Grid adjusts for mobile -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
                <!-- Total Redemptions -->
                <div class="stat-card p-4 lg:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 font-heading mobile-text-sm">Total Redemptions</p>
                            <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mt-1 font-heading mobile-text-xl">
                                <?php echo number_format($partnersStat['total_redemptions'] ?? 0); ?>
                            </h3>
                            <p class="text-xs lg:text-sm text-gray-500 mt-1 font-body">All time</p>
                        </div>
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-gift text-blue-600 lg:text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- This Month Redemptions -->
                <div class="stat-card p-4 lg:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 font-heading mobile-text-sm">This Month</p>
                            <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mt-1 font-heading mobile-text-xl">
                                <?php echo number_format($partnersStat['monthly_redemptions'] ?? 0); ?>
                            </h3>
                            <?php if (isset($partnersStat['redemption_growth'])): ?>
                                <p class="text-xs lg:text-sm <?php echo $partnersStat['redemption_growth'] >= 0 ? 'text-green-600' : 'text-red-600'; ?> mt-1 font-body">
                                    <i class="fas fa-arrow-<?php echo $partnersStat['redemption_growth'] >= 0 ? 'up' : 'down'; ?> mr-1"></i>
                                    <?php echo abs($partnersStat['redemption_growth']); ?>% from last month
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-chart-line text-purple-600 lg:text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Today's Redemptions -->
                <div class="stat-card p-4 lg:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 font-heading mobile-text-sm">Today's Redemptions</p>
                            <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mt-1 font-heading mobile-text-xl">
                                <?php echo number_format($partnersStat['today_redemptions'] ?? 0); ?>
                            </h3>
                            <p class="text-xs lg:text-sm text-gray-500 mt-1 font-body">Last updated: <?php echo date('g:i A'); ?></p>
                        </div>
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-calendar-day text-green-600 lg:text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Redemptions & Quick Actions - Stack on mobile -->
            <div class="flex flex-col lg:flex-row gap-4 lg:gap-6 mb-6">
                <!-- Recent Redemptions -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-xl shadow h-full">
                        <div class="p-4 lg:p-6 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900 font-heading mobile-text-lg">Recent Redemptions</h3>
                                <a href="redemptions.php" class="text-sm text-[#CC9933] hover:text-[#b3862d] font-heading">
                                    View All
                                </a>
                            </div>
                        </div>
                        <div class="p-0">
                            <?php if (!empty($recentRedemptions)): ?>
                                <div class="table-responsive">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Customer
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Amount
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Points
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Date
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <?php foreach ($recentRedemptions as $redemption): ?>
                                            <tr class="redemption-history-item">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                            <span class="text-gray-600 text-sm font-medium">
                                                                <?php echo strtoupper(substr($redemption['customer_name'], 0, 1)); ?>
                                                            </span>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                <?php echo htmlspecialchars($redemption['customer_name']); ?>
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                <?php echo htmlspecialchars($redemption['customer_phone'] ?? 'N/A'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 font-semibold">
                                                        ₦<?php echo number_format($redemption['amount'], 2); ?>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        <?php echo number_format($redemption['points']); ?>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <?php 
                                                        $statusClass = 'status-pending';
                                                        $statusText = 'Pending';
                                                        
                                                        switch($redemption['status']) {
                                                            case 'completed':
                                                                $statusClass = 'status-completed';
                                                                $statusText = 'Completed';
                                                                break;
                                                            case 'cancelled':
                                                                $statusClass = 'status-cancelled';
                                                                $statusText = 'Cancelled';
                                                                break;
                                                            case 'refunded':
                                                                $statusClass = 'status-refunded';
                                                                $statusText = 'Refunded';
                                                                break;
                                                            default:
                                                                $statusClass = 'status-pending';
                                                                $statusText = 'Pending';
                                                        }
                                                    ?>
                                                    <span class="status-badge <?php echo $statusClass; ?>">
                                                        <?php echo $statusText; ?>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?php echo date('M j, g:i A', strtotime($redemption['created_at'])); ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="redemption-details.php?id=<?php echo $redemption['id']; ?>" 
                                                       class="text-[#013220] hover:text-[#0a4d2e] mr-3">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php if ($redemption['status'] == 'pending'): ?>
                                                        <a href="#" 
                                                        class="text-green-600 hover:text-green-900"
                                                        onclick="processRedemption(<?php echo $redemption['id']; ?>)">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="empty-state py-12">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-gift text-gray-400 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No redemptions yet</h3>
                                    <p class="text-gray-500 mb-4">When customers redeem points at your store, they will appear here.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions & Stats -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-xl shadow h-full">
                        <div class="p-4 lg:p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 font-heading mobile-text-lg">Quick Actions</h3>
                        </div>
                        <div class="p-4 lg:p-6">
                            <div class="space-y-4">
                                <!-- Process Redemption -->
                                <a href="process-redemption.php" 
                                   class="flex items-center p-3 bg-gradient-to-r from-[#013220] to-[#0a4d2e] text-white rounded-lg hover:shadow-lg transition-all duration-300 mobile-tap-target">
                                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
                                        <i class="fas fa-qrcode"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold">Process Redemption</p>
                                        <p class="text-sm text-white/80">Collect redemption code</p>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </a>

                                <!-- Manage Products -->
                                <a href="products.php" 
                                   class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-all duration-300 mobile-tap-target">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-box text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">View Redemtion History</p>
                                        <p class="text-sm text-gray-600">See all redemption history</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </a>
                            </div>

                            <!-- Quick Stats -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Today's Summary</h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 text-sm">Redemptions</span>
                                        <span class="font-bold text-gray-900"><?php echo number_format($partnersStat['today_redemptions'] ?? 0); ?></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 text-sm">Revenue</span>
                                        <span class="font-bold text-green-600">₦<?php echo number_format($partnersStat['today_revenue'] ?? 0, 2); ?></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 text-sm">Avg. Transaction</span>
                                        <span class="font-bold text-blue-600">₦<?php 
                                            $avg = ($partnersStat['today_redemptions'] ?? 0) > 0 
                                                ? ($partnersStat['today_revenue'] ?? 0) / $partnersStat['today_redemptions'] 
                                                : 0;
                                            echo number_format($avg, 2);
                                        ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 px-4 lg:px-6 py-4 mt-6 safe-area-bottom">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-3 md:mb-0">
                    <p class="text-gray-600 text-xs lg:text-sm font-body text-center md:text-left">
                        © <?php echo date('Y'); ?> Orchid Bakery Partner Portal
                    </p>
                </div>
                <div class="flex flex-wrap justify-center gap-3 lg:gap-6">
                    <a href="#" class="text-gray-500 hover:text-[#013220] text-xs lg:text-sm font-body">Privacy</a>
                    <a href="#" class="text-gray-500 hover:text-[#013220] text-xs lg:text-sm font-body">Terms</a>
                    <a href="support.php" class="text-gray-500 hover:text-[#013220] text-xs lg:text-sm font-body">Support</a>
                    <a href="contact.php" class="text-gray-500 hover:text-[#013220] text-xs lg:text-sm font-body">Contact</a>
                </div>
            </div>
        </footer>
    </main>

    <script>
        // Sidebar functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('menuToggle');
        const closeSidebar = document.getElementById('closeSidebar');
        const mainContent = document.getElementById('mainContent');
        
        // Function to open sidebar
        function openSidebar() {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
            menuToggle.classList.add('active');
            document.body.style.overflow = 'hidden';
            // Prevent scrolling on main content
            mainContent.style.overflow = 'hidden';
        }

        // Function to close sidebar
        function closeSidebarFunc() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            menuToggle.classList.remove('active');
            document.body.style.overflow = '';
            mainContent.style.overflow = '';
        }

        // Event Listeners
        menuToggle.addEventListener('click', openSidebar);
        closeSidebar.addEventListener('click', closeSidebarFunc);
        sidebarOverlay.addEventListener('click', closeSidebarFunc);

        // Close sidebar when clicking a link (mobile only)
        const sidebarLinks = document.querySelectorAll('.sidebar a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeSidebarFunc();
                }
            });
        });

        // Handle window resize
        function handleResize() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.add('active');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
                mainContent.style.overflow = '';
            } else {
                sidebar.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Initial check

        // Close sidebar with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeSidebarFunc();
            }
        });

        // Add hover effects to cards
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transition = 'all 0.3s ease';
            });
        });

        // Mobile touch swipe for sidebar
        let touchStartX = 0;
        let touchEndX = 0;

        document.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        document.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });

        function handleSwipe() {
            const swipeThreshold = 50;
            
            // Swipe right to open sidebar (only from left edge)
            if (touchEndX - touchStartX > swipeThreshold && touchStartX < 50) {
                openSidebar();
            }
            
            // Swipe left to close sidebar
            if (touchStartX - touchEndX > swipeThreshold && sidebar.classList.contains('active')) {
                closeSidebarFunc();
            }
        }

        // Notification pulse animation
        const notificationPulse = document.querySelector('.pulse');
        if (notificationPulse) {
            setInterval(() => {
                notificationPulse.classList.toggle('pulse');
                setTimeout(() => {
                    notificationPulse.classList.toggle('pulse');
                }, 100);
            }, 4000);
        }

        // Add active state to buttons on touch
        document.querySelectorAll('.mobile-tap-target').forEach(button => {
            button.addEventListener('touchstart', function() {
                this.classList.add('opacity-80');
            });
            
            button.addEventListener('touchend', function() {
                this.classList.remove('opacity-80');
            });
        });

        // Prevent zoom on double-tap for mobile
        let lastTouchEnd = 0;
        document.addEventListener('touchend', function(event) {
            const now = (new Date()).getTime();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);

        // Process redemption function
        function processRedemption(redemptionId) {
            if (confirm('Are you sure you want to mark this redemption as completed?')) {
                // In a real implementation, this would be an AJAX call
                fetch(`process-redemption.php?id=${redemptionId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Refresh the page or update the row
                        location.reload();
                    } else {
                        alert('Error processing redemption: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while processing the redemption.');
                });
            }
        }

        // Auto-refresh dashboard data every 5 minutes
        setInterval(() => {
            // In a real implementation, this would fetch updated stats
            console.log('Auto-refreshing dashboard data...');
        }, 300000); // 5 minutes

        console.log('Partner dashboard loaded successfully! Responsive across all devices.');
    </script>
</body>
</html>
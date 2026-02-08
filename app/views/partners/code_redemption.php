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
        
        /* Redemption specific styles */
        .redemption-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .redemption-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }
        
        .code-input-container {
            position: relative;
        }
        
        .code-input {
            width: 100%;
            padding: 1rem 1.25rem;
            font-size: 1.125rem;
            letter-spacing: 0.5px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-family: 'Courier New', monospace;
            font-weight: 600;
            text-align: center;
        }
        
        .code-input:focus {
            outline: none;
            border-color: #013220;
            box-shadow: 0 0 0 3px rgba(1, 50, 32, 0.1);
            transform: translateY(-1px);
        }
        
        .code-input.valid {
            border-color: #10b981;
            background-color: #f0fdf4;
        }
        
        .code-input.invalid {
            border-color: #ef4444;
            background-color: #fef2f2;
        }
        
        .btn-primary {
            background-color: #013220;
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background-color: #011a16;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(1, 50, 32, 0.2);
        }
        
        .btn-primary:disabled {
            background-color: #9ca3af;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .btn-secondary {
            background-color: #CC9933;
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-secondary:hover {
            background-color: #b3862e;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(204, 153, 51, 0.2);
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
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: fadeIn 0.3s ease;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 16px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.4s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Alert messages */
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            animation: slideDown 0.3s ease;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        
        .alert-info {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Loading overlay */
        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            z-index: 3000;
            align-items: center;
            justify-content: center;
        }
        
        .loading.active {
            display: flex;
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #013220;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Code info styles */
        .code-info-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            color: #64748b;
            font-weight: 500;
        }
        
        .info-value {
            color: #1e293b;
            font-weight: 600;
        }
        
        .info-value.amount {
            color: #10b981;
            font-size: 1.25rem;
        }
        
        /* Recent redemptions */
        .redemption-history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s ease;
        }
        
        .redemption-history-item:hover {
            background-color: #f8fafc;
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
        
        .status-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-failed {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        /* QR Code scanner */
        .qr-scanner {
            width: 300px;
            height: 300px;
            margin: 0 auto;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }
        
        .qr-scanner video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .qr-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
        }
        
        .qr-frame {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200px;
            height: 200px;
            border: 2px solid #013220;
            border-radius: 8px;
        }
        
        /* Empty state */
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
        
        /* Animation for successful redemption */
        @keyframes celebrate {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .celebrate {
            animation: celebrate 0.5s ease;
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

    <!-- Loading Overlay -->
    <div id="loading" class="loading">
        <div class="loading-spinner"></div>
    </div>

    <!-- Code Info Modal -->
    <div id="codeInfoModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 font-heading">Redemption Code Details</h3>
                    <button onclick="closeCodeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="code-info-card mb-6">
                    <div class="info-row">
                        <span class="info-label font-body">Customer Name</span>
                        <span id="customerName" class="info-value font-body">Loading...</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label font-body">Customer Email</span>
                        <span id="customerEmail" class="info-value font-body">Loading...</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label font-body">Redemption Amount</span>
                        <span id="redemptionAmount" class="info-value amount font-body">₦0.00</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label font-body">Points Value</span>
                        <span id="pointsValue" class="info-value font-body">0 points</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label font-body">Code Status</span>
                        <span id="codeStatus" class="status-badge status-pending">Pending</span>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <button onclick="closeCodeModal()" 
                            class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button onclick="redeemCode()" 
                            id="redeemButton"
                            class="flex-1 btn-primary">
                        <i class="fas fa-gift mr-2"></i> Redeem Code
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content max-w-md">
            <div class="p-8 text-center">
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3 font-heading">Redemption Successful!</h3>
                <p id="successMessage" class="text-gray-600 mb-6 font-body">
                    The redemption has been processed successfully.
                </p>
                <button onclick="closeSuccessModal()" class="btn-primary">
                    <i class="fas fa-check mr-2"></i> Continue
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="min-h-screen transition-all duration-300 lg:ml-[280px] safe-area-top" id="mainContent">
        <!-- Top Bar -->
        <div class="bg-white border-b border-gray-200 px-4 lg:px-6 py-4 fixed top-0 right-0 left-0 z-40 shadow-sm lg:relative lg:top-auto lg:right-auto lg:left-auto">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <button id="menuToggle" class="text-gray-600 hover:text-gray-900 mr-4 lg:hidden" onclick="openSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="text-xl font-bold text-gray-900 font-heading mobile-text-lg lg:ml-[10px] ml-[30px]">Point Redemption</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="hidden lg:flex items-center bg-green-50 px-3 py-1.5 rounded-lg">
                        <i class="fas fa-wallet text-green-600 mr-2"></i>
                        <span class="text-green-700 font-bold font-heading">
                            ₦<?php echo number_format($partnerData['wallet_balance'] ?? 0, 2); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-4 lg:p-6 container-padding mt-20 lg:mt-0">
            <!-- Alert Messages Container -->
            <div id="alertContainer"></div>

            <!-- Redemption Form Card -->
            <div class="redemption-card mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-2 font-heading">Redeem Points</h2>
                    <p class="text-gray-600 font-body">Enter the redemption code provided by the customer to process their points redemption.</p>
                </div>
                
                <div class="p-6">
                    <!-- Code Input Section -->
                    <div class="mb-8">
                        <div class="code-input-container mb-4">
                            <input type="text" 
                                   id="redemptionCode"
                                   placeholder="Enter redemption code (e.g., ORC-ABC123-XYZ789)"
                                   class="code-input font-body"
                                   maxlength="20">
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button onclick="checkCode()" 
                                    id="checkCodeButton"
                                    class="btn-primary flex-1">
                                <i class="fas fa-search mr-2"></i> Check Code
                            </button>
                        </div>
                    </div>
                    
                    <!-- QR Scanner (Initially hidden) -->
                    <div id="qrScanner" class="hidden mb-8">
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 font-heading">Scan QR Code</h3>
                            <p class="text-gray-600 font-body">Position the QR code within the frame to scan.</p>
                        </div>
                        
                        <div class="qr-scanner mb-4">
                            <div id="qrReader"></div>
                            <div class="qr-overlay">
                                <div class="qr-frame"></div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button onclick="closeQRScanner()" 
                                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                Cancel Scan
                            </button>
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-gift text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-body">Today's Redemptions</p>
                                    <p class="text-xl font-bold text-gray-900 font-heading">
                                        <?php echo number_format($partnerData['today_redemptions'] ?? 0); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-money-bill-wave text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-body">Today's Revenue</p>
                                    <p class="text-xl font-bold text-gray-900 font-heading">
                                        ₦<?php echo number_format($partnerData['today_revenue'] ?? 0, 2); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-users text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-body">Active Customers</p>
                                    <p class="text-xl font-bold text-gray-900 font-heading">
                                        <?php echo number_format($partnerData['active_customers'] ?? 0); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Instructions -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-900 mb-2 font-heading">How to redeem points:</h4>
                        <ol class="list-decimal pl-5 space-y-2 text-gray-600 font-body">
                            <li>Ask the customer for their redemption code</li>
                            <li>Enter the code manually</li>
                            <li>Click "Check Code" to verify the code validity</li>
                            <li>Review customer details and redemption amount</li>
                            <li>Click "Redeem Code" to process the redemption</li>
                            <li>Provide the redeemed product/service to the customer</li>
                        </ol>
                    </div>
                </div>
            </div>
            
            <!-- Recent Redemptions -->
            <div class="redemption-card">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900 font-heading">Recent Redemptions</h2>
                        <a href="redemptions.php" class="text-sm text-[#CC9933] hover:text-[#b3862d] font-heading">
                            View All
                        </a>
                    </div>
                </div>
                
                <div class="p-6">
                    <?php if (!empty($recentRedemptions)): ?>
                        <div class="space-y-3">
                            <?php foreach ($recentRedemptions as $redemption): ?>
                            <div class="redemption-history-item">
                                <div>
                                    <p class="font-medium text-gray-900 font-heading"><?php echo htmlspecialchars($redemption['customer_name']); ?></p>
                                    <p class="text-sm text-gray-500 font-body">
                                        <?php echo date('M j, g:i A', strtotime($redemption['created_at'])); ?>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900 font-heading">₦<?php echo number_format($redemption['amount'], 2); ?></p>
                                    <span class="status-badge <?php 
                                        switch($redemption['status']) {
                                            case 'completed': echo 'status-success'; break;
                                            case 'pending': echo 'status-pending'; break;
                                            case 'failed': echo 'status-failed'; break;
                                            default: echo 'status-pending';
                                        }
                                    ?>">
                                        <?php echo ucfirst($redemption['status']); ?>
                                    </span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-gift text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2 font-heading">No recent redemptions</h3>
                            <p class="text-gray-500 font-body">When you process redemptions, they will appear here.</p>
                        </div>
                    <?php endif; ?>
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
                    <a href="support.php" class="text-gray-500 hover:text-[#013220] text-xs lg:text-sm font-body">Support</a>
                    <a href="terms.php" class="text-gray-500 hover:text-[#013220] text-xs lg:text-sm font-body">Terms</a>
                    <a href="privacy.php" class="text-gray-500 hover:text-[#013220] text-xs lg:text-sm font-body">Privacy</a>
                </div>
            </div>
        </footer>
    </main>

    <script>
        // Current code data
        let currentCodeId = null;
        let currentCodeData = null;
        
        // Sidebar functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('menuToggle');
        
        function openSidebar() {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
            menuToggle.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            menuToggle.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Event Listeners
        menuToggle.addEventListener('click', openSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);

        // Handle window resize
        function handleResize() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.add('active');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            } else {
                sidebar.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Initial check

        // API endpoint
        const API_BASE_URL = '/api/redemption';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        // Show alert message
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>
                    <span class="font-body">${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-lg">&times;</button>
                </div>
            `;
            alertContainer.appendChild(alert);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 5000);
        }

        // Show loading overlay
        function showLoading(show = true) {
            const loading = document.getElementById('loading');
            if (show) {
                loading.classList.add('active');
            } else {
                loading.classList.remove('active');
            }
        }

        // Check code function
        async function checkCode() {
            const codeInput = document.getElementById('redemptionCode');
            const code = codeInput.value.trim();
            
            if (!code) {
                showAlert('Please enter a redemption code', 'error');
                codeInput.classList.add('invalid');
                return;
            }
            
            // Reset input styling
            codeInput.classList.remove('invalid', 'valid');
            
            // Disable button and show loading
            const checkButton = document.getElementById('checkCodeButton');
            checkButton.disabled = true;
            checkButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Checking...';
            
            showLoading(true);
            
            try {
                const response = await fetch('validate_redemption_code', {
                    method: 'POST',
                    body: new URLSearchParams({ code : code })
                });
                
                const data = await response.json();
                
                if (response.ok && data.status) {
                    // Store code data
                    currentCodeId = data.code.id;
                    currentCodeData = data.code;
                    
                    // Update input styling
                    codeInput.classList.add('valid');
                    
                    // Show code info in modal
                    showCodeInfo(data.code);
                } else {
                    codeInput.classList.add('invalid');
                    showAlert(data.message || 'Invalid redemption code', 'error');
                }
            } catch (error) {
                console.error('Error checking code:', error);
                showAlert('An error occurred. Please try again.', 'error');
            } finally {
                showLoading(false);
                checkButton.disabled = false;
                checkButton.innerHTML = '<i class="fas fa-search mr-2"></i> Check Code';
            }
        }

        // Show code info in modal
        function showCodeInfo(codeData) {
            document.getElementById('customerName').textContent = codeData.customer_name || 'N/A';
            document.getElementById('customerEmail').textContent = codeData.customer_email || 'N/A';
            document.getElementById('redemptionAmount').textContent = `₦${parseFloat(codeData.amount).toFixed(2)}`;
            document.getElementById('pointsValue').textContent = `${codeData.points || 0} points`;
            
            // Update status badge
            const statusBadge = document.getElementById('codeStatus');
            statusBadge.textContent = codeData.status || 'Pending';
            statusBadge.className = `status-badge status-${codeData.status === 'active' ? 'success' : 'pending'}`;
            
            // Enable/disable redeem button based on status
            const redeemButton = document.getElementById('redeemButton');
            if (codeData.status === 'pending') {
                redeemButton.disabled = false;
                redeemButton.innerHTML = '<i class="fas fa-gift mr-2"></i> Redeem Code';
            } else {
                redeemButton.disabled = true;
                redeemButton.innerHTML = '<i class="fas fa-lock mr-2"></i> Cannot Redeem';
            }
            
            // Show modal
            document.getElementById('codeInfoModal').classList.add('active');
        }

        // Close code modal
        function closeCodeModal() {
            document.getElementById('codeInfoModal').classList.remove('active');
            currentCodeId = null;
            currentCodeData = null;
            
            // Clear input
            const codeInput = document.getElementById('redemptionCode');
            codeInput.value = '';
            codeInput.classList.remove('valid', 'invalid');
        }

        // Redeem code function
        async function redeemCode() {
            if (!currentCodeId) {
                showAlert('No code selected for redemption', 'error');
                return;
            }
            
            // Disable redeem button
            const redeemButton = document.getElementById('redeemButton');
            redeemButton.disabled = true;
            redeemButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
            
            showLoading(true);
            
            try {
                const response = await fetch('process_code_redemption', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({ code: currentCodeData.code, code_id : currentCodeId, amount : currentCodeData.amount, points : currentCodeData.points })
                });
                
                const data = await response.json();
                
                if (response.ok && data.status) {
                    // Close code modal
                    closeCodeModal();
                    
                    // Show success modal
                    document.getElementById('successMessage').textContent = data.message || 'Redemption processed successfully!';
                    document.getElementById('successModal').classList.add('active');
                    
                    // Add celebration animation
                    const successIcon = document.querySelector('#successModal .fa-check');
                    successIcon.parentElement.classList.add('celebrate');
                    
                    // Update wallet balance if provided
                    if (data.new_balance !== undefined) {
                        const walletElement = document.querySelector('.fa-wallet').parentElement.querySelector('span');
                        if (walletElement) {
                            walletElement.textContent = `₦${parseFloat(data.new_balance).toFixed(2)}`;
                        }
                    }
                    
                    // Update today's redemptions count
                    if (data.today_redemptions !== undefined) {
                        const redemptionsElement = document.querySelector('.fa-gift').parentElement.parentElement.querySelector('.text-xl');
                        if (redemptionsElement) {
                            redemptionsElement.textContent = data.today_redemptions;
                        }
                    }
                    
                    // Update today's revenue
                    if (data.today_revenue !== undefined) {
                        const revenueElement = document.querySelector('.fa-money-bill-wave').parentElement.parentElement.querySelector('.text-xl');
                        if (revenueElement) {
                            revenueElement.textContent = `₦${parseFloat(data.today_revenue).toFixed(2)}`;
                        }
                    }
                    
                } else {
                    showAlert(data.message || 'Failed to process redemption', 'error');
                    redeemButton.disabled = false;
                    redeemButton.innerHTML = '<i class="fas fa-gift mr-2"></i> Redeem Code';
                }
            } catch (error) {
                console.error('Error redeeming code:', error);
                showAlert('An error occurred. Please try again.', 'error');
                redeemButton.disabled = false;
                redeemButton.innerHTML = '<i class="fas fa-gift mr-2"></i> Redeem Code';
            } finally {
                showLoading(false);
            }
        }

        // Close success modal
        function closeSuccessModal() {
            document.getElementById('successModal').classList.remove('active');
        }

        // QR Scanner functionality
        function openQRScanner() {
            document.getElementById('qrScanner').classList.remove('hidden');
            document.getElementById('redemptionCode').disabled = true;
            
            // Initialize QR scanner
            initQRScanner();
        }

        function closeQRScanner() {
            document.getElementById('qrScanner').classList.add('hidden');
            document.getElementById('redemptionCode').disabled = false;
            
            // Stop QR scanner
            stopQRScanner();
        }

        let html5QrCode = null;

        function initQRScanner() {
            // This would use a QR scanner library like html5-qrcode
            // For now, we'll simulate with a timeout
            setTimeout(() => {
                // Simulate QR code scan
                const simulatedCode = "ORC-" + Math.random().toString(36).substring(2, 8).toUpperCase() + "-" + Math.random().toString(36).substring(2, 8).toUpperCase();
                document.getElementById('redemptionCode').value = simulatedCode;
                closeQRScanner();
                checkCode();
            }, 2000);
            
            // Uncomment to use actual QR scanner library:
            /*
            html5QrCode = new Html5Qrcode("qrReader");
            const config = { fps: 10, qrbox: { width: 250, height: 250 } };
            
            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess,
                onScanFailure
            );
            */
        }

        function stopQRScanner() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                }).catch(err => {
                    console.error("Failed to stop QR scanner", err);
                });
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            // Handle successful scan
            document.getElementById('redemptionCode').value = decodedText;
            closeQRScanner();
            checkCode();
        }

        function onScanFailure(error) {
            // Handle scan failure
            console.warn(`QR scan failed: ${error}`);
        }

        // Keyboard shortcut for checking code
        document.getElementById('redemptionCode').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                checkCode();
            }
        });

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide messages after 5 seconds
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.remove();
                });
            }, 5000);
            
            console.log('Redemption page loaded successfully!');
        });
    </script>
</body>
</html>
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
                    },
                    screens: {
                        'xs': '375px',
                        'sm': '640px',
                        'md': '768px',
                        'lg': '1024px',
                        'xl': '1280px',
                        '2xl': '1536px',
                    }
                }
            }
        }
    </script>
    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            overflow-x: hidden;
            width: 100%;
        }
        
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
                overflow-y: auto;
            }
            
            .sidebar.open {
                left: 0;
            }
            
            .main-content {
                width: 100%;
                margin-left: 0;
                overflow-x: hidden;
            }
        }
        
        @media (min-width: 768px) {
            .sidebar {
                position: relative;
                left: 0;
                overflow-y: auto;
            }
            
            .main-content {
                width: calc(100% - 16rem);
                overflow-x: hidden;
            }
        }

        /* Main container */
        .main-container {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }
        
        /* Tabs */
        .tab-button {
            position: relative;
            padding: 0.75rem 1rem;
            font-weight: 500;
            color: #6b7280;
            border-bottom: 2px solid transparent;
            transition: all 0.2s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        
        @media (min-width: 640px) {
            .tab-button {
                padding: 1rem 1.5rem;
            }
        }
        
        .tab-button:hover {
            color: #013220;
        }
        
        .tab-button.active {
            color: #013220;
            border-bottom-color: #013220;
        }
        
        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease;
            width: 100%;
        }
        
        .tab-content.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Rate cards */
        .rate-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            width: 100%;
        }
        
        .rate-card:hover {
            border-color: #013220;
            box-shadow: 0 4px 12px rgba(1, 50, 32, 0.1);
        }
        
        /* Forms - responsive inputs */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr auto 1fr;
            }
        }
        
        .input-wrapper {
            width: 100%;
            min-width: 0; /* Prevents overflow */
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
            padding: 1rem;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background-color: white;
            border-radius: 12px;
            max-width: 500px;
            width: 100%;
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

        /* Success message */
        .success-message {
            animation: slideDown 0.3s ease;
            width: 100%;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Error message */
        .error-message {
            animation: slideDown 0.3s ease;
            width: 100%;
        }
        
        /* Loading spinner */
        .loading-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Info tooltip */
        .info-tooltip {
            position: relative;
        }
        
        .info-tooltip .tooltip-text {
            visibility: hidden;
            width: 250px;
            background-color: #374151;
            color: white;
            text-align: center;
            border-radius: 6px;
            padding: 8px 12px;
            position: absolute;
            z-index: 100;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.875rem;
        }
        
        @media (max-width: 640px) {
            .info-tooltip .tooltip-text {
                width: 200px;
                left: auto;
                right: 0;
                transform: none;
            }
        }
        
        .info-tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
        
        /* Form validation */
        .form-error {
            border-color: #ef4444 !important;
        }
        
        .error-text {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            word-break: break-word;
        }
        
        /* Table responsiveness */
        .table-container {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Responsive text sizes */
        .responsive-text {
            font-size: clamp(1.5rem, 4vw, 2.25rem);
        }
        
        /* Flex container for tabs */
        .tabs-container {
            display: flex;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }
        
        .tabs-container::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        
        /* Button responsiveness */
        .btn-responsive {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }
        
        @media (min-width: 640px) {
            .btn-responsive {
                padding: 0.875rem 1.5rem;
                font-size: 1rem;
            }
        }
        
        /* Prevent horizontal overflow */
        .no-overflow {
            max-width: 100%;
            overflow-x: hidden;
        }
        
        /* Value calculation grid */
        .value-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1rem;
        }
        
        @media (min-width: 640px) {
            .value-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        /* Loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-gray-50 no-overflow">
    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" onclick="closeSidebar()"></div>
    
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '../../includes/admin_sidebar.php'; ?>
        
        <!-- Main Content Area -->
        <div class="main-content flex-1 flex flex-col overflow-hidden no-overflow">
            <!-- Header with Mobile Menu Button -->
            <header class="bg-white shadow-sm p-4 flex justify-between items-center no-overflow">
                <div class="flex items-center space-x-4 flex-shrink-0">
                    <!-- Mobile Menu Button -->
                    <button id="openSidebar" class="md:hidden text-xl text-gray-700" onclick="openSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="min-w-0"> <!-- Prevents text overflow -->
                        <h2 id="dashboardTitle" class="text-lg md:text-xl font-semibold text-gray-800 truncate">Points Setup</h2>
                        <p class="text-xs md:text-sm text-gray-500 truncate">Configure point redemption and earning rates</p>
                    </div>
                </div>
            </header>
            
            <!-- Points Setup Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6 no-overflow">
                <!-- Success Message (Hidden by default) -->
                <div id="successMessage" class="hidden success-message mb-4 md:mb-6 p-3 md:p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400 text-lg md:text-xl"></i>
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-green-800 truncate">Success!</h3>
                            <div class="mt-1 text-xs md:text-sm text-green-700 break-words">
                                <p id="successMessageText">Point rate has been updated successfully.</p>
                            </div>
                        </div>
                        <div class="ml-2 pl-3 flex-shrink-0">
                            <button onclick="hideSuccessMessage()" class="text-green-500 hover:text-green-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Error Message (Hidden by default) -->
                <div id="errorMessage" class="hidden error-message mb-4 md:mb-6 p-3 md:p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400 text-lg md:text-xl"></i>
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-red-800 truncate">Error!</h3>
                            <div class="mt-1 text-xs md:text-sm text-red-700 break-words">
                                <p id="errorMessageText">An error occurred. Please try again.</p>
                            </div>
                        </div>
                        <div class="ml-2 pl-3 flex-shrink-0">
                            <button onclick="hideErrorMessage()" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Tabs Navigation -->
                <div class="bg-white rounded-xl shadow mb-4 md:mb-6 no-overflow">
                    <div class="border-b border-gray-200">
                        <div class="tabs-container">
                            <button id="earnPointsTab" class="tab-button active" onclick="switchTab('earn-points')">
                                <i class="fas fa-coins mr-1 md:mr-2"></i>
                                <span class="truncate">Earn Points</span>
                            </button>
                            <button id="redeemPointsTab" class="tab-button" onclick="switchTab('redeem-points')">
                                <i class="fas fa-gift mr-1 md:mr-2"></i>
                                <span class="truncate">Redeem Points</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Earn Points Rate Tab -->
                    <div id="earnPointsContent" class="tab-content active p-4 md:p-6">
                        <div class="mb-6 md:mb-8">
                            <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-2">Configure Earn Points Rate</h3>
                            <p class="text-sm md:text-base text-gray-600">Set how customers earn points based on their purchases.</p>
                            <div class="mt-2 flex items-center text-xs md:text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1 md:mr-2 flex-shrink-0"></i>
                                <span class="truncate">Example: 1 point for every &#8358;1 spent</span>
                            </div>
                        </div>
                        
                        <!-- Current Rate Display -->
                        <div id="earnRateContainer" class="bg-orchid-light rounded-xl p-4 md:p-6 mb-6 md:mb-8">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm md:text-base font-medium text-gray-700 mb-1 truncate">Current Earn Points Rate</h4>
                                    <div class="flex flex-wrap items-baseline gap-1 md:gap-2">
                                        <span id="currentEarnAmount" class="responsive-text font-bold text-orchid-dark">&#8358;1</span>
                                        <span class="text-gray-600">=</span>
                                        <span id="currentEarnPoints" class="responsive-text font-bold text-orchid-dark">1</span>
                                        <span class="text-gray-600 text-sm md:text-base">point(s)</span>
                                    </div>
                                </div>
                                <div class="text-left md:text-right">
                                    <span id="earnStatusBadge" class="inline-block px-2 py-1 text-xs md:text-sm font-medium rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    <p class="text-xs md:text-sm text-gray-500 mt-1 truncate">Last updated: <span id="earnLastUpdated">Loading...</span></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Update Rate Form -->
                        <div class="rate-card p-4 md:p-6">
                            <div class="flex justify-between items-center mb-4 md:mb-6">
                                <h4 class="text-base md:text-lg font-semibold text-gray-800 truncate">Update Earn Points Rate</h4>
                                <div class="info-tooltip flex-shrink-0">
                                    <i class="fas fa-question-circle text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                                    <div class="tooltip-text">
                                        This rate determines how many points customers earn for each naira spent. Higher rates encourage more purchases.
                                    </div>
                                </div>
                            </div>
                            
                            <form id="earnPointsForm" onsubmit="updateEarnPointsRate(event)" class="space-y-4 md:space-y-6">
                                <div>
                                    <label class="block text-sm md:text-base font-medium text-gray-700 mb-2">
                                        New Earn Points Rate
                                    </label>
                                    <div class="form-grid">
                                        <div class="input-wrapper">
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500">&#8358;</span>
                                                </div>
                                                <input type="number" 
                                                       id="earnAmount" 
                                                       min="0.01" 
                                                       step="0.01" 
                                                       required 
                                                       class="w-full pl-8 pr-12 md:pr-16 py-2 md:py-3 text-sm md:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 text-sm">NGN</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-center py-2">
                                            <span class="text-gray-500 text-lg md:text-xl">=</span>
                                        </div>
                                        
                                        <div class="input-wrapper">
                                            <div class="relative">
                                                <input type="number" 
                                                       id="earnPoints" 
                                                       min="1" 
                                                       step="1" 
                                                       required 
                                                       class="w-full px-4 pr-12 md:pr-16 py-2 md:py-3 text-sm md:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 text-sm">points</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="earnPointsError" class="error-text hidden"></div>
                                    <p class="text-xs md:text-sm text-gray-500 mt-2 break-words">
                                        Customers will earn <span id="earnPointsPreview" class="font-medium">1 point</span> for every <span id="" class="font-medium">&#8358;1.00</span> spent
                                    </p>
                                </div>
                                
                                <!--<div>
                                    <label class="block text-sm md:text-base font-medium text-gray-700 mb-2">
                                        Effective Date
                                    </label>
                                    <div class="w-full md:w-auto">
                                        <input type="date" 
                                               id="earnEffectiveDate" 
                                               required 
                                               class="w-full px-4 py-2 md:py-3 text-sm md:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                                    </div>
                                    <p class="text-xs md:text-sm text-gray-500 mt-2">
                                        The new rate will apply to all purchases made on or after this date.
                                    </p>
                                </div>-->
                                
                                <div class="border-t border-gray-200 pt-4 md:pt-6">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <h5 class="text-sm md:text-base font-medium text-gray-700 mb-1">Update Summary</h5>
                                            <p class="text-xs md:text-sm text-gray-500 break-words">
                                                Changing from <span id="summaryOldRate" class="font-medium">&#8358;1 = 1 point</span> to <span id="summaryNewRate" class="font-medium text-orchid-dark">$1 = 1 point</span>
                                            </p>
                                        </div>
                                        <button type="submit" id="earnPointsSubmit" class="btn-primary rounded-lg font-medium btn-responsive whitespace-nowrap">
                                            <i class="fas fa-save mr-2"></i>
                                            Update Earn Rate
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                    
                    <!-- Redeem Points Rate Tab -->
                    <div id="redeemPointsContent" class="tab-content p-4 md:p-6">
                        <div class="mb-6 md:mb-8">
                            <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-2">Configure Redeem Points Rate</h3>
                            <p class="text-sm md:text-base text-gray-600">Set the value of points when customers redeem them for rewards.</p>
                        </div>
                        
                        <!-- Current Rate Display -->
                        <div id="redeemRateContainer" class="bg-orchid-light rounded-xl p-4 md:p-6 mb-6 md:mb-8">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm md:text-base font-medium text-gray-700 mb-1 truncate">Current Redeem Points Rate</h4>
                                    <div class="flex flex-wrap items-baseline gap-1 md:gap-2">
                                        <span id="currentRedeemPoints" class="responsive-text font-bold text-orchid-dark">100</span>
                                        <span class="text-gray-600">points =</span>
                                        <span id="currentRedeemAmount" class="responsive-text font-bold text-orchid-dark">&#8358;1</span>
                                        <span class="text-gray-600 text-sm md:text-base">discount</span>
                                    </div>
                                </div>
                                <div class="text-left md:text-right">
                                    <span id="redeemStatusBadge" class="inline-block px-2 py-1 text-xs md:text-sm font-medium rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    <p class="text-xs md:text-sm text-gray-500 mt-1 truncate">Last updated: <span id="redeemLastUpdated">Loading...</span></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Update Rate Form -->
                        <div class="rate-card p-4 md:p-6">
                            <div class="flex justify-between items-center mb-4 md:mb-6">
                                <h4 class="text-base md:text-lg font-semibold text-gray-800 truncate">Update Redeem Points Rate</h4>
                                <div class="info-tooltip flex-shrink-0">
                                    <i class="fas fa-question-circle text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                                    <div class="tooltip-text">
                                        This rate determines the naira value of points when customers redeem them. Lower point requirements make rewards more attractive.
                                    </div>
                                </div>
                            </div>
                            
                            <form id="redeemPointsForm" onsubmit="updateRedeemPointsRate(event)" class="space-y-4 md:space-y-6">
                                <div>
                                    <label class="block text-sm md:text-base font-medium text-gray-700 mb-2">
                                        New Redeem Points Rate
                                    </label>
                                    <div class="form-grid">
                                        <div class="input-wrapper">
                                            <div class="relative">
                                                <input type="number" 
                                                       id="redeemPoints" 
                                                       min="1" 
                                                       step="1" 
                                                       required 
                                                       class="w-full px-4 pr-12 md:pr-16 py-2 md:py-3 text-sm md:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 text-sm">points</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-center py-2">
                                            <span class="text-gray-500 text-lg md:text-xl">=</span>
                                        </div>
                                        
                                        <div class="input-wrapper">
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500">&#8358;</span>
                                                </div>
                                                <input type="number" 
                                                       id="redeemAmount" 
                                                       min="0.01" 
                                                       step="0.01" 
                                                       required 
                                                       class="w-full pl-8 pr-12 md:pr-16 py-2 md:py-3 text-sm md:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 text-sm">NGN</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="redeemPointsError" class="error-text hidden"></div>
                                    <p class="text-xs md:text-sm text-gray-500 mt-2 break-words">
                                        <span id="redeemPointsPreview" class="font-medium">1 points</span> will be worth <span id="redeemAmountPreview" class="font-medium">&#8358;1.00</span> in discounts
                                    </p>
                                </div>
                                
                                <!--<div>
                                    <label class="block text-sm md:text-base font-medium text-gray-700 mb-2">
                                        Point Value Calculation
                                    </label>
                                    <div class="bg-gray-50 rounded-lg p-3 md:p-4">
                                        <div class="value-grid">
                                            <div class="text-center">
                                                <div class="text-lg md:text-2xl font-bold text-orchid-dark" id="pointValue">&#8358;0.01</div>
                                                <div class="text-xs md:text-sm text-gray-600">Value per point</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-lg md:text-2xl font-bold text-orchid-dark" id="pointsPerDollar">100</div>
                                                <div class="text-xs md:text-sm text-gray-600">Points per &#8358;1</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-lg md:text-2xl font-bold text-orchid-dark" id="dollarPer1000">&#8358;10.00</div>
                                                <div class="text-xs md:text-sm text-gray-600">Value of 1000 points</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm md:text-base font-medium text-gray-700 mb-2">
                                        Effective Date
                                    </label>
                                    <div class="w-full md:w-auto">
                                        <input type="date" 
                                               id="redeemEffectiveDate" 
                                               required 
                                               class="w-full px-4 py-2 md:py-3 text-sm md:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent">
                                    </div>
                                    <p class="text-xs md:text-sm text-gray-500 mt-2">
                                        The new rate will apply to all redemptions made on or after this date.
                                    </p>
                                </div>-->
                                
                                <div class="border-t border-gray-200 pt-4 md:pt-6">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <h5 class="text-sm md:text-base font-medium text-gray-700 mb-1">Update Summary</h5>
                                            <p class="text-xs md:text-sm text-gray-500 break-words">
                                                Changing from <span id="summaryRedeemOldRate" class="font-medium">100 points = 1</span> to <span id="summaryRedeemNewRate" class="font-medium text-orchid-dark">100 points = $1</span>
                                            </p>
                                        </div>
                                        <button type="submit" id="redeemPointsSubmit" class="btn-primary rounded-lg font-medium btn-responsive whitespace-nowrap">
                                            <i class="fas fa-save mr-2"></i>
                                            Update Redeem Rate
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 p-3 md:p-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-2">
                    <p class="text-xs md:text-sm text-gray-500 text-center md:text-left">© <?php echo date('Y'); ?> Orchid Bakery Loyalty Platform. All rights reserved.</p>
                    <div class="flex flex-wrap justify-center gap-2 md:gap-4">
                        <a href="#" class="text-xs md:text-sm text-gray-500 hover:text-orchid-dark whitespace-nowrap">Help Center</a>
                        <a href="#" class="text-xs md:text-sm text-gray-500 hover:text-orchid-dark whitespace-nowrap">Privacy Policy</a>
                        <a href="#" class="text-xs md:text-sm text-gray-500 hover:text-orchid-dark whitespace-nowrap">Terms of Service</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content max-w-md">
            <div class="p-4 md:p-6 text-center">
                <div class="w-12 h-12 md:w-16 md:h-16 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-3 md:mb-4">
                    <i class="fas fa-exclamation-circle text-blue-500 text-xl md:text-2xl"></i>
                </div>
                <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2" id="modalTitle">Confirm Rate Change</h3>
                <p class="text-sm md:text-base text-gray-600 mb-4 md:mb-6 break-words" id="modalMessage">
                    Are you sure you want to update this rate? This change will affect all customers.
                </p>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 md:p-4 mb-4 md:mb-6 text-left">
                    <div class="flex">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mt-0.5 flex-shrink-0"></i>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="text-xs md:text-sm text-yellow-700 break-words" id="modalWarning">
                                Please review the impact before proceeding.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row justify-center gap-2 md:gap-3">
                    <button onclick="closeConfirmationModal()" class="px-4 md:px-6 py-2 md:py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 text-sm md:text-base">
                        Cancel
                    </button>
                    <button onclick="confirmRateChange()" class="px-4 md:px-6 py-2 md:py-3 btn-primary rounded-lg font-medium text-sm md:text-base">
                        <i class="fas fa-check mr-2"></i>
                        Confirm Change
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // API Configuration
        const API_BASE_URL = '/api'; // Update this based on your actual API base URL
        
        // CSRF Token (if using Laravel or similar)
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        // API Headers
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
        
        // Sidebar functions
        function openSidebar() {
            document.querySelector('.sidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.add('active');
        }

        function closeSidebar() {
            document.querySelector('.sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('active');
        }

        // Tab management
        function switchTab(tabName) {
            // Update tab buttons
            document.getElementById('earnPointsTab').classList.remove('active');
            document.getElementById('redeemPointsTab').classList.remove('active');
            
            // Hide all tab content
            document.getElementById('earnPointsContent').classList.remove('active');
            document.getElementById('redeemPointsContent').classList.remove('active');
            
            // Show selected tab
            if (tabName === 'earn-points') {
                document.getElementById('earnPointsTab').classList.add('active');
                document.getElementById('earnPointsContent').classList.add('active');
                loadEarnPointsRate();
            } else {
                document.getElementById('redeemPointsTab').classList.add('active');
                document.getElementById('redeemPointsContent').classList.add('active');
                loadRedeemPointsRate();
            }
        }

        // Message handling
        function showSuccessMessage(message) {
            document.getElementById('successMessageText').textContent = message;
            document.getElementById('successMessage').classList.remove('hidden');
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                hideSuccessMessage();
            }, 5000);
        }

        function hideSuccessMessage() {
            document.getElementById('successMessage').classList.add('hidden');
        }

        function showErrorMessage(message) {
            document.getElementById('errorMessageText').textContent = message;
            document.getElementById('errorMessage').classList.remove('hidden');
            
            // Auto-hide after 8 seconds
            setTimeout(() => {
                hideErrorMessage();
            }, 8000);
        }

        function hideErrorMessage() {
            document.getElementById('errorMessage').classList.add('hidden');
        }

        // Modal management
        let pendingAction = null;
        let pendingFormData = null;

        function showConfirmationModal(title, message, warning, action, formData) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('modalWarning').textContent = warning;
            pendingAction = action;
            pendingFormData = formData;
            document.getElementById('confirmationModal').classList.add('active');
        }

        function closeConfirmationModal() {
            document.getElementById('confirmationModal').classList.remove('active');
            pendingAction = null;
            pendingFormData = null;
        }

        function confirmRateChange() {
            if (pendingAction && pendingFormData) {
                pendingAction(pendingFormData);
            }
            closeConfirmationModal();
        }

        // Form validation and preview
        function updateEarnPointsPreview() {
            const amount = document.getElementById('earnAmount').value || 1;
            const points = document.getElementById('earnPoints').value || 1;

            const amountPreviewConversion = amount / points;
            const pointPreviewConversion = points / amount;
            
            //document.getElementById('earnAmountPreview').textContent = `\u20A6${parseFloat(amountPreviewConversion).toFixed(2)}`;
            document.getElementById('earnPointsPreview').textContent = `${pointPreviewConversion} point${pointPreviewConversion != 1 ? 's' : ''}`;
            document.getElementById('summaryNewRate').textContent = `\u20A6${amount} = ${points} point${points != 1 ? 's' : ''}`;
        }

        function updateRedeemPointsPreview() {
            const points = document.getElementById('redeemPoints').value || 100;
            const amount = document.getElementById('redeemAmount').value || 1;
            
            const redeemAmountConversion = amount / points
            //document.getElementById('redeemPointsPreview').textContent = `${points} point${points != 1 ? 's' : ''}`;
            document.getElementById('redeemAmountPreview').textContent = `\u20A6 ${parseFloat(redeemAmountConversion).toFixed(2)}`;
            document.getElementById('summaryRedeemNewRate').textContent = `${points} points = \u20A6${amount}`;
            
            // Calculate point value
           /* const pointValue = parseFloat(points) / parseInt(amount);
            const pointsPerDollar = parseInt(points) / parseFloat(amount);
            const dollarPer1000 = pointValue * 1000;
            
            document.getElementById('pointValue').textContent = `\u20A6 ${pointValue.toFixed(4)}`;
            document.getElementById('pointsPerDollar').textContent = Math.round(pointsPerDollar);
            document.getElementById('dollarPer1000').textContent = `\u20A6 ${dollarPer1000.toFixed(2)}`; */
        }

        // API: Fetch current earn points rate
        async function loadEarnPointsRate() {
            const container = document.getElementById('earnRateContainer');
            const submitBtn = document.getElementById('earnPointsSubmit');
            
            try {

                container.classList.add('loading');
                if (submitBtn) submitBtn.disabled = true;

                const formData = new FormData();
                formData.append('action', 'redeem_points_rate');
                
                
                const response = await fetch('getexchangeRate', {
                    method: 'POST',
                    body : formData
                });
                
                if (!response.ok) {
                    throw new Error(`Failed to fetch earn rate: ${response.status}`);
                }
                
                const data = await response.json();
                console.log(data);
                
                // Update UI with fetched data
                document.getElementById('currentEarnAmount').textContent = `\u20A6 ${parseFloat(data.rates.amount || 1).toFixed(2)}`;
                document.getElementById('currentEarnPoints').textContent = data.rates.points || 1;
                document.getElementById('earnLastUpdated').textContent = new Date(data.rates.updated_at).toLocaleDateString();
                
                // Update status badge
                const statusBadge = document.getElementById('earnStatusBadge');
                if (data.status === 'inactive') {
                    statusBadge.className = 'inline-block px-2 py-1 text-xs md:text-sm font-medium rounded-full bg-red-100 text-red-800';
                    statusBadge.textContent = 'Inactive';
                } else {
                    statusBadge.className = 'inline-block px-2 py-1 text-xs md:text-sm font-medium rounded-full bg-green-100 text-green-800';
                    statusBadge.textContent = 'Active';
                }
                
                // Update form values
                document.getElementById('earnAmount').value = parseFloat(data.rates.amount || 1).toFixed(2);
                document.getElementById('earnPoints').value = data.rates.points || 1;
                document.getElementById('summaryOldRate').textContent = `\u20A6 ${data.rates.amount || 1} = ${data.rates.points || 1} point${data.rates.points != 1 ? 's' : ''}`;
                
                // Update preview
                updateEarnPointsPreview();
                
            } catch (error) {
                console.error('Error loading earn points rate:', error);
                showErrorMessage('Failed to load earn points rate. Please try again.');
                
                // Set default values if API fails
                document.getElementById('currentEarnAmount').textContent = '&#8358;1.00';
                document.getElementById('currentEarnPoints').textContent = '1';
                document.getElementById('earnLastUpdated').textContent = 'N/A';
                
                document.getElementById('earnAmount').value = '1.00';
                document.getElementById('earnPoints').value = '1';
            } finally {
                container.classList.remove('loading');
                if (submitBtn) submitBtn.disabled = false;
            }
        }

        // API: Fetch current redeem points rate
        async function loadRedeemPointsRate() {
            const container = document.getElementById('redeemRateContainer');
            const submitBtn = document.getElementById('redeemPointsSubmit');
            
            try {

                container.classList.add('loading');
                if (submitBtn) submitBtn.disabled = true;
                
                const formData = new FormData();
                formData.append('action', 'redemption_point_rate');
                
                
                const response = await fetch('getexchangeRate', {
                    method: 'POST',
                    body : formData
                });
                
                if (!response.ok) {
                    throw new Error(`Failed to fetch redeem rate: ${response.status}`);
                }
                
                const data = await response.json();
                // Update UI with fetched data
                document.getElementById('currentRedeemPoints').textContent = data.rates.points || 100;
                document.getElementById('currentRedeemAmount').textContent = `\u20A6 ${parseFloat(data.rates.amount || 1).toFixed(2)}`;
                document.getElementById('redeemLastUpdated').textContent = new Date(data.rates.updated_at).toLocaleDateString();
                
                // Update status badge
                const statusBadge = document.getElementById('redeemStatusBadge');
                if (data.status === 'inactive') {
                    statusBadge.className = 'inline-block px-2 py-1 text-xs md:text-sm font-medium rounded-full bg-red-100 text-red-800';
                    statusBadge.textContent = 'Inactive';
                } else {
                    statusBadge.className = 'inline-block px-2 py-1 text-xs md:text-sm font-medium rounded-full bg-green-100 text-green-800';
                    statusBadge.textContent = 'Active';
                }
                
                // Update form values
                document.getElementById('redeemPoints').value = data.rates.points || 100;
                document.getElementById('redeemAmount').value = parseFloat(data.rates.amount || 1).toFixed(2);
                document.getElementById('summaryRedeemOldRate').textContent = `${data.rates.points || 100} points = \u20A6 ${data.rates.amount || 1}`;
                
                // Update preview
                updateRedeemPointsPreview();
                
            } catch (error) {
                console.error('Error loading redeem points rate:', error);
                showErrorMessage('Failed to load redeem points rate. Please try again.');
                
                // Set default values if API fails
                document.getElementById('currentRedeemPoints').textContent = '100';
                document.getElementById('currentRedeemAmount').textContent = '&#8358;1.00';
                document.getElementById('redeemLastUpdated').textContent = 'N/A';
                
                document.getElementById('redeemPoints').value = '100';
                document.getElementById('redeemAmount').value = '1.00';
            } finally {
                container.classList.remove('loading');
                if (submitBtn) submitBtn.disabled = false;
            }
        }

        // API: Fetch earn rate history
        async function loadEarnRateHistory(forceRefresh = false) {
            const tbody = document.getElementById('earnRateHistory');
            
            try {
                if (forceRefresh) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="3" class="px-4 md:px-6 py-4 md:py-8 text-center text-gray-500">
                                <div class="inline-block loading-spinner rounded-full h-5 md:h-6 w-5 md:w-6 border-t-2 border-b-2 border-orchid-dark"></div>
                                <p class="mt-2 text-sm">Loading history...</p>
                            </td>
                        </tr>
                    `;
                }
                
                const response = await fetch(`${API_BASE_URL}/points/earn-rate/history`, {
                    method: 'GET',
                    headers: apiHeaders
                });
                
                if (!response.ok) {
                    throw new Error(`Failed to fetch history: ${response.status}`);
                }
                
                const data = await response.json();
                const history = data.history || data.data || [];
                
                tbody.innerHTML = '';
                
                if (history.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="3" class="px-4 md:px-6 py-8 text-center text-gray-500">
                                No rate change history found.
                            </td>
                        </tr>
                    `;
                    return;
                }
                
                history.forEach(item => {
                    const row = document.createElement('tr');
                    const date = new Date(item.created_at || item.updated_at || item.date);
                    const formattedDate = date.toLocaleDateString();
                    
                    // Format rate based on your API response structure
                    const rate = item.settings_amount && item.settings_point 
                        ? `$${parseFloat(item.settings_amount).toFixed(2)} = ${item.settings_point} point${item.settings_point != 1 ? 's' : ''}`
                        : item.rate || 'N/A';
                    
                    const updatedBy = item.updated_by || item.admin_name || 'System';
                    
                    row.innerHTML = `
                        <td class="px-4 md:px-6 py-3 md:py-4 text-xs md:text-sm text-gray-900 whitespace-nowrap">${formattedDate}</td>
                        <td class="px-4 md:px-6 py-3 md:py-4 text-xs md:text-sm text-gray-900 whitespace-nowrap">${rate}</td>
                        <td class="px-4 md:px-6 py-3 md:py-4 text-xs md:text-sm text-gray-500 whitespace-nowrap">${updatedBy}</td>
                    `;
                    tbody.appendChild(row);
                });
                
            } catch (error) {
                console.error('Error loading earn rate history:', error);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="px-4 md:px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-exclamation-triangle text-red-400 mr-2"></i>
                            Failed to load history. Please try again.
                        </td>
                    </tr>
                `;
            }
        }

        // API: Update earn points rate
        async function submitEarnPointsUpdate(form) {
            const submitBtn = document.getElementById('earnPointsSubmit');
            const originalText = submitBtn.innerHTML;
            
            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner loading-spinner mr-2"></i> Updating...';

                const response = await fetch('update_system_settings', {
                    method: 'POST',
                    body: new URLSearchParams({
                        point: form.points,
                        amount: form.amount,
                        key: 'redeem_points_rate'
                    }),
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });
                
                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.message || `Failed to update: ${response.status}`);
                }
                
                const result = await response.json();
                
                // Update UI with new data
                document.getElementById('currentEarnAmount').textContent = `\u20A6 ${parseFloat(form.amount).toFixed(2)}`;
                document.getElementById('currentEarnPoints').textContent = form.points;
                document.getElementById('earnLastUpdated').textContent = new Date().toLocaleDateString();
                document.getElementById('summaryOldRate').textContent = `\u20A6 ${form.amount} = ${form.points} point${form.points != 1 ? 's' : ''}`;
                
                // Reset form date
                //document.getElementById('earnEffectiveDate').value = '';
                
                showSuccessMessage('Earn points rate has been updated successfully!');
                
                // Refresh history
                loadEarnRateHistory(true);
                
            } catch (error) {
                console.error('Error updating earn points rate:', error);
                showErrorMessage(error.message || 'Failed to update earn points rate. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }

        // API: Update redeem points rate
        async function submitRedeemPointsUpdate(form) {
            const submitBtn = document.getElementById('redeemPointsSubmit');
            const originalText = submitBtn.innerHTML;

            console.log(form);
            
            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner loading-spinner mr-2"></i> Updating...';
                
                const response = await fetch('update_system_settings', {
                    method: 'POST',
                    body: new URLSearchParams({
                        point: form.points,
                        amount: form.amount,
                        key: 'redemption_point_rate'
                    }),
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });
                
                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.message || `Failed to update: ${response.status}`);
                }
                
                const result = await response.json();
                console.log(result);
                
                // Update UI with new data
                document.getElementById('currentRedeemPoints').textContent = form.points;
                document.getElementById('currentRedeemAmount').textContent = `\u20A6 ${parseFloat(form.amount).toFixed(2)}`;
                document.getElementById('redeemLastUpdated').textContent = new Date().toLocaleDateString();
                document.getElementById('summaryRedeemOldRate').textContent = `${form.points} points = \u20A6 ${form.amount}`;
                
                // Reset form date
                //document.getElementById('redeemEffectiveDate').value = '';
                
                showSuccessMessage('Redeem points rate has been updated successfully!');
                
            } catch (error) {
                console.error('Error updating redeem points rate:', error);
                showErrorMessage(error.message || 'Failed to update redeem points rate. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }

        // Form submissions
        function updateEarnPointsRate(event) {
            event.preventDefault();
            
            const amount = parseFloat(document.getElementById('earnAmount').value);
            const points = parseInt(document.getElementById('earnPoints').value);
            //const effectiveDate = document.getElementById('earnEffectiveDate').value;
            
            // Validation
            if (amount <= 0 || points <= 0) {
                document.getElementById('earnPointsError').textContent = 'Amount and points must be greater than 0';
                document.getElementById('earnPointsError').classList.remove('hidden');
                return;
            }
            
            document.getElementById('earnPointsError').classList.add('hidden');
            
            const formData = { amount, points };
            
            showConfirmationModal(
                'Update Earn Points Rate',
                `You are changing the earn rate to \u20A6${amount.toFixed(2)} = ${points} point${points !== 1 ? 's' : ''}.`,
                'This change will affect how all customers earn points on future purchases.',
                submitEarnPointsUpdate,
                formData
            );
        }

        function updateRedeemPointsRate(event) {
            event.preventDefault();
            
            const points = parseInt(document.getElementById('redeemPoints').value);
            const amount = parseFloat(document.getElementById('redeemAmount').value);
            //const effectiveDate = document.getElementById('redeemEffectiveDate').value;
            
            // Validation
            if (amount <= 0 || points <= 0) {
                document.getElementById('redeemPointsError').textContent = 'Amount and points must be greater than 0';
                document.getElementById('redeemPointsError').classList.remove('hidden');
                return;
            }
            
            document.getElementById('redeemPointsError').classList.add('hidden');
            
            const formData = { points, amount };
            
            showConfirmationModal(
                'Update Redeem Points Rate',
                `You are changing the redeem rate from 100 points = 1 to ${points} points = \u20A6 ${amount.toFixed(2)}.`,
                'This change will affect the value of all customer points for future redemptions.',
                submitRedeemPointsUpdate,
                formData
            );
        }

        // Initialize date inputs
        function initializeDates() {
            const today = new Date().toISOString().split('T')[0];
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const tomorrowStr = tomorrow.toISOString().split('T')[0];
            
            document.getElementById('earnEffectiveDate').value = tomorrowStr;
            document.getElementById('redeemEffectiveDate').value = tomorrowStr;
            
            // Set min date to today
            const dateInputs = document.querySelectorAll('input[type="date"]');
            dateInputs.forEach(input => {
                input.min = today;
            });
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize dates
            //initializeDates();
            
            // Load initial data
            loadEarnPointsRate();
            loadEarnRateHistory();
            
            // Set up form previews
            document.getElementById('earnAmount').addEventListener('input', updateEarnPointsPreview);
            document.getElementById('earnPoints').addEventListener('input', updateEarnPointsPreview);
            document.getElementById('redeemPoints').addEventListener('input', updateRedeemPointsPreview);
            document.getElementById('redeemAmount').addEventListener('input', updateRedeemPointsPreview);
            
            // Initial preview updates
            updateEarnPointsPreview();
            updateRedeemPointsPreview();
            
            // Prevent horizontal scrolling
            document.body.style.overflowX = 'hidden';
            
            // Handle window resize
            window.addEventListener('resize', function() {
                document.body.style.overflowX = 'hidden';
            });
        });
    </script>
</body>
</html>
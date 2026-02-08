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
        }

        /* Redeem specific styles */
        .redeem-point-input {
            transition: all 0.3s ease;
        }
        
        .redeem-point-input:focus {
            border-color: #CC9933;
            box-shadow: 0 0 0 3px rgba(204, 153, 51, 0.1);
        }
        
        .conversion-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #f1f3f5 100%);
            border: 2px dashed #dee2e6;
        }
        
        .conversion-arrow {
            animation: bounce 1s infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        /* Success/Error states */
        .input-success {
            border-color: #28a745;
        }
        
        .input-error {
            border-color: #dc3545;
        }
        
        .text-success {
            color: #28a745;
        }
        
        .text-error {
            color: #dc3545;
        }
        
        /* Loading spinner */
        .loading-spinner {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-50 font-body no-horizontal-scroll">
    <!-- Mobile Menu Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Mobile Menu Button - Fixed position -->
    <button id="menuToggle" class="menu-toggle mobile-tap-target">
        <div class="w-6 h-6 flex flex-col justify-center items-center">
            <span class="bar w-5 h-0.5 bg-gray-700 mb-1.5 transition-all duration-300"></span>
            <span class="bar w-5 h-0.5 bg-gray-700 mb-1.5 transition-all duration-300"></span>
            <span class="bar w-5 h-0.5 bg-gray-700 transition-all duration-300"></span>
        </div>
    </button>

    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content - Adjusted for mobile -->
    <main class="min-h-screen transition-all duration-300 lg:ml-[280px] safe-area-top" id="mainContent">
        <!-- Top Bar - Fixed for mobile -->
        <div class="bg-white border-b border-gray-200 px-4 lg:px-6 py-4 fixed top-0 right-0 left-0 z-40 shadow-sm lg:relative lg:top-auto lg:right-auto lg:left-auto">
            <div class="flex justify-between items-center">
                <!-- Mobile: Show page title, Desktop: Show search -->
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-900 font-heading mobile-text-lg ml-20">Redeem Points</h1>
                </div>
                
                <!-- Right side icons -->
                <div class="flex items-center space-x-3 lg:space-x-4">
                    <!-- User Menu -->
                    <div class="relative">
                        <button class="flex items-center space-x-2 p-1 rounded-lg hover:bg-gray-100 transition mobile-tap-target" id="userMenuBtn">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#013220] to-[#0a4d2e] flex items-center justify-center">
                                <span class="text-white text-sm font-bold"><?php echo $initials ?></span>
                            </div>
                            <span class="hidden lg:inline text-gray-700 font-heading"><?php echo $fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name'] ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="p-4 lg:p-6 container-padding mt-16 lg:mt-0">
            <!-- Points Balance Card -->
            <div class="bg-gradient-to-r from-[#013220] to-[#0a4d2e] rounded-xl shadow-lg p-6 text-white mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 font-body mb-1">Available Balance</p>
                        <h2 class="text-3xl lg:text-4xl font-bold font-heading">
                            <span id="availablePoints"><?php echo number_format($fetchuserdetails['points_balance'] ?? 0); ?></span>
                            <span class="text-lg ml-1">Points</span>
                        </h2>
                        <p class="text-white/80 text-sm font-body mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Minimum redemption: 1,000 points
                        </p>
                    </div>
                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fas fa-coins text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Redeem Points Form -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Left Column: Redeem Form -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 font-heading mb-6">Redeem Your Points</h3>
                    
                    <form id="redeemForm">
                        <!-- Points Input -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                Points to Redeem
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       id="pointsInput" 
                                       name="points"
                                       min="1000"
                                       placeholder="Enter points (minimum: 1,000)"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body text-lg redeem-point-input">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-coins"></i>
                                </div>
                            </div>
                            <div class="flex justify-between mt-2">
                                <span class="text-sm text-gray-500 font-body">
                                    Available: <?php echo number_format($fetchuserdetails['points_balance'] ?? 0); ?> points
                                </span>
                                <button type="button" 
                                        id="redeemAllBtn" 
                                        class="text-sm text-[#CC9933] hover:text-[#b3862d] font-medium font-heading">
                                    Redeem All
                                </button>
                            </div>
                        </div>
                        
                        <!-- Quick Amounts -->
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-700 mb-3 font-heading">Quick Redeem</p>
                            <div class="grid grid-cols-3 gap-3">
                                <button type="button" class="quick-amount-btn py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-body" data-points="1000">
                                    1,000
                                </button>
                                <button type="button" class="quick-amount-btn py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-body" data-points="5000">
                                    5,000
                                </button>
                                <button type="button" class="quick-amount-btn py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-body" data-points="10000">
                                    10,000
                                </button>
                            </div>
                        </div>
                        
                        <!-- Terms Agreement -->
                        <div class="mb-6">
                            <label class="flex items-start">
                                <input type="checkbox" 
                                       id="termsCheckbox" 
                                       name="terms"
                                       class="mt-1 mr-3 text-[#013220] focus:ring-[#013220] rounded">
                                <span class="text-sm text-gray-600 font-body">
                                    I agree to the 
                                    <a href="#" class="text-[#013220] hover:text-[#0a4d2e] font-medium">terms and conditions</a>
                                    of points redemption. I understand that redeemed points will be deducted from my account immediately.
                                </span>
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                id="redeemSubmitBtn"
                                class="w-full py-3 orchid-gradient text-white rounded-lg font-semibold hover:opacity-95 transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#013220] font-heading disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-exchange-alt mr-2"></i>
                            Redeem Points
                        </button>
                    </form>
                </div>
                
                <!-- Right Column: Conversion Preview -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 font-heading mb-6">Conversion Preview</h3>
                    
                    <!-- Points to Naira Conversion -->
                    <div class="conversion-box rounded-lg p-6 mb-6 text-center">
                        <div class="flex flex-col items-center justify-center space-y-4">
                            <!-- Points -->
                            <div class="text-center">
                                <div class="text-sm text-gray-500 font-body mb-1">You Redeem</div>
                                <div class="text-2xl font-bold text-[#013220] font-heading" id="previewPoints">0</div>
                                <div class="text-sm text-gray-600 font-body">Points</div>
                            </div>
                            
                            <!-- Arrow -->
                            <div class="conversion-arrow">
                                <i class="fas fa-arrow-down text-xl text-[#CC9933]"></i>
                            </div>
                            
                            <!-- Naira -->
                            <div class="text-center">
                                <div class="text-sm text-gray-500 font-body mb-1">You Receive</div>
                                <div class="text-2xl font-bold text-[#013220] font-heading" id="previewNaira">₦0.00</div>
                                <div class="text-sm text-gray-600 font-body">Naira</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Exchange Rate 
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-700 font-heading">Exchange Rate</p>
                                <p class="text-xs text-gray-500 font-body">Points to Naira</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900 font-heading" id="exchangeRate">1,000 points = ₦500</p>
                                <p class="text-xs text-gray-500 font-body">Rate may vary</p>
                            </div>
                        </div>
                    </div>-->
                    
                    <!-- Conversion Info -->
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                <i class="fas fa-bolt text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 font-heading">Instant Processing</p>
                                <p class="text-xs text-gray-500 font-body">Transactions completed immediately</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 font-heading">Secure Transaction</p>
                                <p class="text-xs text-gray-500 font-body">Bank-level security encryption</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                <i class="fas fa-history text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 font-heading">Transaction History</p>
                                <p class="text-xs text-gray-500 font-body">View all redemptions in your account</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div id="recentRedemptions">
                    <!-- Will be populated by JavaScript -->
                    <div class="text-center py-8">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-exchange-alt text-gray-400 text-xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-700 font-heading mb-2">No Recent Redemptions</h4>
                        <p class="text-gray-500 font-body">Your redemption history will appear here</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 px-4 lg:px-6 py-4 mt-6 safe-area-bottom">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-3 md:mb-0">
                    <p class="text-gray-600 text-xs lg:text-sm font-body text-center md:text-left">
                        © <?php echo date('Y'); ?> Orchid Royal Bakery Loyalty Platform
                    </p>
                </div>
                <div class="flex flex-wrap justify-center gap-3 lg:gap-6">
                    <a href="#" class="text-gray-500 hover:text-[#013220] text-xs lg:text-sm font-body">Privacy</a>
                    <a href="#" class="text-gray-500 hover:text-[#013220] text-xs lg:text-sm font-body">Terms</a>
                    <a href="#" class="text-gray-500 hover:text-[#013220] text-xs lg:text-sm font-body">Help</a>
                    <a href="#" class="text-gray-500 hover:text-[#013220] text-xs lg:text-sm font-body">Contact</a>
                </div>
            </div>
        </footer>
    </main>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="successModalContent">
            <div class="p-6">
                <div class="text-center">
                    <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check text-green-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 font-heading mb-2">Redemption Successful!</h3>
                    <p class="text-gray-600 font-body mb-6">
                        You have successfully redeemed <span id="successPoints" class="font-bold text-[#013220]">0</span> points 
                        for <span id="successNaira" class="font-bold text-[#013220]">₦0.00</span>
                    </p>
                    <p class='text-gray-600 font-body mb-6'>Your redemption code is : <span id="redemptionCode"></span>
                    <div class="flex space-x-3">
                        <button type="button" id="closeSuccessModal" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition font-heading">
                            Close
                        </button>
                        <a href="transaction_history" class="flex-1 text-center px-4 py-2 orchid-gradient text-white rounded-lg font-semibold hover:opacity-95 transition font-heading">
                            View History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sidebar functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('menuToggle');
        const closeSidebar = document.getElementById('closeSidebar');
        
        // Function to open sidebar
        function openSidebar() {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
            menuToggle.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Function to close sidebar
        function closeSidebarFunc() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            menuToggle.classList.remove('active');
            document.body.style.overflow = '';
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
            } else {
                sidebar.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Initial check

        // Redeem Points Functionality
        const pointsInput = document.getElementById('pointsInput');
        const redeemAllBtn = document.getElementById('redeemAllBtn');
        const quickAmountBtns = document.querySelectorAll('.quick-amount-btn');
        const redeemSubmitBtn = document.getElementById('redeemSubmitBtn');
        const termsCheckbox = document.getElementById('termsCheckbox');
        const previewPoints = document.getElementById('previewPoints');
        const previewNaira = document.getElementById('previewNaira');
        const exchangeRate = document.getElementById('exchangeRate');
        const recentRedemptions = document.getElementById('recentRedemptions');
        const availablePoints = document.getElementById('availablePoints');
        const successModal = document.getElementById('successModal');
        const successModalContent = document.getElementById('successModalContent');
        const closeSuccessModal = document.getElementById('closeSuccessModal');
        const successPoints = document.getElementById('successPoints');
        const successNaira = document.getElementById('successNaira');
        const redemptionCode = document.getElementById('redemptionCode');

        let currentPoints = <?php echo $fetchuserdetails['points_balance'] ?? 0; ?>;
        let conversionRate = 0.5; // 1 point = ₦0.5 (1000 points = ₦500)
        let currentExchangeRate = null;

        // Initialize the page
        document.addEventListener('DOMContentLoaded', () => {
            updateConversionDisplay();
            loadRecentRedemptions();
            fetchExchangeRate();
            
            // Enable/disable submit button based on terms
            termsCheckbox.addEventListener('change', updateSubmitButtonState);
            pointsInput.addEventListener('input', validatePointsInput);
            
            // Set max value for points input
            pointsInput.max = currentPoints;
        });

        // Fetch current exchange rate from backend
        function fetchExchangeRate() {
            fetch('getexchangeRate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'redeem_points_rate'
                })
            })
            .then(response => response.json())
            .then(data => { 
                console.log('Exchange rate data:', data);
                if (data.status && data.rates) {
                    conversionRate = data.rates.exchange_rate;
                    currentExchangeRate = data;
                    updateExchangeRateDisplay();
                } else {
                    // Use default rate if API fails
                    updateExchangeRateDisplay();
                }
            })
            .catch(error => {
                console.error('Error fetching exchange rate:', error);
                updateExchangeRateDisplay();
            });
        }

        // Update exchange rate display
        function updateExchangeRateDisplay() {
            const samplePoints = 1000;
            const sampleNaira = calculateNaira(samplePoints);
            //exchangeRate.textContent = `${samplePoints.toLocaleString()} points = ₦${sampleNaira.toLocaleString()}`;
        }

        // Calculate Naira value from points
        function calculateNaira(points) {
            return Math.round(points * conversionRate);
        }

        // Format points with commas
        function formatPoints(points) {
            return points.toLocaleString();
        }

        // Format Naira with currency symbol
        function formatNaira(amount) {
            return `₦${amount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }

        // Validate points input
        function validatePointsInput() {
            const points = parseInt(pointsInput.value) || 0;
            const maxPoints = currentPoints;
            
            // Remove error/success classes
            pointsInput.classList.remove('input-success', 'input-error');
            
            if (points === 0) {
                // Empty input
                updateConversionDisplay();
                return false;
            }
            
            if (points < 1000) {
                // Below minimum
                showError('Minimum redemption is 1,000 points');
                pointsInput.classList.add('input-error');
                updateConversionDisplay(points);
                return false;
            }
            
            if (points > maxPoints) {
                // Exceeds balance
                showError(`You only have ${formatPoints(maxPoints)} points available`);
                pointsInput.classList.add('input-error');
                updateConversionDisplay(points);
                return false;
            }
            
            // Valid input
            pointsInput.classList.add('input-success');
            updateConversionDisplay(points);
            return true;
        }

        // Update conversion display
        function updateConversionDisplay(points = 0) {
            if (points > 0) {
                previewPoints.textContent = formatPoints(points);
                const nairaAmount = calculateNaira(points);
                previewNaira.textContent = formatNaira(nairaAmount);
            } else {
                previewPoints.textContent = '0';
                previewNaira.textContent = '₦0.00';
            }
        }

        // Show error message
        function showError(message) {
            // Remove existing error message
            const existingError = document.querySelector('.error-message');
            if (existingError) {
                existingError.remove();
            }
            
            // Create error message element
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message mt-2 p-3 bg-red-50 border border-red-200 rounded-lg';
            errorDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="text-sm text-red-700 font-body">${message}</span>
                </div>
            `;
            
            // Insert after points input
            pointsInput.parentNode.appendChild(errorDiv);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.remove();
                }
            }, 5000);
        }

        // Update submit button state
        function updateSubmitButtonState() {
            const isTermsAccepted = termsCheckbox.checked;
            const isPointsValid = validatePointsInput() && parseInt(pointsInput.value) > 0;
            
            redeemSubmitBtn.disabled = !(isTermsAccepted && isPointsValid);
        }

        // Redeem all points
        redeemAllBtn.addEventListener('click', () => {
            if (currentPoints < 1000) {
                showError('You need at least 1,000 points to redeem');
                return;
            }
            
            pointsInput.value = currentPoints;
            validatePointsInput();
            updateSubmitButtonState();
            
            // Scroll to input
            pointsInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });

        // Quick amount buttons
        quickAmountBtns.forEach(button => {
            button.addEventListener('click', () => {
                const points = parseInt(button.dataset.points);
                
                if (points > currentPoints) {
                    showError(`You only have ${formatPoints(currentPoints)} points available`);
                    return;
                }
                
                pointsInput.value = points;
                validatePointsInput();
                updateSubmitButtonState();
            });
        });

        // Form submission
        document.getElementById('redeemForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const points = parseInt(pointsInput.value);
            
            if (!validatePointsInput()) {
                return;
            }
            
            if (!termsCheckbox.checked) {
                showError('Please accept the terms and conditions');
                return;
            }
            
            // Disable submit button and show loading
            redeemSubmitBtn.disabled = true;
            const originalText = redeemSubmitBtn.innerHTML;
            redeemSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
            
            try {
                // First convert points to Naira
                const nairaAmount = calculateNaira(points);
                
                // Send redemption request to backend
                const formData = new FormData();
                formData.append('points', points);
                formData.append('amount', nairaAmount);
                
                const response = await fetch('redeem_code', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.status) {
                    // Success
                    successPoints.textContent = formatPoints(points);
                    successNaira.textContent = formatNaira(nairaAmount);
                    redemptionCode.textContent = data.code;
                    
                    // Update available points
                    currentPoints -= points;
                    availablePoints.textContent = formatPoints(currentPoints);
                    pointsInput.max = currentPoints;
                    
                    // Reset form
                    pointsInput.value = '';
                    termsCheckbox.checked = false;
                    updateConversionDisplay();
                    updateSubmitButtonState();
                    
                    // Show success modal
                    successModal.classList.remove('hidden');
                    setTimeout(() => {
                        successModalContent.classList.remove('scale-95', 'opacity-0');
                        successModalContent.classList.add('scale-100', 'opacity-100');
                    }, 10);
                    
                    // Reload recent redemptions
                    loadRecentRedemptions();
                    
                    // Show success notification
                    showNotification('Points redeemed successfully!', 'success');
                    
                } else {
                    // Error from server
                    showError(data.message || 'Redemption failed. Please try again.');
                    showNotification(data.message || 'Redemption failed', 'error');
                }
                
            } catch (error) {
                console.error('Error redeeming points:', error);
                showError('Network error occurred. Please try again.');
                showNotification('Network error occurred', 'error');
            } finally {
                // Reset button
                redeemSubmitBtn.disabled = false;
                redeemSubmitBtn.innerHTML = originalText;
            }
        });

        // Close success modal
        closeSuccessModal.addEventListener('click', () => {
            successModalContent.classList.remove('scale-100', 'opacity-100');
            successModalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                successModal.classList.add('hidden');
            }, 300);
        });

        // Load recent redemptions
        function loadRecentRedemptions() {
            fetch('getrecentredemptions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status && data.redemptions && data.redemptions.length > 0) {
                    displayRecentRedemptions(data.redemptions);
                } else {
                    // Show empty state (already shown by default)
                }
            })
            .catch(error => {
                console.error('Error loading recent redemptions:', error);
            });
        }

        // Display recent redemptions
        function displayRecentRedemptions(redemptions) {
            let html = '';
            
            redemptions.forEach(redemption => {
                const date = new Date(redemption.created_at);
                const formattedDate = date.toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                html += `
                    <div class="flex items-center justify-between p-4 border-b border-gray-200 last:border-0">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                <i class="fas fa-gift text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 font-heading">Points Redemption</h4>
                                <p class="text-sm text-gray-600 font-body">${redemption.description || 'Points converted to cash'}</p>
                                <p class="text-xs text-gray-500 font-body mt-1">${formattedDate}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-[#013220] font-heading">-${formatPoints(redemption.points)}</div>
                            <div class="text-sm text-gray-600 font-body">${formatNaira(redemption.amount)}</div>
                        </div>
                    </div>
                `;
            });
            
            recentRedemptions.innerHTML = html;
        }

        // Notification System
        function showNotification(message, type) {
            // Remove existing notification
            const existingNotification = document.querySelector('.notification-toast');
            if (existingNotification) {
                existingNotification.remove();
            }
            
            // Create notification
            const notification = document.createElement('div');
            notification.className = `notification-toast fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg animate-slide-in font-body ${type === 'error' ? 'bg-red-100 border-l-4 border-red-500 text-red-700' : 
                                                                                       'bg-green-100 border-l-4 border-green-500 text-green-700'}`;
            
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle'} mr-3"></i>
                    <span>${message}</span>
                    <button class="ml-4 text-gray-500 hover:text-gray-700" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }

        // Add CSS for notification animation
        const style = document.createElement('style');
        style.textContent = `
            .animate-slide-in {
                animation: slideIn 0.3s ease-out;
            }
            
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(style);

        console.log('Redeem points page loaded successfully!');
    </script>
</body>
</html>
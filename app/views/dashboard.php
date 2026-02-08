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
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content - Adjusted for mobile -->
    <main class="min-h-screen transition-all duration-300 lg:ml-[280px] safe-area-top" id="mainContent">
        <!-- Top Bar - Fixed for mobile -->
        <div class="bg-white border-b border-gray-200 px-4 lg:px-6 py-4 fixed top-0 right-0 left-0 z-40 shadow-sm lg:relative lg:top-auto lg:right-auto lg:left-auto">
            <div class="flex justify-between items-center">
                <!-- Mobile: Show page title, Desktop: Show search -->
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-900 font-heading mobile-text-lg lg:ml-[10px] ml-[60px]">Dashboard</h1>
                </div>
                
                <!-- Right side icons -->
                <div class="flex items-center space-x-3 lg:space-x-4">
                    
                    <!-- Notifications -->
                    
                    
                    <!-- User Menu -->
                    <div class="relative">
                        <button class="flex items-center space-x-2 p-1 rounded-lg hover:bg-gray-100 transition mobile-tap-target" id="userMenuBtn">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#013220] to-[#0a4d2e] flex items-center justify-center">
                                <span class="text-white text-sm font-bold"><?php echo $initials ?></span>
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
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 font-heading mobile-text-2xl">Welcome back, <?php echo $fetchuserdetails['first_name'] ?>! 👋</h1>
                <p class="text-gray-600 mt-2 mobile-text-sm">Here's your rewards summary and recent activity.</p>
            </div>

            <!-- Points Balance Card - Stacked on mobile -->
            <div class="orchid-gradient rounded-2xl shadow-xl p-4 lg:p-6 text-white mb-6 card-hover transition-all duration-300 mobile-p-4">
                <div class="flex flex-col">
                    <div class="mb-4">
                        <p class="text-gray-300 font-body mobile-text-sm">Available Points Balance</p>
                        <h2 class="text-3xl lg:text-4xl font-bold mt-1 font-heading mobile-text-3xl"><?php echo number_format($fetchuserdetails['points_balance']) ?> <span class="text-xl lg:text-2xl">points</span></h2>
                        <p class="text-gray-300 mt-1 font-body mobile-text-sm">Equivalent to &#8358 <?php echo number_format($fetchuserdetails['points_balance'] * $fetchexchangerate['exchange_rate']) ?></p>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-[#CC9933]/20 flex items-center justify-center mr-3">
                                <i class="fas fa-crown text-[#CC9933]"></i>
                            </div>
                            <div>
                                <p class="font-heading mobile-text-sm"><?php echo $tier ?> Tier</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats - Grid adjusts for mobile -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-6">
                <!-- Points Earned -->
                <div class="bg-white rounded-xl shadow p-4 lg:p-6 card-hover transition-all duration-300 mobile-p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 font-heading mobile-text-sm">Points Earned</p>
                            <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mt-1 font-heading mobile-text-xl">+<?php echo $summary['points_earned'] ?></h3>
                            <p class="text-xs lg:text-sm text-gray-500 mt-1 font-body">This month</p>
                        </div>
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-arrow-up text-green-600 lg:text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Points Redeemed -->
                <div class="bg-white rounded-xl shadow p-4 lg:p-6 card-hover transition-all duration-300 mobile-p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 font-heading mobile-text-sm">Points Redeemed</p>
                            <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mt-1 font-heading mobile-text-xl">-<?php echo $summary['points_spent'] ?></h3>
                            <p class="text-xs lg:text-sm text-gray-500 mt-1 font-body">This month</p>
                        </div>
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-gift text-blue-600 lg:text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Partners -->
                <div class="bg-white rounded-xl shadow p-4 lg:p-6 card-hover transition-all duration-300 mobile-p-4 sm:col-span-2 lg:col-span-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 font-heading mobile-text-sm">Available Partners</p>
                            <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mt-1 font-heading mobile-text-xl"><?php echo count($allpartners) ?></h3>
                        </div>
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-store text-purple-600 lg:text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Quick Actions - Stack on mobile -->
            <div class="flex flex-col lg:flex-row gap-4 lg:gap-6 mb-6">
                <!-- Recent Activity -->
                <div class="lg:w-1/2">
                    <div class="bg-white rounded-xl shadow h-full">
                        <div class="p-4 lg:p-6 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900 font-heading mobile-text-lg">Recent Activity</h3>
                                <a href="transaction_history" class="text-sm text-[#CC9933] hover:text-[#b3862d] font-heading">
                                    View All
                                </a>
                            </div>
                        </div>
                        <div class="p-4 lg:p-6">
                            <div class="space-y-4">
                                <!-- Activity Item -->
                                <?php
                                    foreach($fetchtransactions as $transaction): 
                                    $transactionType = $this->coreModel->getTransactionTypeConfig($transaction['type']);
                                ?>
                                 <div class="flex items-start mb-8">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                        <i class="fas <?php echo $transactionType['icon']; ?> text-green-600 text-sm lg:text-base"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium text-gray-900 font-heading"><?php echo $transaction['title']; ?></p>
                                                <p class="text-sm text-gray-600 font-body"><?php echo $transaction['description']; ?></p>
                                            </div>
                                            <span class="text-sm text-green-600 font-bold font-heading"><?php echo $transaction['points']; ?></span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1 font-body"><?php echo date('F j, Y', strtotime($transaction['date'])); ?></p>
                                    </div>
                                </div>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="lg:w-1/2">
                    <div class="bg-white rounded-xl shadow h-full">
                        <div class="p-4 lg:p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 font-heading mobile-text-lg">Quick Actions</h3>
                        </div>
                        <div class="p-4 lg:p-6">
                            <div class="grid grid-cols-2 gap-3 lg:gap-4">
                                <!-- Action Buttons -->
                                <a href="redeem" class="flex flex-col items-center justify-center p-3 lg:p-4 border-2 border-gray-200 rounded-xl hover:border-[#CC9933] hover:bg-[#CC9933]/5 transition-all duration-300 mobile-tap-target">
                                    <div class="w-10 h-10 lg:w-14 lg:h-14 rounded-full gold-gradient flex items-center justify-center mb-2">
                                        <i class="fas fa-gift text-white text-lg lg:text-xl"></i>
                                    </div>
                                    <span class="font-medium text-gray-900 font-heading text-center text-sm lg:text-base">Redeem</span>
                                </a>

                                <a href="partners" class="flex flex-col items-center justify-center p-3 lg:p-4 border-2 border-gray-200 rounded-xl hover:border-[#013220] hover:bg-[#013220]/5 transition-all duration-300 mobile-tap-target">
                                    <div class="w-10 h-10 lg:w-14 lg:h-14 rounded-full orchid-gradient flex items-center justify-center mb-2">
                                        <i class="fas fa-store text-white text-lg lg:text-xl"></i>
                                    </div>
                                    <span class="font-medium text-gray-900 font-heading text-center text-sm lg:text-base">Partners</span>
                                </a>

                                <a href="profile" class="flex flex-col items-center justify-center p-3 lg:p-4 border-2 border-gray-200 rounded-xl hover:border-purple-500 hover:bg-purple-50 transition-all duration-300 mobile-tap-target">
                                    <div class="w-10 h-10 lg:w-14 lg:h-14 rounded-full bg-purple-600 flex items-center justify-center mb-2">
                                        <i class="fas fa-user text-white text-lg lg:text-xl"></i>
                                    </div>
                                    <span class="font-medium text-gray-900 font-heading text-center text-sm lg:text-base">Profile</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partner Spotlight - Single column on mobile -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 font-heading mobile-text-lg">Partner Spotlight</h3>
                        <p class="text-gray-600 font-body mobile-text-sm hidden lg:block">Redeem your points at these popular locations</p>
                    </div>
                    <a href="partners.php" class="text-sm text-[#CC9933] hover:text-[#b3862d] font-heading">
                        View All
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                    <?php foreach ($allpartners as $partner): ?>
                        <!-- Sample Partner 1 -->
                        <div class="partner-card bg-white rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <!-- Logo -->
                                <div class="flex-shrink-0">
                                    <div class="partner-logo bg-gray-100 flex items-center justify-center">
                                        <?php echo $partner['logo'] != '' ? '<img src="' . 'public/images/' . $partner['logo'] . '" alt="Partner Logo" class="w-20 h-20 object-contain">' : '<i class="fas fa-coffee text-gray-400 text-2xl"></i>'; ?>
                                    </div>
                                </div>
                                
                                <!-- Details -->
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 font-heading mb-1"><?php echo $partner['first_name'].' '.$partner['last_name'] ?></h3>
                                    <p class="text-gray-600 font-body text-sm mb-2">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                        <?php echo $partner['location'] ?>
                                    </p>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-phone text-gray-400 mr-2"></i>
                                        <span><?php echo $partner['phone'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>

            <!-- Bottom Stats - Stack on mobile -->
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-4 lg:gap-6">
                <!-- Monthly Summary -->
                <div class="bg-white rounded-xl shadow p-4 lg:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 font-heading mobile-text-lg">Monthly Summary</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-body mobile-text-sm">Total Points Earned</span>
                            <span class="font-bold text-green-600 font-heading">+<?php echo $summary['points_earned'] ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-body mobile-text-sm">Total Points Redeemed</span>
                            <span class="font-bold text-blue-600 font-heading">-<?php echo $summary['points_spent'] ?></span>
                        </div>
                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-body mobile-text-sm">Net Points Change</span>
                                <span class="font-bold text-[#013220] font-heading"><?php echo $summary['points_earned'] - $summary['points_spent'] ?></span>
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

        // Initialize progress bar animation
        document.addEventListener('DOMContentLoaded', () => {
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 300);
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

        console.log('Dashboard loaded successfully! Responsive across all devices.');
    </script>
</body>
</html>
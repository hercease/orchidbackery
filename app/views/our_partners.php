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
        
        /* Sidebar Styles */
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
        
        /* Mobile menu button */
        .menu-toggle {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1100;
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
        
        @media (max-width: 1023px) {
            main {
                margin-left: 0 !important;
            }
        }
        
        /* Partner card styling */
        .partner-card {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        
        .partner-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: #CC9933;
        }
        
        .partner-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 8px;
            background: white;
        }
        
        /* Prevent horizontal scroll */
        .no-horizontal-scroll {
            max-width: 100%;
            overflow-x: hidden;
        }
    </style>
</head>
<body class="bg-gray-50 font-body no-horizontal-scroll">
    <!-- Mobile Menu Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Mobile Menu Button -->
    <button id="menuToggle" class="menu-toggle">
        <div class="w-6 h-6 flex flex-col justify-center items-center">
            <span class="bar w-5 h-0.5 bg-gray-700 mb-1.5 transition-all duration-300"></span>
            <span class="bar w-5 h-0.5 bg-gray-700 mb-1.5 transition-all duration-300"></span>
            <span class="bar w-5 h-0.5 bg-gray-700 transition-all duration-300"></span>
        </div>
    </button>

    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="min-h-screen transition-all duration-300 lg:ml-[280px]" id="mainContent">
        <!-- Top Bar -->
        <div class="bg-white border-b border-gray-200 px-4 lg:px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-900 font-heading ml-20 lg:ml-0">Our Partners</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- User Menu -->
                    <div class="relative">
                        <button class="flex items-center space-x-2 p-1 rounded-lg hover:bg-gray-100 transition">
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
        <div class="p-4 lg:p-6">
            <!-- Page Header -->
            <div class="mb-8">
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 font-heading mb-2">Partner Stores</h2>
                <p class="text-gray-600 font-body">Discover all our trusted partners</p>
            </div>

         

            <!-- Partners Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <?php foreach ($allpartners as $partner): ?>
                    <!-- Sample Partner 1 -->
                    <div class="partner-card bg-white rounded-xl p-6">
                        <div class="flex items-start space-x-4">
                            <!-- Logo -->
                            <div class="flex-shrink-0">
                                <div class="partner-logo bg-gray-100 flex items-center justify-center">
                                    <?php echo $partner['logo'] != '' ? '<img src="' . 'public/images/' . $partner['logo'] . '" alt="Partner Logo" class="w-full h-full object-contain">' : '<i class="fas fa-coffee text-gray-400 text-2xl"></i>'; ?>
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

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 px-4 lg:px-6 py-4 mt-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-3 md:mb-0">
                    <p class="text-gray-600 text-sm font-body text-center md:text-left">
                        © <?php echo date('Y'); ?> Orchid Royal Bakery Loyalty Platform
                    </p>
                </div>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#" class="text-gray-500 hover:text-[#013220] text-sm font-body">Privacy</a>
                    <a href="#" class="text-gray-500 hover:text-[#013220] text-sm font-body">Terms</a>
                    <a href="#" class="text-gray-500 hover:text-[#013220] text-sm font-body">Help</a>
                    <a href="#" class="text-gray-500 hover:text-[#013220] text-sm font-body">Contact</a>
                </div>
            </div>
        </footer>
    </main>

    <script>
        // Sidebar functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('closeSidebar');
        const menuToggle = document.getElementById('menuToggle');
        
        // Open sidebar
        function openSidebar() {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
            menuToggle.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Close sidebar
        function closeSidebarFunc() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            menuToggle.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Event Listeners
        menuToggle.addEventListener('click', openSidebar);
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
        
        console.log('Partners page loaded successfully!');
    </script>
</body>
</html>
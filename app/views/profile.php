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

        /* Profile specific styles */
        .profile-pic-upload {
            transition: all 0.3s ease;
        }
        
        .profile-pic-upload:hover {
            transform: scale(1.05);
        }
        
        .edit-mode {
            border-color: #CC9933;
            box-shadow: 0 0 0 3px rgba(204, 153, 51, 0.1);
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .tab-button {
            transition: all 0.3s ease;
        }
        
        .tab-button.active {
            background-color: #013220;
            color: white;
        }
        
        /* File upload styling */
        input[type="file"] {
            display: none;
        }
        
        .file-upload-label {
            cursor: pointer;
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
                    <h1 class="text-xl font-bold text-gray-900 font-heading mobile-text-lg lg:ml-[10px] ml-[60px]">Profile</h1>
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
        <div class="p-4 lg:p-6 container-padding">

            <div class="bg-white rounded-xl shadow p-6 mb-6 lg:mt-0 mt-20">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-center mb-6 lg:mb-0 ">
                        <!-- Profile Picture -->
                        <div class="relative">
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-[#013220] to-[#0a4d2e] flex items-center justify-center overflow-hidden border-4 border-white shadow-lg">
                                <img id="profileImage" src="" alt="Profile" class="w-full h-full object-cover hidden">
                                <div id="profileInitials" class="text-white text-3xl font-bold font-heading"><?php echo $initials ?></div>
                            </div>
                            
                            <!-- Upload Button 
                            <label for="profileUpload" class="file-upload-label">
                                <div class="absolute bottom-0 right-0 w-10 h-10 rounded-full gold-bg flex items-center justify-center cursor-pointer hover:bg-[#b3862d] transition profile-pic-upload shadow-md">
                                    <i class="fas fa-camera text-white"></i>
                                </div>
                                <input type="file" id="profileUpload" accept="image/*" class="hidden">
                            </label>-->
                        </div>
                        
                        <div class="ml-6">
                            <h2 class="text-2xl font-bold text-gray-900 font-heading"><?php echo $fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name'] ?></h2>
                            <p class="text-gray-600"><?php echo $fetchuserdetails['email'] ?></p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm text-gray-500">Member since <?php echo date('F Y', strtotime($fetchuserdetails['created_at'])) ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 lg:grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-gray-50 rounded-lg stat-card">
                            <div class="text-2xl font-bold text-[#013220] font-heading"><?php echo number_format($fetchuserdetails['points_balance']) ?></div>
                            <div class="text-sm text-gray-600 font-body">Points</div>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg stat-card">
                            <div class="text-2xl font-bold text-[#013220] font-heading">0</div>
                            <div class="text-sm text-gray-600 font-body">Redemptions</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex overflow-x-auto border-b border-gray-200">
                    <button class="tab-button flex-shrink-0 px-4 lg:px-6 py-3 font-medium text-gray-600 hover:text-[#013220] border-b-2 border-transparent hover:border-[#013220] transition font-heading active" data-tab="personal">
                        <i class="fas fa-user mr-2"></i>
                        Personal Info
                    </button>
                    <button class="tab-button flex-shrink-0 px-4 lg:px-6 py-3 font-medium text-gray-600 hover:text-[#013220] border-b-2 border-transparent hover:border-[#013220] transition font-heading" data-tab="security">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Security
                    </button>
                    <!--<button class="tab-button flex-shrink-0 px-4 lg:px-6 py-3 font-medium text-gray-600 hover:text-[#013220] border-b-2 border-transparent hover:border-[#013220] transition font-heading" data-tab="activity">
                        <i class="fas fa-history mr-2"></i>
                        Points history
                    </button>-->
                </div>
            </div>

            <div class="space-y-6">
                <!-- Personal Info Tab -->
                <div id="personal-tab" class="tab-content">
                    <div class="bg-white rounded-xl shadow">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900 font-heading">Personal Information</h3>
                                <button id="editPersonalBtn" class="text-[#CC9933] hover:text-[#b3862d] font-medium font-heading">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit Information
                                </button>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <form id="personalForm">
                                <div class="grid md:grid-cols-2 gap-6">
                                    <!-- First Name -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                            First Name
                                        </label>
                                        <input type="text" id="firstName" name="first_name" value="<?php echo $fetchuserdetails['first_name'] ?? ''; ?>" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body" 
                                               disabled>
                                    </div>
                                    
                                    <!-- Last Name -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                            Last Name
                                        </label>
                                        <input type="text" id="lastName" name="last_name" value="<?php echo $fetchuserdetails['last_name'] ?? ''; ?>" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body" 
                                               disabled>
                                    </div>
                                    
                                    <!-- Email -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                            Email Address
                                        </label>
                                        <input type="email" id="email" name="email" value="<?php echo $fetchuserdetails['email'] ?? ''; ?>" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body" 
                                               disabled>
                                        <p class="text-xs text-gray-500 mt-2 font-body">Your email is also your login ID</p>
                                    </div>
                                    
                                    <!-- Phone -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                            Phone Number
                                        </label>
                                        <input type="tel" id="phone" name="phone" value="<?php echo $fetchuserdetails['phone'] ?? '+234 8012345678'; ?>" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body" 
                                               disabled>
                                    </div>

                                </div>
                                
                                <!-- Form Actions -->
                                <div id="personalFormActions" class="hidden mt-6 pt-6 border-t border-gray-200">
                                    <div class="flex justify-end space-x-3">
                                        <button type="button" id="cancelPersonalBtn" 
                                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition duration-300 font-heading">
                                            Cancel
                                        </button>
                                        <button type="submit" 
                                                class="px-6 py-3 orchid-gradient text-white rounded-lg font-semibold hover:opacity-95 transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#013220] font-heading">
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Security Tab -->
                <div id="security-tab" class="tab-content hidden">
                    <div class="bg-white rounded-xl shadow">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 font-heading">Security Settings</h3>
                        </div>
                        
                        <div class="p-6">
                            <div class="space-y-6">
                                <!-- Change Password -->
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 font-heading">Change Password</h4>
                                            <p class="text-sm text-gray-600 font-body">Update your password regularly for security</p>
                                        </div>
                                        <button id="changePasswordBtn" class="text-[#CC9933] hover:text-[#b3862d] font-medium font-heading">
                                            Change Password
                                        </button>
                                    </div>
                                    
                                    <form id="passwordForm" class="hidden space-y-4 mt-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                                Current Password
                                            </label>
                                            <input type="password" name="current_password"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                                New Password
                                            </label>
                                            <input type="password" name="new_password"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                                Confirm New Password
                                            </label>
                                            <input type="password" name="confirm_password"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body">
                                        </div>
                                        
                                        <div class="flex justify-end space-x-3 pt-4">
                                            <button type="button" id="cancelPasswordBtn" 
                                                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition font-heading">
                                                Cancel
                                            </button>
                                            <button type="submit" 
                                                    class="px-4 py-2 orchid-gradient text-white rounded-lg font-medium hover:opacity-95 transition font-heading">
                                                Update Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Activity Tab -->
                <div id="activity-tab" class="tab-content hidden">
                    <div class="bg-white rounded-xl shadow">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900 font-heading">Account Activity</h3>
                                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body">
                                    <option>Last 30 days</option>
                                    <option>Last 3 months</option>
                                    <option>Last 6 months</option>
                                    <option>All time</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="space-y-4">
                                <!-- Activity Timeline -->
                                <div class="relative">
                                    <!-- Timeline Item -->
                                    <div class="flex items-start mb-8">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                            <i class="fas fa-coins text-green-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="font-medium text-gray-900 font-heading">Points Earned</p>
                                                    <p class="text-sm text-gray-600 font-body">Artisan Sourdough purchase at Orchid Bakery</p>
                                                </div>
                                                <span class="text-sm text-green-600 font-bold font-heading">+50</span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1 font-body">Today, 10:30 AM</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Timeline Item -->
                                    <div class="flex items-start mb-8">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                            <i class="fas fa-gift text-blue-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="font-medium text-gray-900 font-heading">Redemption</p>
                                                    <p class="text-sm text-gray-600 font-body">Starbucks - Caramel Macchiato</p>
                                                </div>
                                                <span class="text-sm text-blue-600 font-bold font-heading">-100</span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1 font-body">Yesterday, 3:15 PM</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Timeline Item -->
                                    <div class="flex items-start mb-8">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                            <i class="fas fa-user-edit text-purple-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="font-medium text-gray-900 font-heading">Profile Updated</p>
                                                    <p class="text-sm text-gray-600 font-body">Changed phone number</p>
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1 font-body">2 days ago</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Timeline Item -->
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                            <i class="fas fa-coins text-green-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="font-medium text-gray-900 font-heading">Monthly Bonus</p>
                                                    <p class="text-sm text-gray-600 font-body">Loyalty program bonus points</p>
                                                </div>
                                                <span class="text-sm text-green-600 font-bold font-heading">+200</span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1 font-body">5 days ago</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- View More Button -->
                                <div class="text-center mt-8">
                                    <button class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition font-heading">
                                        Load More Activity
                                    </button>
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

        // Tab Navigation
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                tabButtons.forEach(btn => btn.classList.remove('active', 'border-[#013220]', 'text-[#013220]'));
                // Add active class to clicked button
                button.classList.add('active', 'border-[#013220]', 'text-[#013220]');
                
                // Hide all tab contents
                tabContents.forEach(content => content.classList.add('hidden'));
                
                // Show selected tab content
                const tabId = button.getAttribute('data-tab');
                document.getElementById(`${tabId}-tab`).classList.remove('hidden');
            });
        });

        // Profile Picture Upload
        /*const profileUpload = document.getElementById('profileUpload');
        const profileImage = document.getElementById('profileImage');
        const profileInitials = document.getElementById('profileInitials');

        profileUpload.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    profileImage.src = e.target.result;
                    profileImage.classList.remove('hidden');
                    profileInitials.classList.add('hidden');
                    
                    // Show success notification
                    showNotification('Profile picture updated successfully!', 'success');
                };
                
                reader.readAsDataURL(file);
            }
        });*/

        // Edit Personal Information
        const editPersonalBtn = document.getElementById('editPersonalBtn');
        const personalForm = document.getElementById('personalForm');
        const personalFormActions = document.getElementById('personalFormActions');
        const cancelPersonalBtn = document.getElementById('cancelPersonalBtn');
        const formInputs = personalForm.querySelectorAll('input:not(#email), select, textarea');

        editPersonalBtn.addEventListener('click', () => {
            // Enable all inputs
            formInputs.forEach(input => {
                input.disabled = false;
                input.classList.add('edit-mode');
            });
            
            // Show form actions
            personalFormActions.classList.remove('hidden');
            
            // Hide edit button
            editPersonalBtn.classList.add('hidden');
        });

        cancelPersonalBtn.addEventListener('click', () => {
            // Disable all inputs
            formInputs.forEach(input => {
                input.disabled = true;
                input.classList.remove('edit-mode');
            });
            
            // Hide form actions
            personalFormActions.classList.add('hidden');
            
            // Show edit button
            editPersonalBtn.classList.remove('hidden');

            fetch('fetchprofileinfo', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('firstName').value = data.first_name;
                document.getElementById('lastName').value = data.last_name;
                document.getElementById('email').value = data.email;
                document.getElementById('phone').value = data.phone;
            }).catch(error => {
                console.error('Error fetching profile info:', error);
                showNotification('Failed to revert changes. Please try again.', 'error');
            })
            
        });

        // Personal Form Submission
        personalForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';
            submitBtn.disabled = true;

            // Here you would typically send the updated data to the server via AJAX/fetch
            const formData = new FormData(this);
            
            fetch('updateprofile', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response from the server
                console.log(data);
                if (data.status) {
                    showNotification(data.message || 'Profile updated successfully!', 'success');
                } else {
                    showNotification(data.message || 'Failed to update profile.', 'error');
                }

                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                // Hide form actions
                personalFormActions.classList.add('hidden');
                
                // Show edit button
                editPersonalBtn.classList.remove('hidden');
                
            })
            .catch(error => {
                console.error('Error updating profile:', error);
                showNotification('Network error occurred. Please try again.', 'error');
            });
            
        });

        // Change Password Toggle
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        const passwordForm = document.getElementById('passwordForm');
        const cancelPasswordBtn = document.getElementById('cancelPasswordBtn');

        changePasswordBtn.addEventListener('click', () => {
            passwordForm.classList.toggle('hidden');
            if (!passwordForm.classList.contains('hidden')) {
                changePasswordBtn.textContent = 'Cancel';
            } else {
                changePasswordBtn.textContent = 'Change Password';
            }
        });

        cancelPasswordBtn.addEventListener('click', () => {
            passwordForm.classList.add('hidden');
            changePasswordBtn.textContent = 'Change Password';
        });

        // Password Form Submission
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Updating...';
            submitBtn.disabled = true;

            // Here you would typically send the updated data to the server via AJAX/fetch
            const formData = new FormData(this);
            
            fetch('changepassword', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response from the server
                console.log(data);
                if (data.status) {
                    showNotification(data.message || 'Password updated successfully!', 'success');
                     // Hide form
                    passwordForm.classList.add('hidden');
                } else {
                    showNotification(data.message || 'Failed to update password.', 'error');
                }
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
               
                changePasswordBtn.textContent = 'Change Password';
            })
            .catch(error => {
                console.error('Error updating password:', error);
                showNotification('Network error occurred. Please try again.', 'error');
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
            
        });

        //Lets write a the fecth the activities history with load more functionality here
        // Points History/Activities Section
        const activitiesContainer = document.getElementById('activitiesContainer');
        const loadMoreContainer = document.getElementById('loadMoreContainer');
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        const noActivitiesMessage = document.getElementById('noActivitiesMessage');
        const activityFilter = document.getElementById('activityFilter');

        let currentPage = 1;
        let isLoading = false;
        let hasMore = true;
        let filterValue = '30'; // Default: Last 30 days

        // Initialize activities when tab is activated
        document.querySelector('[data-tab="activity"]').addEventListener('click', () => {
            if (activitiesContainer.children.length === 1) { // Only the loading spinner
                currentPage = 1;
                hasMore = true;
                fetchActivities(currentPage, filterValue);
            }
        });

        // Handle filter change
        activityFilter.addEventListener('change', (e) => {
            filterValue = e.target.value;
            currentPage = 1;
            hasMore = true;
            activitiesContainer.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-gray-400 text-2xl mb-2"></i>
                    <p class="text-gray-500 font-body">Loading activities...</p>
                </div>
            `;
            loadMoreContainer.style.display = 'none';
            noActivitiesMessage.classList.add('hidden');
            fetchActivities(currentPage, filterValue);
        });

        // Load more activities
        loadMoreBtn.addEventListener('click', () => {
            if (!isLoading && hasMore) {
                currentPage++;
                fetchActivities(currentPage, filterValue, true);
            }
        });

        // Fetch activities from endpoint
        function fetchActivities(page, filter = '30', append = false) {
            if (isLoading) return;
            
            isLoading = true;
            
            // Show loading state
            if (!append) {
                activitiesContainer.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-spinner fa-spin text-gray-400 text-2xl mb-2"></i>
                        <p class="text-gray-500 font-body">Loading activities...</p>
                    </div>
                `;
                loadMoreContainer.style.display = 'none';
                noActivitiesMessage.classList.add('hidden');
            } else {
                loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Loading...';
                loadMoreBtn.disabled = true;
            }
            
            // Prepare request data
            const formData = new FormData();
            formData.append('page', page);
            formData.append('filter', filter);
            formData.append('per_page', 10); // Load 10 items per page
            
            fetch('fetchactivities', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                isLoading = false;
                loadMoreBtn.innerHTML = 'Load More Activities';
                loadMoreBtn.disabled = false;
                
                if (data.status) {
                    const activities = data.activities || [];
                    
                    // Remove loading spinner if this is the first page
                    if (!append && page === 1) {
                        activitiesContainer.innerHTML = '';
                    }
                    
                    if (activities.length > 0) {
                        // Append activities to container
                        activities.forEach(activity => {
                            const activityElement = createActivityElement(activity);
                            activitiesContainer.appendChild(activityElement);
                        });
                        
                        // Show load more button if there are more activities
                        hasMore = activities.length >= 10; // If we got 10 items, there might be more
                        if (hasMore) {
                            loadMoreContainer.style.display = 'block';
                        } else {
                            loadMoreContainer.style.display = 'none';
                        }
                        
                        noActivitiesMessage.classList.add('hidden');
                    } else {
                        // No activities found
                        if (page === 1) {
                            activitiesContainer.innerHTML = '';
                            noActivitiesMessage.classList.remove('hidden');
                        }
                        loadMoreContainer.style.display = 'none';
                        hasMore = false;
                    }
                    
                    // Update stats if available
                    if (data.total_points !== undefined) {
                        updatePointsStats(data.total_points);
                    }
                    
                } else {
                    showNotification(data.message || 'Failed to load activities.', 'error');
                    
                    if (page === 1) {
                        activitiesContainer.innerHTML = `
                            <div class="text-center py-8">
                                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-700 font-heading mb-2">Unable to load activities</h4>
                                <p class="text-gray-500 font-body mb-4">${data.message || 'Please try again later.'}</p>
                                <button onclick="fetchActivities(1, filterValue)" class="px-4 py-2 text-[#CC9933] border border-[#CC9933] rounded-lg font-medium hover:bg-[#CC9933] hover:text-white transition font-heading">
                                    <i class="fas fa-redo mr-2"></i>Retry
                                </button>
                            </div>
                        `;
                    }
                }
            })
            .catch(error => {
                isLoading = false;
                loadMoreBtn.innerHTML = 'Load More Activities';
                loadMoreBtn.disabled = false;
                
                console.error('Error fetching activities:', error);
                
                if (page === 1) {
                    activitiesContainer.innerHTML = `
                        <div class="text-center py-8">
                            <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-700 font-heading mb-2">Network Error</h4>
                            <p class="text-gray-500 font-body mb-4">Unable to connect to server. Please check your connection.</p>
                            <button onclick="fetchActivities(1, filterValue)" class="px-4 py-2 text-[#CC9933] border border-[#CC9933] rounded-lg font-medium hover:bg-[#CC9933] hover:text-white transition font-heading">
                                <i class="fas fa-redo mr-2"></i>Retry
                            </button>
                        </div>
                    `;
                } else {
                    showNotification('Network error occurred. Please try again.', 'error');
                }
            });
        }

        // Create activity element based on activity data
        function createActivityElement(activity) {
            const div = document.createElement('div');
            div.className = 'flex items-start mb-8';
            
            // Determine icon and color based on activity type
            let icon = 'fa-coins';
            let bgColor = 'bg-green-100';
            let iconColor = 'text-green-600';
            let sign = '+';
            
            if (activity.type === 'bread_purchase') {
                icon = 'fa-gift';
                bgColor = 'bg-blue-100';
                iconColor = 'text-blue-600';
                sign = '+';
            } else if (activity.type === 'withdrawal') {
                icon = 'fa-user-edit';
                bgColor = 'bg-purple-100';
                iconColor = 'text-purple-600';
                sign = '-';
            } else if (activity.type === 'redemption') {
                icon = 'fa-award';
                bgColor = 'bg-yellow-100';
                iconColor = 'text-yellow-600';
                sign = '-';
            } else if (activity.type === 'code_conversion') {
                icon = 'fa-exchange-alt';
                bgColor = 'bg-indigo-100';
                iconColor = 'text-indigo-600';
                sign = '-';
            }

            
            // Format date
            const activityDate = new Date(activity.created_at);
            const now = new Date();
            const diffTime = Math.abs(now - activityDate);
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
            
            let timeText = '';
            if (diffDays === 0) {
                timeText = 'Today';
            } else if (diffDays === 1) {
                timeText = 'Yesterday';
            } else if (diffDays < 7) {
                timeText = `${diffDays} days ago`;
            } else if (diffDays < 30) {
                const weeks = Math.floor(diffDays / 7);
                timeText = `${weeks} week${weeks > 1 ? 's' : ''} ago`;
            } else {
                timeText = activityDate.toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric',
                    year: diffDays > 365 ? 'numeric' : undefined
                });
            }
            
            // Add time if it's today or yesterday
            if (diffDays <= 1) {
                const time = activityDate.toLocaleTimeString('en-US', { 
                    hour: 'numeric', 
                    minute: '2-digit',
                    hour12: true 
                });
                timeText += `, ${time}`;
            }
            
            div.innerHTML = `
                <div class="flex-shrink-0 w-10 h-10 rounded-full ${bgColor} flex items-center justify-center mr-4">
                    <i class="fas ${icon} ${iconColor}"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-gray-900 font-heading">${activity.title || activity.description || 'Activity'}</p>
                            <p class="text-sm text-gray-600 font-body">${activity.description || activity.details || ''}</p>
                        </div>
                        ${activity.points ? `
                        <span class="text-sm font-bold font-heading ${activity.points > 0 ? 'text-green-600' : 'text-blue-600'}">
                            ${sign}${Math.abs(activity.points)}
                        </span>
                        ` : ''}
                    </div>
                    <p class="text-xs text-gray-500 mt-1 font-body">${timeText}</p>
                </div>
            `;
            
            return div;
        }

        // Update points stats if needed
        function updatePointsStats(totalPoints) {
            // If you have a points element that needs updating
            const pointsElement = document.querySelector('.points-balance');
            if (pointsElement) {
                pointsElement.textContent = number_format(totalPoints);
            }
        }

        // Helper function for number formatting (similar to PHP's number_format)
        function number_format(number, decimals = 0) {
            return number.toLocaleString('en-US', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals
            });
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
                if (notification.parentElement) {
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

        console.log('Profile page loaded successfully!');
    </script>
</body>
</html>
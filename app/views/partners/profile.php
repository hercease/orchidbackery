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
        
        /* Profile specific styles */
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .profile-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }
        
        .profile-header {
            background: linear-gradient(135deg, #013220 0%, #0a4d2e 100%);
            color: white;
            padding: 2rem;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            overflow: hidden;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #64748b;
        }
        
        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .tab-button {
            padding: 1rem 1.5rem;
            font-weight: 500;
            color: #64748b;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }
        
        .tab-button:hover {
            color: #013220;
        }
        
        .tab-button.active {
            color: #013220;
            border-bottom-color: #013220;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #013220;
            box-shadow: 0 0 0 3px rgba(1, 50, 32, 0.1);
        }
        
        .btn-primary {
            background-color: #013220;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-primary:hover {
            background-color: #011a16;
            transform: translateY(-1px);
        }
        
        .file-upload {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 3rem;
            text-align: center;
            transition: all 0.2s;
        }
        
        .file-upload:hover {
            border-color: #013220;
            background-color: #f8fafc;
        }
        
        .file-upload.dragover {
            border-color: #013220;
            background-color: #f0fdf4;
        }
        
        .password-strength {
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .password-strength-meter {
            height: 100%;
            transition: width 0.3s ease;
        }
        
        .password-strength-0 { background-color: #ef4444; width: 25%; }
        .password-strength-1 { background-color: #f97316; width: 50%; }
        .password-strength-2 { background-color: #eab308; width: 75%; }
        .password-strength-3 { background-color: #22c55e; width: 100%; }
        
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
            z-index: 2000;
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
        
        /* Tab content - all visible initially */
        .tab-content {
            display: block;
            width: 100%;
        }
        
        /* Only hide non-active tabs on larger screens */
        @media (min-width: 768px) {
            .tab-content {
                display: none;
            }
            
            .tab-content.active {
                display: block;
            }
        }
        
        /* Mobile tabs become accordion */
        @media (max-width: 767px) {
            .tab-button {
                width: 100%;
                text-align: left;
                border-bottom: 1px solid #e5e7eb;
                border-radius: 0;
            }
            
            .tab-button.active {
                background-color: #f9fafb;
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
    <?php include __DIR__ . '/../includes/partner_sidebar.php'; ?>

    <!-- Loading Overlay -->
    <div id="loading" class="loading">
        <div class="loading-spinner"></div>
    </div>

    <!-- Main Content - Adjusted for mobile -->
    <main class="min-h-screen transition-all duration-300 lg:ml-[280px] safe-area-top" id="mainContent">
        <!-- Top Bar - Fixed for mobile -->
        <div class="bg-white border-b border-gray-200 px-4 lg:px-6 py-4 fixed top-0 right-0 left-0 z-40 shadow-sm lg:relative lg:top-auto lg:right-auto lg:left-auto">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="dashboard" class="text-gray-600 hover:text-gray-900 mr-4 lg:hidden">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-xl font-bold text-gray-900 font-heading mobile-text-lg lg:ml-[10px] ml-[30px]">Profile Settings</h1>
                </div>
                
                <a href="dashboard.php" class="text-sm text-gray-600 hover:text-gray-900 hidden lg:block">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Main Profile Content -->
        <div class="p-4 lg:p-6 container-padding mt-20 lg:mt-0">
            <!-- Alert Messages Container -->
            <div id="alertContainer"></div>

            <!-- Profile Header Card -->
            <div class="profile-card mb-6">
                <div class="profile-header">
                    <div class="flex flex-col md:flex-row md:items-center gap-6">
                        <!-- Profile Avatar -->
                        <div class="relative">
                            <div class="profile-avatar" id="profileAvatar">
                                <?php if (!empty($fetchuserdetails['logo'])): ?>
                                    <img src="<?php echo 'public/images/' . htmlspecialchars($fetchuserdetails['logo']); ?>" 
                                         alt="<?php echo htmlspecialchars($fetchuserdetails['first_name'].' '.$fetchuserdetails['last_name']); ?>"
                                         id="avatarImage">
                                <?php else: ?>
                                    <i class="fas fa-store"></i>
                                <?php endif; ?>
                            </div>
                            <button onclick="switchTab('logo')" 
                                    class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition mobile-tap-target">
                                <i class="fas fa-camera text-gray-700"></i>
                            </button>
                        </div>
                        
                        <!-- Partner Info -->
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold mb-2 font-heading">
                                <?php echo htmlspecialchars($fetchuserdetails['first_name'].' '.$fetchuserdetails['last_name']); ?>
                            </h2>
                            <p class="text-gray-300 mb-4 font-body"><?php echo htmlspecialchars($fetchuserdetails['email']); ?></p>
                            
                            <div class="flex flex-wrap gap-4">
                                <div class="flex items-center">
                                    <i class="fas fa-phone mr-2 text-gray-300"></i>
                                    <span class="text-gray-300 font-body"><?php echo htmlspecialchars($fetchuserdetails['phone']); ?></span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt mr-2 text-gray-300"></i>
                                    <span class="text-gray-300 font-body">
                                        Member since <?php echo date('M Y', strtotime($fetchuserdetails['created_at'])); ?>
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-wallet mr-2 text-gray-300"></i>
                                    <span class="text-gray-300 font-body">
                                        ₦<?php echo number_format($fetchuserdetails['wallet_balance'] ?? 0, 2); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="profile-card mb-6">
                <div class="border-b border-gray-200">
                    <div class="flex overflow-x-auto" id="tabsContainer">
                        <button id="profileTab" class="tab-button active" onclick="switchTab('profile')">
                            <i class="fas fa-user mr-2"></i> Profile Details
                        </button>
                        <button id="logoTab" class="tab-button" onclick="switchTab('logo')">
                            <i class="fas fa-image mr-2"></i> Business Logo
                        </button>
                        <button id="passwordTab" class="tab-button" onclick="switchTab('password')">
                            <i class="fas fa-lock mr-2"></i> Change Password
                        </button>
                    </div>
                </div>

                <!-- Profile Details Section -->
                <div id="profileContent" class="tab-content active p-4 md:p-6">
                    <form id="profileForm" class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 font-heading">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 font-body">First Name *</label>
                                    <input type="text" 
                                           name="first_name" 
                                           id="firstName"
                                           value="<?php echo htmlspecialchars($fetchuserdetails['first_name']); ?>"
                                           required
                                           class="form-input font-body">
                                    <div id="firstNameError" class="error-message hidden text-red-500 text-sm mt-1"></div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 font-body">Last Name *</label>
                                    <input type="text" 
                                           name="last_name" 
                                           id="lastName"
                                           value="<?php echo htmlspecialchars($fetchuserdetails['last_name']); ?>"
                                           required
                                           class="form-input font-body">
                                    <div id="lastNameError" class="error-message hidden text-red-500 text-sm mt-1"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 font-heading">Contact Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 font-body">Email Address *</label>
                                    <input type="email" 
                                           name="email" 
                                           id="email"
                                           value="<?php echo htmlspecialchars($fetchuserdetails['email']); ?>"
                                           required
                                           class="form-input font-body">
                                    <div id="emailError" class="error-message hidden text-red-500 text-sm mt-1"></div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 font-body">Phone Number *</label>
                                    <input type="tel" 
                                           name="phone" 
                                           id="phone"
                                           value="<?php echo htmlspecialchars($fetchuserdetails['phone']); ?>"
                                           required
                                           class="form-input font-body">
                                    <div id="phoneError" class="error-message hidden text-red-500 text-sm mt-1"></div>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2 font-body">Business Address</label>
                                    <textarea name="location" 
                                              id="location"
                                              rows="3"
                                              class="form-input font-body"><?php echo htmlspecialchars($fetchuserdetails['location'] ?? ''); ?></textarea>
                                    <div id="locationError" class="error-message hidden text-red-500 text-sm mt-1"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-4 md:pt-6 border-t border-gray-200">
                            <button type="button" onclick="updateProfile()" class="btn-primary font-body">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Logo Upload Section -->
                <div id="logoContent" class="tab-content p-4 md:p-6">
                    <div class="max-w-2xl mx-auto">
                        <div class="mb-6 md:mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 font-heading">Update Business Logo</h3>
                            <p class="text-gray-600 font-body">Upload a new logo for your business. This will be displayed on your profile.</p>
                        </div>
                        
                        <!-- Current Logo Preview -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3 font-body">Current Logo</label>
                            <div class="flex items-center justify-center p-4 md:p-6 bg-gray-50 rounded-lg">
                                <?php if (!empty($fetchuserdetails['logo'])): ?>
                                    <img src="<?php echo 'public/images/' . htmlspecialchars($fetchuserdetails['logo']); ?>" 
                                         alt="Current Logo"
                                         class="max-w-xs max-h-48 object-contain">
                                <?php else: ?>
                                    <div class="text-center">
                                        <i class="fas fa-store text-6xl text-gray-400 mb-4"></i>
                                        <p class="text-gray-500 font-body">No logo uploaded yet</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- File Upload Area -->
                        <div class="file-upload mb-6" id="uploadArea">
                            <input type="file" 
                                   name="logo" 
                                   id="logoInput" 
                                   accept="image/*"
                                   class="hidden">
                            
                            <div class="mb-4">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                <p class="text-lg font-medium text-gray-700 mb-2 font-heading">Upload your logo</p>
                                <p class="text-gray-500 mb-4 font-body">Drag & drop your image here, or click to browse</p>
                                <button type="button" onclick="document.getElementById('logoInput').click()" 
                                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition font-body">
                                    Choose File
                                </button>
                            </div>
                            
                            <div class="text-sm text-gray-500 font-body">
                                <p>Supported formats: JPG, PNG, GIF</p>
                                <p>Max file size: 5MB</p>
                            </div>
                        </div>
                        
                        <!-- Preview -->
                        <div id="logoPreview" class="hidden mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3 font-body">New Logo Preview</label>
                            <div class="flex items-center justify-center p-4 md:p-6 bg-gray-50 rounded-lg">
                                <img id="previewImage" class="max-w-xs max-h-48 object-contain">
                            </div>
                        </div>
                        
                        <div class="pt-4 md:pt-6 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button type="button" onclick="clearLogoPreview()" 
                                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-body">
                                    Cancel
                                </button>
                                <button type="button" onclick="uploadLogo()" class="btn-primary font-body">
                                    <i class="fas fa-upload mr-2"></i> Upload Logo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Change Password Section -->
                <div id="passwordContent" class="tab-content p-4 md:p-6">
                    <div class="max-w-md mx-auto">
                        <div class="mb-6 md:mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 font-heading">Change Password</h3>
                            <p class="text-gray-600 font-body">Update your password to keep your account secure.</p>
                        </div>
                        
                        <form id="passwordForm" class="space-y-4 md:space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 font-body">Current Password *</label>
                                <div class="relative">
                                    <input type="password" 
                                           name="current_password" 
                                           id="currentPassword"
                                           required
                                           class="form-input font-body pr-10">
                                    <button type="button" 
                                            onclick="togglePassword('currentPassword')"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div id="currentPasswordError" class="error-message hidden text-red-500 text-sm mt-1"></div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 font-body">New Password *</label>
                                <div class="relative">
                                    <input type="password" 
                                           name="new_password" 
                                           id="newPassword"
                                           required
                                           oninput="checkPasswordStrength(this.value)"
                                           class="form-input font-body pr-10">
                                    <button type="button" 
                                            onclick="togglePassword('newPassword')"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                
                                <!-- Password Strength Meter -->
                                <div class="mt-2">
                                    <div class="password-strength">
                                        <div id="passwordStrengthMeter" class="password-strength-meter"></div>
                                    </div>
                                    <p id="passwordStrengthText" class="text-xs text-gray-500 mt-1 font-body"></p>
                                </div>
                                
                                <!-- Password Requirements -->
                                <div class="mt-3 text-sm text-gray-600 font-body">
                                    <p class="font-medium mb-1">Password must contain:</p>
                                    <ul class="space-y-1">
                                        <li id="reqLength" class="flex items-center">
                                            <i class="fas fa-times text-red-500 mr-2 text-xs"></i>
                                            <span>At least 8 characters</span>
                                        </li>
                                        <li id="reqUppercase" class="flex items-center">
                                            <i class="fas fa-times text-red-500 mr-2 text-xs"></i>
                                            <span>One uppercase letter</span>
                                        </li>
                                        <li id="reqLowercase" class="flex items-center">
                                            <i class="fas fa-times text-red-500 mr-2 text-xs"></i>
                                            <span>One lowercase letter</span>
                                        </li>
                                        <li id="reqNumber" class="flex items-center">
                                            <i class="fas fa-times text-red-500 mr-2 text-xs"></i>
                                            <span>One number</span>
                                        </li>
                                        <li id="reqSpecial" class="flex items-center">
                                            <i class="fas fa-times text-red-500 mr-2 text-xs"></i>
                                            <span>One special character</span>
                                        </li>
                                    </ul>
                                </div>
                                <div id="newPasswordError" class="error-message hidden text-red-500 text-sm mt-1"></div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 font-body">Confirm New Password *</label>
                                <div class="relative">
                                    <input type="password" 
                                           name="confirm_password" 
                                           id="confirmPassword"
                                           required
                                           class="form-input font-body pr-10">
                                    <button type="button" 
                                            onclick="togglePassword('confirmPassword')"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <p id="passwordMatch" class="text-xs mt-1 hidden font-body"></p>
                                <div id="confirmPasswordError" class="error-message hidden text-red-500 text-sm mt-1"></div>
                            </div>
                            
                            <div class="pt-4 md:pt-6 border-t border-gray-200">
                                <button type="button" onclick="changePassword()" class="btn-primary font-body">
                                    <i class="fas fa-key mr-2"></i> Update Password
                                </button>
                            </div>
                        </form>
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
            
            // Handle tab display based on screen size
            handleTabDisplay();
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Initial check

        // Tab switching
        function switchTab(tabName) {
            console.log(tabName);
            // On mobile, all tabs are visible, just scroll to the section
            // On desktop, show/hide tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });
            
            document.getElementById(tabName + 'Content').classList.add('active');
            document.getElementById(tabName + 'Tab').classList.add('active');
            handleTabDisplay();
        }

        // Handle tab display based on screen size
        function handleTabDisplay() {
            const tabs = document.querySelectorAll('.tab-content');
            
          
                // Hide non-active tabs on desktop
                tabs.forEach(tab => {
                    if (!tab.classList.contains('active')) {
                        tab.style.display = 'none';
                    } else {
                        tab.style.display = 'block';
                    }
                });
        }

        // Initialize tab display
        handleTabDisplay();

        // File upload functionality
        const uploadArea = document.getElementById('uploadArea');
        const logoInput = document.getElementById('logoInput');
        
        // Drag and drop handlers
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight(e) {
            uploadArea.classList.add('dragover');
        }
        
        function unhighlight(e) {
            uploadArea.classList.remove('dragover');
        }
        
        uploadArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                logoInput.files = files;
                previewLogo(files[0]);
            }
        }
        
        // Logo preview
        logoInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                previewLogo(this.files[0]);
            }
        });
        
        function previewLogo(file) {
            const preview = document.getElementById('logoPreview');
            const previewImage = document.getElementById('previewImage');
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(file);
            }
        }
        
        function clearLogoPreview() {
            logoInput.value = '';
            document.getElementById('logoPreview').classList.add('hidden');
        }
        
        // Password strength checker
        function checkPasswordStrength(password) {
            const meter = document.getElementById('passwordStrengthMeter');
            const text = document.getElementById('passwordStrengthText');
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[^A-Za-z0-9]/.test(password)
            };
            
            // Update requirement indicators
            Object.keys(requirements).forEach(key => {
                const element = document.getElementById('req' + key.charAt(0).toUpperCase() + key.slice(1));
                if (element) {
                    const icon = element.querySelector('i');
                    icon.className = requirements[key] 
                        ? 'fas fa-check text-green-500 mr-2 text-xs' 
                        : 'fas fa-times text-red-500 mr-2 text-xs';
                }
            });
            
            // Calculate strength score
            let strength = 0;
            if (requirements.length) strength++;
            if (requirements.uppercase) strength++;
            if (requirements.lowercase) strength++;
            if (requirements.number) strength++;
            if (requirements.special) strength++;
            
            // Update meter
            meter.className = 'password-strength-meter password-strength-' + strength;
            
            // Update text
            const strengthTexts = [
                'Very Weak',
                'Weak',
                'Fair',
                'Good',
                'Strong'
            ];
            
            if (password.length === 0) {
                text.textContent = '';
            } else {
                text.textContent = 'Password strength: ' + strengthTexts[strength];
                text.className = strength >= 3 ? 'text-xs text-green-600 mt-1' : 'text-xs text-red-600 mt-1';
            }
            
            // Check password match
            const confirmPassword = document.getElementById('confirmPassword').value;
            checkPasswordMatch(password, confirmPassword);
        }
        
        // Password match checker
        function checkPasswordMatch(password, confirmPassword) {
            const matchElement = document.getElementById('passwordMatch');
            
            if (confirmPassword.length === 0) {
                matchElement.classList.add('hidden');
                return;
            }
            
            if (password === confirmPassword) {
                matchElement.textContent = 'Passwords match ✓';
                matchElement.className = 'text-xs text-green-600 mt-1';
                matchElement.classList.remove('hidden');
            } else {
                matchElement.textContent = 'Passwords do not match ✗';
                matchElement.className = 'text-xs text-red-600 mt-1';
                matchElement.classList.remove('hidden');
            }
        }
        
        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
        
        // Confirm password input listener
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const newPassword = document.getElementById('newPassword').value;
            checkPasswordMatch(newPassword, this.value);
        });
        
        // Show alert message
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-lg">&times;</button>
                </div>
            `;
            alertContainer.appendChild(alert);

            //add a scroll up
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
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
        
        // Clear all error messages
        function clearErrors() {
            document.querySelectorAll('.error-message').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
        }
        
        // API endpoint
        const API_BASE_URL = '/api/partner';
        
        // CSRF token (if using Laravel or similar)
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        // Update profile function
        async function updateProfile() {
            clearErrors();
            showLoading(true);
            
            const formData = {
                first_name: document.getElementById('firstName').value.trim(),
                last_name: document.getElementById('lastName').value.trim(),
                email: document.getElementById('email').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                location: document.getElementById('location').value.trim()
            };
            
            // Basic validation
            let hasError = false;
            if (!formData.first_name) {
                document.getElementById('firstNameError').textContent = 'First name is required';
                document.getElementById('firstNameError').classList.remove('hidden');
                hasError = true;
            }
            
            if (!formData.last_name) {
                document.getElementById('lastNameError').textContent = 'Last name is required';
                document.getElementById('lastNameError').classList.remove('hidden');
                hasError = true;
            }
            
            if (!formData.email) {
                document.getElementById('emailError').textContent = 'Email is required';
                document.getElementById('emailError').classList.remove('hidden');
                hasError = true;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
                document.getElementById('emailError').textContent = 'Please enter a valid email';
                document.getElementById('emailError').classList.remove('hidden');
                hasError = true;
            }
            
            if (!formData.phone) {
                document.getElementById('phoneError').textContent = 'Phone number is required';
                document.getElementById('phoneError').classList.remove('hidden');
                hasError = true;
            }
            
            if (hasError) {
                showLoading(false);
                return;
            }
            
            try {
                const response = await fetch('updateprofile', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams(formData)
                });
                
                const data = await response.json();
                
                if (response.ok && data.status) {
                    showAlert('Profile updated successfully!', 'success');
                    
                    // Update displayed name if changed
                    const nameElement = document.querySelector('.profile-header h2');
                    if (nameElement) {
                        nameElement.textContent = `${formData.first_name} ${formData.last_name}`;
                    }
                    
                    
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const errorElement = document.getElementById(field + 'Error');
                            if (errorElement) {
                                errorElement.textContent = data.errors[field][0];
                                errorElement.classList.remove('hidden');
                            }
                        });
                    } else {
                        showAlert(data.message || 'Failed to update profile', 'error');
                    }
                }
            } catch (error) {
                console.error('Error updating profile:', error);
                showAlert('An error occurred. Please try again.', 'error');
            } finally {
                showLoading(false);
            }
        }
        
        // Upload logo function
        async function uploadLogo() {
            clearErrors();
            
            const fileInput = document.getElementById('logoInput');
            if (!fileInput.files || !fileInput.files[0]) {
                showAlert('Please select a logo file to upload.', 'error');
                return;
            }
            
            const file = fileInput.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = ['image/jpeg', 'image/png'];
            
            if (file.size > maxSize) {
                showAlert('File size must be less than 5MB.', 'error');
                return;
            }
            
            if (!allowedTypes.includes(file.type)) {
                showAlert('Please upload a JPG or PNG image.', 'error');
                return;
            }
            
            showLoading(true);
            
            const formData = new FormData();
            formData.append('logo', file);
            
            try {
                const response = await fetch('update_partner_logo', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok && data.status) {
                    showAlert('Logo uploaded successfully!', 'success');
                    
                    // Update avatar image
                    const avatarImage = document.getElementById('avatarImage');
                    const avatarContainer = document.getElementById('profileAvatar');
                    
                    if (data.logo_url) {
                        if (avatarImage) {
                            avatarImage.src = 'public/images/' + data.file_name;
                        } else {
                            // Create image if it doesn't exist
                            const img = document.createElement('img');
                            img.id = 'avatarImage';
                            img.src = 'public/images/' + data.file_name;
                            img.alt = 'Profile Logo';
                            img.className = 'w-full h-full object-cover';
                            avatarContainer.innerHTML = '';
                            avatarContainer.appendChild(img);
                        }
                    }
                    
                    // Update current logo preview
                    const currentLogoImg = document.querySelector('#logoContent img[alt="Current Logo"]');
                    if (currentLogoImg && data.file_name) {
                        currentLogoImg.src = 'public/images/' + data.file_name;
                    }
                    
                    // Clear preview
                    clearLogoPreview();
                } else {
                    showAlert(data.message || 'Failed to upload logo', 'error');
                }
            } catch (error) {
                console.error('Error uploading logo:', error);
                showAlert('An error occurred. Please try again.', 'error');
            } finally {
                showLoading(false);
            }
        }
        
        // Change password function
        async function changePassword() {
            clearErrors();
            showLoading(true);
            
            const formData = {
                current_password: document.getElementById('currentPassword').value,
                new_password: document.getElementById('newPassword').value,
                confirm_password: document.getElementById('confirmPassword').value
            };
            
            // Validation
            let hasError = false;
            
            if (!formData.current_password) {
                document.getElementById('currentPasswordError').textContent = 'Current password is required';
                document.getElementById('currentPasswordError').classList.remove('hidden');
                hasError = true;
            }
            
            if (!formData.new_password) {
                document.getElementById('newPasswordError').textContent = 'New password is required';
                document.getElementById('newPasswordError').classList.remove('hidden');
                hasError = true;
            } else if (formData.new_password.length < 8) {
                document.getElementById('newPasswordError').textContent = 'Password must be at least 8 characters';
                document.getElementById('newPasswordError').classList.remove('hidden');
                hasError = true;
            }
            
            if (!formData.confirm_password) {
                document.getElementById('confirmPasswordError').textContent = 'Please confirm your password';
                document.getElementById('confirmPasswordError').classList.remove('hidden');
                hasError = true;
            } else if (formData.new_password !== formData.confirm_password) {
                document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
                document.getElementById('confirmPasswordError').classList.remove('hidden');
                hasError = true;
            }
            
            if (hasError) {
                showLoading(false);
                return;
            }
            
            try {
                // Send password change request
                const response = await fetch('changepassword', {
                    method: 'POST',
                    body: new URLSearchParams(formData)
                });
                
                const data = await response.json();
                
                if (response.ok && data.status) {
                    showAlert('Password updated successfully!', 'success');
                    
                    // Clear form
                    document.getElementById('passwordForm').reset();
                    document.getElementById('passwordStrengthMeter').className = 'password-strength-meter';
                    document.getElementById('passwordStrengthText').textContent = '';
                    document.getElementById('passwordMatch').classList.add('hidden');
                    
                    // Reset requirement indicators
                    document.querySelectorAll('#passwordContent i.fas').forEach(icon => {
                        icon.className = 'fas fa-times text-red-500 mr-2 text-xs';
                    });
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const errorElement = document.getElementById(field + 'Error');
                            if (errorElement) {
                                errorElement.textContent = data.errors[field][0];
                                errorElement.classList.remove('hidden');
                            }
                        });
                    } else {
                        showAlert(data.message || 'Failed to update password', 'error');
                    }
                }
            } catch (error) {
                console.error('Error changing password:', error);
                showAlert('An error occurred. Please try again.', 'error');
            } finally {
                showLoading(false);
            }
        }
        
        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide messages after 5 seconds
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.remove();
                });
            }, 5000);
            
            console.log('Profile page loaded successfully!');
        });
    </script>
</body>
</html>
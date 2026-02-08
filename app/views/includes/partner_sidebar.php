<aside class="sidebar" id="sidebar">
        <!-- Logo Section -->
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full gold-bg flex items-center justify-center mr-3">
                        <i class="fas fa-bread-slice text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold font-heading">Orchid Bakery</h2>
                        <p class="text-xs text-gray-300">Loyalty Portal</p>
                    </div>
                </div>
                
                <!-- Close Button for Mobile -->
                <button class="lg:hidden text-white hover:text-gray-300 transition mobile-tap-target" id="closeSidebar">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- User Profile -->
        <div class="p-4 border-b border-white/10">
            <div class="flex items-center">
                <div class="relative">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center mr-3 overflow-hidden">
                        <?php if($fetchuserdetails['logo'] != ""){ ?><img src="<?php echo 'public/images/' . $fetchuserdetails['logo'] ?>" class="w-full h-full object-cover" alt="Profile Picture"><?php }else{ ?><i class="fas fa-user text-gray-600 text-xl"></i><?php } ?>
                        <!-- Online Status Indicator -->
                        <div class="absolute bottom-0 right-2 w-3 h-3 bg-green-500 rounded-full border-2 border-[#013220]"></div>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold font-heading mobile-text-sm"><?php echo $fetchuserdetails['first_name'].' '.$fetchuserdetails['last_name'] ?></h3>
                </div>
            </div>
            
            
        </div>

        <!-- Navigation -->
        <div class="sidebar-content">
            <nav class="p-3">
                <ul class="space-y-1">
                    <li class="touch-spacing">
                        <a href="dashboard" class="flex items-center p-3 rounded-lg gold-bg text-white font-heading hover:opacity-90 transition-all duration-200 mobile-tap-target">
                            <i class="fas fa-home mr-3 w-5 text-center"></i>
                            <span class="mobile-text-sm">Dashboard</span>
                            <span class="ml-auto bg-white/20 text-xs px-2 py-1 rounded">Home</span>
                        </a>
                    </li>
                    <li class="touch-spacing">
                        <a href="profile" class="flex items-center p-3 rounded-lg hover:bg-white/10 transition-all duration-200 group mobile-tap-target">
                            <i class="fas fa-user mr-3 w-5 text-center text-gray-400 group-hover:text-white"></i>
                            <span class="text-gray-300 group-hover:text-white mobile-text-sm">My Profile</span>
                            <i class="fas fa-chevron-right ml-auto text-xs text-gray-500 group-hover:text-white"></i>
                        </a>
                    </li>
                    <li class="touch-spacing">
                        <a href="code_redemption" class="flex items-center p-3 rounded-lg hover:bg-white/10 transition-all duration-200 group mobile-tap-target">
                            <i class="fas fa-gift mr-3 w-5 text-center text-gray-400 group-hover:text-white"></i>
                            <span class="text-gray-300 group-hover:text-white mobile-text-sm">Point Redemption</span>
                            <i class="fas fa-external-link-alt ml-auto text-xs text-gray-500 group-hover:text-white"></i>
                        </a>
                    </li>
                    <li class="touch-spacing">
                        <a href="transaction_history" class="flex items-center p-3 rounded-lg hover:bg-white/10 transition-all duration-200 group mobile-tap-target">
                            <i class="fas fa-history mr-3 w-5 text-center text-gray-400 group-hover:text-white"></i>
                            <span class="text-gray-300 group-hover:text-white mobile-text-sm">Transaction History</span>
                            <i class="fas fa-chevron-right ml-auto text-xs text-gray-500 group-hover:text-white"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Logout Section -->
        <div class="absolute bottom-0 w-full p-4 border-t border-white/10 bg-[#013220] safe-area-bottom">
            <a href="logout" class="flex items-center justify-center p-3 rounded-lg hover:bg-white/10 transition-all duration-200 group border border-white/20 mobile-tap-target">
                <i class="fas fa-sign-out-alt mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                <span class="font-medium font-heading mobile-text-sm">Logout</span>
            </a>
        </div>
    </aside>
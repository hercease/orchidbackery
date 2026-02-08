<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $metaTags; ?>
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
                    }
                }
            }
        }
    </script>
    <style>
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
        
        /* Status badge styles */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
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
                background-color: #013220;
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
        
        /* Transaction type icons */
        .transaction-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        
        /* Fade-in animation for new transactions */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
        
        /* Loading skeleton animation */
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }
        
        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite linear;
        }

        .sidebar {
            background-color: #013220;
            color: white;
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15);
            will-change: transform;
            width: 280px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" onclick="closeSidebar()"></div>
    
    <div class="flex h-screen">
        <!-- Sidebar Navigation -->
        <?php include 'includes/sidebar.php'; ?>
        
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
                        <h2 class="text-xl font-semibold text-gray-800">Transaction History</h2>
                    </div>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Total Transactions</p>
                                <p class="text-2xl font-bold mt-2 text-orchid-dark" id="totalTransactions">0</p>
                            </div>
                            <div class="p-3 rounded-full bg-orchid-dark/10">
                                <i class="fas fa-exchange-alt text-orchid-dark text-xl"></i>
                            </div>
                        </div>
                    </div>
                     <?php if($fetchuserdetails['acct_type']=='user'): ?>
                    <div class="bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Points Earned</p>
                                <p class="text-2xl font-bold mt-2 text-green-600" id="pointsEarned">0</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100">
                                <i class="fas fa-plus-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Points Spent</p>
                                <p class="text-2xl font-bold mt-2 text-orange-600" id="pointsSpent">0</p>
                            </div>
                            <div class="p-3 rounded-full bg-orange-100">
                                <i class="fas fa-minus-circle text-orange-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($fetchuserdetails['acct_type']=='partner'): ?>
                    <div class="bg-white rounded-xl shadow p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500">Total Withdrawn</p>
                                <p class="text-2xl font-bold mt-2 text-blue-600" id="totalWithdrawn">$0</p>
                            </div>
                            <div class="p-3 rounded-full bg-blue-100">
                                <i class="fas fa-money-bill-wave text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Filters and Search -->
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" id="searchTransactions" placeholder="Search transactions..." 
                                       class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent"
                                       onkeyup="filterTransactions()">
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <select id="typeFilter" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent" onchange="filterTransactions()">
                                <option value="">All Types</option>
                                <?php if($fetchuserdetails['acct_type']=='user'): ?>
                                    <option value="purchase">Purchase</option>
                                    <option value="point_redeem">Point Redeem</option>
                                <?php endif; ?>
                                <?php if($fetchuserdetails['acct_type']=='partner'): ?>
                                    <option value="redemption">Redemption</option>
                                    <option value="withdrawal">Withdrawal</option>
                                <?php endif; ?>
                            </select>
                            
                            <select id="dateFilter" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orchid-dark focus:border-transparent" onchange="filterTransactions()">
                                <option value="">All Time</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                                <option value="quarter">Last 3 Months</option>
                                <option value="year">This Year</option>
                            </select>
                            
                            <!--<button onclick="exportTransactions()" class="px-4 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                                <i class="fas fa-download mr-2"></i> Export
                            </button>-->
                        </div>
                    </div>
                </div>
                
                <!-- Transaction List -->
                <div class="bg-white rounded-xl shadow overflow-hidden mb-6">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-gray-800">Transaction History</h3>
                            <p class="text-sm text-gray-500" id="showingText">Showing recent transactions</p>
                        </div>
                        <div class="text-sm text-gray-600">
                            <span id="transactionCount">0 transactions</span>
                        </div>
                    </div>
                    
                    <!-- Transactions Container -->
                    <div id="transactionsContainer">
                        <!-- Transactions will be loaded here -->
                    </div>
                    
                    <!-- Load More Button -->
                    <div class="p-6 border-t border-gray-100 text-center" id="loadMoreContainer">
                        <button id="loadMoreBtn" onclick="loadMoreTransactions()" 
                                class="px-6 py-3 rounded-lg btn-primary font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-spinner fa-spin mr-2 hidden" id="loadMoreSpinner"></i>
                            <span id="loadMoreText">Load More Transactions</span>
                        </button>
                        <p class="text-sm text-gray-500 mt-2" id="loadMoreInfo">Scroll down or click to load more</p>
                    </div>
                </div>
                
                <!-- Empty State -->
                <div id="emptyState" class="hidden text-center py-12">
                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-exchange-alt text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">No Transactions Found</h3>
                    <p class="text-gray-600 mb-6">Your transaction history will appear here once you start using your Orchid Bakery account.</p>
                    <a href="redeem-points.html" class="inline-block px-6 py-3 rounded-lg btn-primary font-medium">
                        <i class="fas fa-gift mr-2"></i> Start Earning Points
                    </a>
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 p-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-500 mb-2 md:mb-0">© <?php echo date('Y'); ?> Orchid Royal Bakery Loyalty Platform. All rights reserved.</p>
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
    // API Configuration
    const API_BASE_URL = 'http://localhost/orchid-bakery/api'; // Update with your actual API URL
    const TRANSACTIONS_ENDPOINT = `fetchtransactionshistory`;
    const EXPORT_ENDPOINT = `${API_BASE_URL}/transactions/export`;
    const SUMMARY_ENDPOINT = `${API_BASE_URL}/transactions/summary`;
    
    // Global variables
    let displayedTransactions = [];
    let currentPage = 1;
    let isLoading = false;
    let hasMore = false;
    let totalTransactions = 0;
    
    // Transaction type configuration
    const transactionTypeConfig = {
        purchase: {
            icon: 'fa-shopping-cart',
            color: 'bg-green-500',
            textColor: 'text-green-600',
            bgColor: 'bg-green-50',
            label: 'Purchase',
            amountPrefix: '+',
            amountSuffix: 'points'
        },
        redemption: {
            icon: 'fa-gift',
            color: 'bg-purple-500',
            textColor: 'text-purple-600',
            bgColor: 'bg-purple-50',
            label: 'Redemption',
            amountPrefix: '-$',
            amountSuffix: ''
        },
        withdrawal: {
            icon: 'fa-money-bill-wave',
            color: 'bg-blue-500',
            textColor: 'text-blue-600',
            bgColor: 'bg-blue-50',
            label: 'Withdrawal',
            amountPrefix: '-$',
            amountSuffix: ''
        },
        point_redeem: {
            icon: 'fa-exchange-alt',
            color: 'bg-orange-500',
            textColor: 'text-orange-600',
            bgColor: 'bg-orange-50',
            label: 'Point Redeem',
            amountPrefix: '-',
            amountSuffix: 'points'
        },
        bonus: {
            icon: 'fa-star',
            color: 'bg-yellow-500',
            textColor: 'text-yellow-600',
            bgColor: 'bg-yellow-50',
            label: 'Bonus',
            amountPrefix: '+',
            amountSuffix: 'points'
        },
        adjustment: {
            icon: 'fa-adjust',
            color: 'bg-gray-500',
            textColor: 'text-gray-600',
            bgColor: 'bg-gray-50',
            label: 'Adjustment',
            amountPrefix: '',
            amountSuffix: 'points'
        }
    };
    
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
    
    // Format transaction amount based on type
    function formatTransactionAmount(transaction) {
        if (transaction.type === 'purchase') {
            const sign = transaction.points >= 0 ? '+' : '';
            return `${sign}${transaction.points} points`;
        } else if (transaction.type === 'redemption' || transaction.type === 'withdrawal') {
            return `-$${parseFloat(transaction.amount).toFixed(2)}`;
        } else if (transaction.type === 'point_redeem') {
            return `-${Math.abs(transaction.points)} points`;
        }
        
        return '';
    }
    
    // Format date for display
    function formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffTime = Math.abs(now - date);
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays === 0) {
            return 'Today';
        } else if (diffDays === 1) {
            return 'Yesterday';
        } else if (diffDays < 7) {
            return `${diffDays} days ago`;
        } else {
            return date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        }
    }
    
    // Format time for display
    function formatTime(dateString) {
        const date = new Date(dateString);
        return date.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit',
            hour12: true 
        });
    }
    
    // Render a single transaction
    function renderTransaction(transaction) {
        const config = transactionTypeConfig[transaction.type] || transactionTypeConfig.purchase;
        const amountText = formatTransactionAmount(transaction);
        
        const isPositive = (transaction.type === 'purchase' || transaction.type === 'bonus') || 
                          (transaction.type === 'adjustment' && transaction.points > 0);
        
        return `
            <div class="transaction-item fade-in border-b border-gray-100 hover:bg-gray-50 transition-colors">
                <div class="p-4 md:p-6">
                    <div class="flex items-start">
                        <!-- Transaction Icon -->
                        <div class="transaction-icon ${config.color} text-white mr-4 flex-shrink-0">
                            <i class="fas ${config.icon}"></i>
                        </div>
                        
                        <!-- Transaction Details -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-lg">${transaction.title}</h4>
                                    <p class="text-gray-600 text-sm mt-1">${transaction.description}</p>
                                    
                                    <!-- Additional Info -->
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <span class="px-2 py-1 rounded-full text-xs ${config.bgColor} ${config.textColor}">
                                            <i class="fas ${config.icon} mr-1"></i> ${config.label}
                                        </span>
                                        
                                        ${transaction.reference ? `
                                            <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">
                                                Ref: ${transaction.reference}
                                            </span>
                                        ` : ''}

                                        ${transaction.code ? `
                                            <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">
                                                Code : ${transaction.code}
                                            </span>
                                        ` : ''}
                                        
                                        ${transaction.location ? `
                                            <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">
                                                <i class="fas fa-map-marker-alt mr-1"></i> ${transaction.location}
                                            </span>
                                        ` : ''}
                                        
                                        ${transaction.partner ? `
                                            <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">
                                                <i class="fas fa-store mr-1"></i> ${transaction.partner}
                                            </span>
                                        ` : ''}
                                    </div>
                                </div>
                                
                                <!-- Amount and Date -->
                                <div class="text-right mt-3 md:mt-0 md:text-right">
                                    <div class="text-2xl font-bold ${isPositive ? 'text-green-600' : 'text-red-600'}">
                                        ${amountText}
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        <i class="far fa-clock mr-1"></i> ${formatDate(transaction.date)} at ${formatTime(transaction.date)}
                                    </div>
                                    ${transaction.status ? `
                                        <div class="mt-2">
                                            <span class="px-2 py-1 rounded-full text-xs ${transaction.status === 'completed' ? 'bg-green-100 text-green-800' : transaction.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}">
                                                <i class="fas ${transaction.status === 'completed' ? 'fa-check-circle' : transaction.status === 'pending' ? 'fa-clock' : 'fa-times-circle'} mr-1"></i> ${transaction.status}
                                            </span>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Render skeleton loading
    function renderSkeleton(count = 3) {
        let html = '';
        for (let i = 0; i < count; i++) {
            html += `
                <div class="border-b border-gray-100 p-6">
                    <div class="flex items-start">
                        <div class="w-12 h-12 rounded-lg shimmer mr-4"></div>
                        <div class="flex-1">
                            <div class="h-6 w-3/4 mb-2 shimmer rounded"></div>
                            <div class="h-4 w-1/2 mb-4 shimmer rounded"></div>
                            <div class="flex gap-2">
                                <div class="h-6 w-20 shimmer rounded-full"></div>
                                <div class="h-6 w-24 shimmer rounded-full"></div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="h-8 w-24 mb-2 shimmer rounded"></div>
                            <div class="h-4 w-32 shimmer rounded"></div>
                        </div>
                    </div>
                </div>
            `;
        }
        return html;
    }
    
    // Fetch transactions from API
    async function fetchTransactions(isInitial = false) {
        if (isLoading) return null;
        
        const container = document.getElementById('transactionsContainer');
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        const loadMoreSpinner = document.getElementById('loadMoreSpinner');
        const loadMoreText = document.getElementById('loadMoreText');
        const emptyState = document.getElementById('emptyState');
        
        if (isInitial) {
            container.innerHTML = renderSkeleton(3);
            loadMoreBtn.disabled = true;
            loadMoreSpinner.classList.remove('hidden');
            loadMoreText.textContent = 'Loading...';
        }
        
        isLoading = true;
        
        try {
            // Build query parameters
            const params = new URLSearchParams();
            params.append('page', currentPage);
            params.append('per_page', 10);
            
            // Add filters
            const typeFilter = document.getElementById('typeFilter').value;
            const searchTerm = document.getElementById('searchTransactions').value;
            const dateFilter = document.getElementById('dateFilter').value;
            
            if (typeFilter) params.append('type', typeFilter);
            if (searchTerm) params.append('search', searchTerm);
            if (dateFilter) params.append('date_filter', dateFilter);
            
            // Make API request
            const response = await fetch(`${TRANSACTIONS_ENDPOINT}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: params.toString()
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            console.log(result);
            
            if (!result.status) {
                throw new Error(result.message || 'Failed to fetch transactions');
            }
            
            const { transactions, pagination, summary } = result.data;
            
            // Update summary statistics
            updateSummary(summary);
            
            // Update pagination info
            currentPage = pagination.current_page;
            hasMore = pagination.has_more;
            totalTransactions = pagination.total;
            
            // Update UI
            const showingText = document.getElementById('showingText');
            const transactionCount = document.getElementById('transactionCount');
            
            if (isInitial) {
                container.innerHTML = '';
                displayedTransactions = [];
            }
            
            if (transactions && transactions.length > 0) {
                emptyState.classList.add('hidden');
                
                transactions.forEach(transaction => {
                    displayedTransactions.push(transaction);
                    container.innerHTML += renderTransaction(transaction);
                });
                
                showingText.textContent = `Showing ${displayedTransactions.length} of ${totalTransactions} transactions`;
                transactionCount.textContent = `${totalTransactions} transactions`;
                
                // Show/hide load more button
                if (hasMore) {
                    loadMoreBtn.classList.remove('hidden');
                    loadMoreText.textContent = 'Load More Transactions';
                } else {
                    loadMoreBtn.classList.add('hidden');
                    document.getElementById('loadMoreInfo').textContent = 'All transactions loaded';
                }
                
                // Increment page for next load
                if (hasMore) {
                    currentPage++;
                }
            } else {
                if (isInitial) {
                    container.innerHTML = '';
                    emptyState.classList.remove('hidden');
                    loadMoreBtn.classList.add('hidden');
                    showingText.textContent = 'No transactions found';
                    transactionCount.textContent = '0 transactions';
                }
            }
            
            return result;
            
        } catch (error) {
            console.error('Error fetching transactions:', error);
            
            // Show error state
            if (isInitial) {
                container.innerHTML = `
                    <div class="text-center py-12">
                        <div class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Failed to Load Transactions</h3>
                        <p class="text-gray-600 mb-6">${error.message}</p>
                        <button onclick="filterTransactions()" class="inline-block px-6 py-3 rounded-lg btn-primary font-medium">
                            <i class="fas fa-redo mr-2"></i> Try Again
                        </button>
                    </div>
                `;
                emptyState.classList.add('hidden');
            }
            
            return null;
        } finally {
            // Reset button state
            loadMoreBtn.disabled = false;
            loadMoreSpinner.classList.add('hidden');
            isLoading = false;
        }
    }
    
    // Fetch summary statistics
    /*async function fetchSummary() {
        try {
            const response = await fetch(SUMMARY_ENDPOINT, {
                method: 'GET',
                credentials: 'include',
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (result.success && result.data) {
                updateSummary(result.data);
            }
        } catch (error) {
            console.error('Error fetching summary:', error);
            // Use default values if API fails
            updateSummary({
                total_transactions: 0,
                points_earned: 0,
                points_spent: 0,
                total_withdrawn: 0,
                current_balance: 0
            });
        }
    }*/
    
    // Update summary statistics display
    function updateSummary(summary) {
     

        const totalTransaction = document.querySelector('#totalTransactions');
        const pointsEarned = document.querySelector('#pointsEarned');
        const pointsSpent = document.querySelector('#pointsSpent');
        const totalWithdrawn = document.querySelector('#totalWithdrawn');
        
        if (totalTransaction) {
            totalTransaction.textContent = summary.total_transactions.toLocaleString();
        }
        if (pointsEarned) {
            pointsEarned.textContent = summary.points_earned.toLocaleString();
        }
        if (pointsSpent) {
            pointsSpent.textContent = summary.points_spent.toLocaleString();
        }
        if (totalWithdrawn) {
            totalWithdrawn.textContent = `\u20A6${summary.total_withdrawn.toFixed(2)}`;
        }
        
        // Update points balance in sidebar
        const pointsBalanceElement = document.querySelector('.font-bold.text-orchid-gold');
        if (pointsBalanceElement) {
            pointsBalanceElement.textContent = summary.current_balance.toLocaleString();
        }
    }
    
    // Filter transactions (calls API with filters)
    function filterTransactions() {
        // Reset to first page
        currentPage = 1;
        displayedTransactions = [];
        
        // Fetch transactions with filters
        fetchTransactions(true);
    }
    
    // Load more transactions
    function loadMoreTransactions() {
        if (!hasMore || isLoading) return;
        fetchTransactions(false);
    }
    
    // Export transactions
    async function exportTransactions() {
        try {
            const typeFilter = document.getElementById('typeFilter').value;
            const searchTerm = document.getElementById('searchTransactions').value;
            const dateFilter = document.getElementById('dateFilter').value;
            
            // Build query parameters
            const params = new URLSearchParams();
            if (typeFilter) params.append('type', typeFilter);
            if (searchTerm) params.append('search', searchTerm);
            if (dateFilter) params.append('date_filter', dateFilter);
            
            const exportUrl = `${EXPORT_ENDPOINT}?${params.toString()}`;
            
            // Create a temporary link to trigger download
            const link = document.createElement('a');
            link.href = exportUrl;
            link.download = `orchid_transactions_${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
        } catch (error) {
            console.error('Error exporting transactions:', error);
            alert('Failed to export transactions. Please try again.');
        }
    }
    
    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Update date
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        //document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
        
        // Fetch initial data
        //fetchSummary();
        fetchTransactions(true);
        
        // Add debounce to search input
        let searchTimeout;
        document.getElementById('searchTransactions').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterTransactions();
            }, 500);
        });
        
        // Add change listeners to filters
        document.getElementById('typeFilter').addEventListener('change', filterTransactions);
        document.getElementById('dateFilter').addEventListener('change', filterTransactions);
        
        // Infinite scroll
        window.addEventListener('scroll', function() {
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            if (loadMoreBtn && !loadMoreBtn.classList.contains('hidden') && !isLoading) {
                const rect = loadMoreBtn.getBoundingClientRect();
                if (rect.top <= window.innerHeight + 100) {
                    loadMoreTransactions();
                }
            }
        });
        
        // Handle window resize for sidebar
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                closeSidebar();
            }
        });
    });
    
    // Add this helper function for better error messages
    function showNotification(message, type = 'error') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${type === 'success' ? 'bg-green-100 text-green-800 border-l-4 border-green-500' : type === 'warning' ? 'bg-orange-100 text-orange-800 border-l-4 border-orange-500' : 'bg-red-100 text-red-800 border-l-4 border-red-500'}`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-times-circle'} mr-3"></i>
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
</script>
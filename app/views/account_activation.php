<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $metaTags; ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f6f2 0%, #f0ede6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .activation-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(1, 50, 32, 0.1);
            overflow: hidden;
            max-width: 480px;
            width: 100%;
            margin: 20px;
        }
        
        .success-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 48px;
            animation: scaleIn 0.5s ease-out forwards;
        }
        
        .loading-icon {
            width: 80px;
            height: 80px;
            border: 6px solid #f3f3f3;
            border-top: 6px solid #013220;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(1, 50, 32, 0.4);
            }
            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 15px rgba(1, 50, 32, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(1, 50, 32, 0);
            }
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #013220 0%, #024d31 100%);
            color: white;
            transition: all 0.3s ease;
            padding: 14px 32px;
            font-weight: 600;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(1, 50, 32, 0.2);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(1, 50, 32, 0.3);
        }
        
        .btn-secondary {
            background: white;
            color: #013220;
            border: 2px solid #013220;
            transition: all 0.3s ease;
            padding: 14px 32px;
            font-weight: 600;
            border-radius: 12px;
        }
        
        .btn-secondary:hover {
            background: #013220;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(1, 50, 32, 0.2);
        }
    </style>
</head>
<body>
    <div class="activation-card">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orchid-dark to-orchid-dark/90 p-8 text-center text-white">
            <div class="flex items-center justify-center mb-6">
                <div class="w-16 h-16 rounded-full bg-orchid-gold flex items-center justify-center mr-4">
                    <i class="fas fa-bread-slice text-2xl text-orchid-dark"></i>
                </div>
                <div class="text-left">
                    <h1 class="text-3xl font-bold">Orchid Bakery</h1>
                    <p class="text-sm opacity-90">Loyalty & Rewards Platform</p>
                </div>
            </div>
            <h2 class="text-2xl font-bold">Account Activation</h2>
        </div>
        
        <!-- Activation Content -->
        <div class="p-8">
            <!-- Loading State -->
            <div id="loadingState" class="text-center">
                <div class="loading-icon mb-6"></div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Activating Your Account</h3>
                <p class="text-gray-600 mb-8">Please wait while we verify your account...</p>
            </div>
            
            <!-- Success State -->
            <div id="successState" class="text-center hidden">
                <div class="success-icon bg-green-100 text-green-600 mb-6">
                    <i class="fas fa-check"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Account Activated!</h3>
                <p class="text-gray-600 mb-6">Your Orchid Bakery account has been successfully activated.</p>
                
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-8">
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3 mt-1">
                            <i class="fas fa-user-check text-green-600"></i>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold text-green-800">Welcome to the Family!</h4>
                            <p class="text-sm text-green-700 mt-1">You can now start earning and redeeming points.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Next Steps -->
                <div class="mb-8 text-left">
                    <h4 class="font-bold text-gray-800 mb-4 text-lg">What's Next?</h4>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-orchid-gold/10 flex items-center justify-center mr-3 mt-1">
                                <i class="fas fa-sign-in-alt text-orchid-gold"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Login to Your Account</p>
                                <p class="text-sm text-gray-600">Access your dashboard and start exploring</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-orchid-gold/10 flex items-center justify-center mr-3 mt-1">
                                <i class="fas fa-coins text-orchid-gold"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Start Earning Points</p>
                                <p class="text-sm text-gray-600">Make purchases at Orchid Bakery to earn points</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-orchid-gold/10 flex items-center justify-center mr-3 mt-1">
                                <i class="fas fa-store text-orchid-gold"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Redeem at Partners</p>
                                <p class="text-sm text-gray-600">Use your points at partner cafes and stores</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="space-y-4">
                    <button onclick="goToLogin()" class="btn-primary w-full py-4 text-lg font-bold pulse">
                        <i class="fas fa-sign-in-alt mr-2"></i> Go to Login Page
                    </button>
                    
                    <button onclick="goToWebsite()" class="btn-secondary w-full py-4 text-lg">
                        <i class="fas fa-external-link-alt mr-2"></i> Visit Our Website
                    </button>
                </div>
            </div>
            
            <!-- Error State -->
            <div id="errorState" class="text-center hidden">
                <div class="success-icon bg-red-100 text-red-600 mb-6">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Activation Failed</h3>
                <p class="text-gray-600 mb-4" id="errorMessage">The activation link is invalid or has expired.</p>
                
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-8">
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3 mt-1">
                            <i class="fas fa-info-circle text-red-600"></i>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold text-red-800">What could have happened?</h4>
                            <ul class="text-sm text-red-700 mt-2 space-y-1">
                                <li class="flex items-start">
                                    <i class="fas fa-circle text-xs mt-1 mr-2"></i>
                                    The account is already activated
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-circle text-xs mt-1 mr-2"></i>
                                    The link was modified or incorrect
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons for Error -->
                <div class="space-y-4">
                    
                    <button onclick="goToLogin()" class="btn-secondary w-full py-4 text-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i> Try Logging In
                    </button>
                    
                    <button onclick="contactSupport()" class="w-full py-3 text-gray-700 hover:text-orchid-dark">
                        <i class="fas fa-headset mr-2"></i> Contact Support
                    </button>
                </div>
            </div>
            
            <!-- Already Activated State -->
            <div id="alreadyActivatedState" class="text-center hidden">
                <div class="success-icon bg-blue-100 text-blue-600 mb-6">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Account Already Active</h3>
                <p class="text-gray-600 mb-6">Your account has already been activated previously.</p>
                
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-8">
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3 mt-1">
                            <i class="fas fa-user-check text-blue-600"></i>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold text-blue-800">You're All Set!</h4>
                            <p class="text-sm text-blue-700 mt-1">You can proceed to login with your credentials.</p>
                        </div>
                    </div>
                </div>
                
                <button onclick="goToLogin()" class="btn-primary w-full py-4 text-lg font-bold">
                    <i class="fas fa-sign-in-alt mr-2"></i> Go to Login Page
                </button>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="bg-gray-50 border-t border-gray-200 p-6 text-center">
            <p class="text-sm text-gray-600 mb-4">
                Need help? Contact our support team:
                <a href="mailto:support@orchidroyalbakery.com" class="text-orchid-dark font-medium ml-1">support@orchidroyalbakery.com</a>
            </p>
            <div class="flex justify-center space-x-4">
                <a href="#" class="text-gray-400 hover:text-orchid-dark">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-orchid-dark">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-orchid-dark">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
            <p class="text-xs text-gray-500 mt-4">© <?php echo date('Y'); ?> Orchid Royal Bakery Loyalty Platform. All rights reserved.</p>
        </div>
    </div>

    <script>
        // URL Parameters
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('userid');
        console.log(token);
        
        // DOM Elements
        const loadingState = document.getElementById('loadingState');
        const successState = document.getElementById('successState');
        const errorState = document.getElementById('errorState');
        const alreadyActivatedState = document.getElementById('alreadyActivatedState');
        const errorMessage = document.getElementById('errorMessage');
        
        // Simulate activation process
        document.addEventListener('DOMContentLoaded', function() {
            // Hide all states initially
            loadingState.classList.remove('hidden');
            successState.classList.add('hidden');
            errorState.classList.add('hidden');
            alreadyActivatedState.classList.add('hidden');

            if (!token) {
                showError('Invalid activation link. No token provided.');
                return;
            }

            // function to calls the endpoint to activate account
            function activateAccount() {
                // Make the API call to activate the account
                fetch('activateAccount', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `userid=${encodeURIComponent(token)}`,
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.status === true) {
                        showSuccess();
                    } else if (data.status === false) {
                        showAlreadyActivated();
                    } else {
                        showError(data.message || 'Activation failed. Please try again.');
                    }
                })
                .catch(error => {
                    showError('An error occurred while activating your account. Please try again later.');
                    console.error('Activation Error:', error);
                });
            }
            
            activateAccount();
        });
        
        function showSuccess() {
            loadingState.classList.add('hidden');
            successState.classList.remove('hidden');
            
            // Add user email if available
            if (token) {
                const welcomeText = document.querySelector('#successState p.text-gray-600');
                if (welcomeText) {
                    welcomeText.innerHTML = `Your Orchid Bakery account <span class="font-bold text-orchid-dark">${token}</span> has been successfully activated.`;
                }
            }
        }
        
        function showError(message) {
            loadingState.classList.add('hidden');
            errorState.classList.remove('hidden');
            errorMessage.textContent = message;
        }
        
        function showAlreadyActivated() {
            loadingState.classList.add('hidden');
            alreadyActivatedState.classList.remove('hidden');
            
            // Add user email if available
            if (token) {
                const messageText = document.querySelector('#alreadyActivatedState p.text-gray-600');
                if (messageText) {
                    messageText.innerHTML = `Your account <span class="font-bold text-orchid-dark">${token}</span> is already active.`;
                }
            }
        }
        
        // Navigation Functions
        function goToLogin() {
            // In a real app, this would redirect to the login page
            // For demo, we'll show a message and simulate redirect
            const loginBtn = event?.target?.closest('button');
            if (loginBtn) {
                const originalText = loginBtn.innerHTML;
                loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Redirecting...';
                loginBtn.disabled = true;
                
                setTimeout(() => {
                    window.location.href = 'login';
                    loginBtn.innerHTML = originalText;
                    loginBtn.disabled = false;
                }, 1000);
            }
        }
        
        function goToWebsite() {
            // Redirect to main website
            window.open('https://orchidbakery.com', '_blank');
        }
        
        function contactSupport() {
            window.location.href = 'mailto:support@orchidbakery.com?subject=Account%20Activation%20Help';
        }
        
     
    </script>
</body>
</html>
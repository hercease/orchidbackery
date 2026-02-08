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
        body {
            font-family: 'Open Sans', sans-serif;
        }
        
        .font-heading {
            font-family: 'Montserrat', sans-serif;
        }
        
        .font-body {
            font-family: 'Open Sans', sans-serif;
        }
        
        .orchid-gradient {
            background: linear-gradient(135deg, #013220 0%, #0a4d2e 100%);
        }
        
        .gold-gradient {
            background: linear-gradient(135deg, #CC9933 0%, #e0b450 100%);
        }
        
        .password-strength {
            transition: all 0.3s ease;
        }
        
        /* Password visibility toggle animation */
        .toggle-password {
            transition: transform 0.3s ease;
        }
        
        .toggle-password:hover {
            transform: scale(1.1);
        }
        
        /* Countdown animation */
        @keyframes countdown {
            from { transform: scale(1); }
            to { transform: scale(1.1); }
        }
        
        .countdown-animation {
            animation: countdown 1s infinite alternate;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center font-body p-4">
    <!-- Back to Login Button -->
    <a href="login" class="absolute top-4 left-4 lg:top-6 lg:left-6 flex items-center text-gray-600 hover:text-[#013220] transition font-body">
        <i class="fas fa-arrow-left mr-2"></i>
        <span class="hidden sm:inline">Back to Login</span>
        <span class="sm:hidden">Back</span>
    </a>
    
    <!-- Main Container -->
    <div class="max-w-md w-full mx-auto">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full gold-gradient mb-4">
                <img src="public/logo/logo.png" alt="Orchid Bakery Logo">
            </div>
            <h1 class="text-3xl font-bold text-gray-900 font-heading">Orchid Royal Bakery</h1>
            <p class="text-gray-600 mt-2">Password Recovery</p>
        </div>
        
        <!-- Password Recovery Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
            <!-- Step Indicator -->
            <div class="mb-8">
                <div class="flex items-center justify-center mb-4">
                    <div class="flex items-center">
                        <!-- Step 1 -->
                        <div class="w-8 h-8 rounded-full orchid-gradient text-white flex items-center justify-center font-heading">
                            1
                        </div>
                        <div class="w-16 h-1 bg-gray-300 mx-2"></div>
                        
                        <!-- Step 2 -->
                        <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-heading">
                            2
                        </div>
                        <div class="w-16 h-1 bg-gray-300 mx-2"></div>
                        
                        <!-- Step 3 -->
                        <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-heading">
                            3
                        </div>
                    </div>
                </div>
                <div class="flex justify-between text-sm text-gray-600 font-body px-2">
                    <span>Enter Email</span>
                    <span>Verify Code</span>
                    <span>New Password</span>
                </div>
            </div>
            
            <!-- Step 1: Email Entry -->
            <div id="step1" class="step active">
                <h2 class="text-xl font-bold text-gray-900 mb-6 font-heading">Reset Your Password</h2>
                <p class="text-gray-600 mb-6 font-body">
                    Enter your email address and we'll send you a verification code to reset your password.
                </p>
                
                <form id="emailForm">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input 
                                type="email" 
                                id="email"
                                required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body"
                                placeholder="Enter your email address">
                        </div>
                        <p class="text-xs text-gray-500 mt-2 font-body">
                    Enter the email associated with your Orchid Bakery account.
                </p>
                    </div>
                    
                    <button type="submit" 
                            class="w-full orchid-gradient text-white py-3 px-4 rounded-lg font-semibold hover:opacity-95 transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#013220] font-heading">
                        Send Verification Code
                        <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-gray-600 text-sm font-body">
                        Remember your password? 
                        <a href="login.php" class="text-[#CC9933] hover:text-[#b3862d] font-medium">
                            Back to Login
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Step 2: Verification Code -->
            <div id="step2" class="step hidden">
                <h2 class="text-xl font-bold text-gray-900 mb-6 font-heading">Verify Your Email</h2>
                <p class="text-gray-600 mb-6 font-body">
                    We've sent a 6-digit verification code to <span id="userEmail" class="font-semibold text-[#013220]"></span>. 
                    Enter the code below to continue.
                </p>
                
                <form id="verificationForm">
                    <!-- OTP Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                            Verification Code
                        </label>
                        <div class="flex justify-between gap-2 mb-4">
                            <input type="text" maxlength="1" class="otp-digit w-10 h-10 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-[#CC9933] focus:ring-2 focus:ring-[#CC9933]/20 transition font-heading" 
                                   oninput="moveToNext(this)" onkeydown="handleOtpKeyDown(event, this)">
                            <input type="text" maxlength="1" class="otp-digit w-10 h-10 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-[#CC9933] focus:ring-2 focus:ring-[#CC9933]/20 transition font-heading" 
                                   oninput="moveToNext(this)" onkeydown="handleOtpKeyDown(event, this)">
                            <input type="text" maxlength="1" class="otp-digit w-10 h-10 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-[#CC9933] focus:ring-2 focus:ring-[#CC9933]/20 transition font-heading" 
                                   oninput="moveToNext(this)" onkeydown="handleOtpKeyDown(event, this)">
                            <input type="text" maxlength="1" class="otp-digit w-10 h-10 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-[#CC9933] focus:ring-2 focus:ring-[#CC9933]/20 transition font-heading" 
                                   oninput="moveToNext(this)" onkeydown="handleOtpKeyDown(event, this)">
                            <input type="text" maxlength="1" class="otp-digit w-10 h-10 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-[#CC9933] focus:ring-2 focus:ring-[#CC9933]/20 transition font-heading" 
                                   oninput="moveToNext(this)" onkeydown="handleOtpKeyDown(event, this)">
                            <input type="text" maxlength="1" class="otp-digit w-10 h-10 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-[#CC9933] focus:ring-2 focus:ring-[#CC9933]/20 transition font-heading" 
                                   oninput="moveToNext(this)" onkeydown="handleOtpKeyDown(event, this)">
                        </div>
                        
                        <!-- Countdown Timer -->
                        <div class="flex items-center justify-between mb-4">
                            <div id="countdown" class="text-sm text-gray-600 font-body">
                                Code expires in <span id="timer" class="font-bold text-[#013220]">05:00</span>
                            </div>
                            <button type="button" id="resendBtn" class="text-sm text-[#CC9933] hover:text-[#b3862d] font-medium font-heading disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                Resend Code
                            </button>
                        </div>
                        
                        <p class="text-xs text-gray-500 font-body">
                            Enter the 6-digit code sent to your email. Haven't received it? Check your spam folder.
                        </p>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="button" id="backToStep1" 
                                class="flex-1 py-3 px-4 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition duration-300 font-heading">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back
                        </button>
                        <button type="submit" 
                                class="flex-1 orchid-gradient text-white py-3 px-4 rounded-lg font-semibold hover:opacity-95 transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#013220] font-heading">
                            Verify Code
                            <i class="fas fa-check ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Step 3: New Password -->
            <div id="step3" class="step hidden">
                <h2 class="text-xl font-bold text-gray-900 mb-6 font-heading">Create New Password</h2>
                <p class="text-gray-600 mb-6 font-body">
                    Your identity has been verified. Please create a new secure password for your account.
                </p>
                
                <form id="passwordForm">
                    <div class="space-y-4">
                        <!-- New Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                New Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input 
                                    type="password" 
                                    id="newPassword"
                                    required
                                    class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body"
                                    placeholder="Enter new password">
                                <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                                </button>
                            </div>
                            
                            <!-- Password Strength Meter -->
                            <div class="mt-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600 font-heading">Password Strength</span>
                                    <span id="strengthText" class="text-sm font-bold font-heading">Weak</span>
                                </div>
                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div id="strengthBar" class="h-full bg-red-500 rounded-full password-strength" style="width: 25%"></div>
                                </div>
                                <div id="passwordCriteria" class="mt-2 text-xs text-gray-500 space-y-1 font-body hidden">
                                    <div class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> At least 8 characters</div>
                                    <div class="flex items-center"><i class="fas fa-times text-red-300 mr-2"></i> Uppercase & lowercase letters</div>
                                    <div class="flex items-center"><i class="fas fa-times text-red-300 mr-2"></i> At least one number</div>
                                    <div class="flex items-center"><i class="fas fa-times text-red-300 mr-2"></i> At least one special character</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                Confirm New Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input 
                                    type="password" 
                                    id="confirmPassword"
                                    required
                                    class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body"
                                    placeholder="Confirm new password">
                                <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                                </button>
                            </div>
                            <div id="passwordMatch" class="mt-2 text-sm hidden">
                                <i class="fas fa-check text-green-500 mr-1"></i>
                                <span class="text-green-600 font-body">Passwords match!</span>
                            </div>
                            <div id="passwordMismatch" class="mt-2 text-sm hidden">
                                <i class="fas fa-times text-red-500 mr-1"></i>
                                <span class="text-red-600 font-body">Passwords do not match</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Password Tips -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                        <h4 class="font-semibold text-blue-800 mb-2 font-heading">
                            <i class="fas fa-lightbulb mr-2"></i>
                            Password Tips
                        </h4>
                        <ul class="text-sm text-blue-700 space-y-1 font-body">
                            <li>• Use at least 8 characters with a mix of letters, numbers, and symbols</li>
                            <li>• Avoid common words or personal information</li>
                            <li>• Consider using a passphrase you can remember</li>
                        </ul>
                    </div>
                    
                    <div class="flex gap-3 mt-6">
                        <button type="button" id="backToStep2" 
                                class="flex-1 py-3 px-4 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition duration-300 font-heading">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back
                        </button>
                        <button type="submit" id="resetPasswordBtn"
                                class="flex-1 orchid-gradient text-white py-3 px-4 rounded-lg font-semibold hover:opacity-95 transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#013220] font-heading disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            Reset Password
                            <i class="fas fa-key ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Step 4: Success Message -->
            <div id="step4" class="step hidden">
                <div class="text-center py-8">
                    <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-check text-green-600 text-3xl"></i>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 font-heading">Password Reset Successfully!</h2>
                    
                    <p class="text-gray-600 mb-8 max-w-md mx-auto font-body">
                        Your password has been successfully reset. You can now log in to your Orchid Bakery account with your new password.
                    </p>
                    
                    <div class="space-y-4">
                        <a href="login" 
                           class="block w-full orchid-gradient text-white py-3 px-4 rounded-lg font-semibold hover:opacity-95 transition duration-300 font-heading">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Log In Now
                        </a>
                        
                        <a href="dashboard" 
                           class="block w-full py-3 px-4 border border-[#CC9933] text-[#CC9933] rounded-lg font-medium hover:bg-[#CC9933] hover:text-white transition duration-300 font-heading">
                            <i class="fas fa-home mr-2"></i>
                            Go to Dashboard
                        </a>
                    </div>
                    
                    <!-- Security Note -->
                    <div class="mt-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-body">
                            <i class="fas fa-shield-alt text-[#CC9933] mr-2"></i>
                            For security reasons, we recommend that you:
                        </p>
                        <ul class="text-xs text-gray-500 mt-2 space-y-1 font-body">
                            <li>• Log out from all other devices</li>
                            <li>• Review your recent account activity</li>
                            <li>• Enable two-factor authentication</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Support Information -->
        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm font-body">
                Need help? Contact our 
                <a href="mailto:support@orchidroyalbakery.com" class="text-[#CC9933] hover:text-[#b3862d] font-medium">
                    support team
                </a>
            </p>
        </div>
    </div>

    <script>
        // DOM Elements
        const steps = document.querySelectorAll('.step');
        const userEmailSpan = document.getElementById('userEmail');
        const resendBtn = document.getElementById('resendBtn');
        const timerSpan = document.getElementById('timer');
        const otpDigits = document.querySelectorAll('.otp-digit');
        const newPasswordInput = document.getElementById('newPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        const passwordCriteria = document.getElementById('passwordCriteria');
        const passwordMatchDiv = document.getElementById('passwordMatch');
        const passwordMismatchDiv = document.getElementById('passwordMismatch');
        const resetPasswordBtn = document.getElementById('resetPasswordBtn');
        const toggleButtons = document.querySelectorAll('.toggle-password');

        // State Variables
        let currentStep = 1;
        let timerInterval;
        let countdown = 0;
        let userEmail = '';

        // Step Navigation Functions
        function goToStep(step) {
            // Hide all steps
            steps.forEach(s => s.classList.add('hidden'));
            
            // Show target step
            document.getElementById(`step${step}`).classList.remove('hidden');
            
            // Update step indicators
            updateStepIndicators(step);
            
            currentStep = step;
        }

        function updateStepIndicators(step) {
            const indicators = document.querySelectorAll('.step-indicator');
            indicators.forEach((indicator, index) => {
                if (index + 1 <= step) {
                    indicator.classList.remove('bg-gray-200', 'text-gray-600');
                    indicator.classList.add('orchid-gradient', 'text-white');
                } else {
                    indicator.classList.remove('orchid-gradient', 'text-white');
                    indicator.classList.add('bg-gray-200', 'text-gray-600');
                }
            });
        }

        

        // Email Form Submission
        document.getElementById('emailForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            
            if (!validateEmail(email)) {
                showNotification('Please enter a valid email address', 'error');
                return;
            }
            
            userEmail = email;
            userEmailSpan.textContent = email;
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
            submitBtn.disabled = true;

            fetch('forgot_email_verification', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    email: email
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    countdown = data.countdown;
                    showNotification(data.message, 'success');
                    goToStep(2);
                    startCountdown();
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                } else {
                    showNotification(data.message || 'Failed to send verification code', 'error');
                }
            })
            
        });

        // Back to Step 1 Button
        document.getElementById('backToStep1').addEventListener('click', () => {
            goToStep(1);
        });

        // Verification Form Submission
        document.getElementById('verificationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get OTP value
            const otp = Array.from(otpDigits).map(digit => digit.value).join('');
            
            if (otp.length !== 6) {
                showNotification('Please enter the complete 6-digit code', 'error');
                return;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Verifying...';
            submitBtn.disabled = true;

            fetch('forgot_code_verification', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    email: userEmail,
                    code: otp
                })
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                if (data.status) {
                    showNotification(data.message, 'success');
                    goToStep(3);
                    stopCountdown();
                    
                } else {
                    showNotification(data.message || 'Failed to verify code', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Network error occurred', 'error');
            });
        });

        // Back to Step 2 Button
        document.getElementById('backToStep2').addEventListener('click', () => {
            goToStep(2);
        });

        // Password Form Submission
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const newPassword = newPasswordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (newPassword !== confirmPassword) {
                showNotification('Passwords do not match', 'error');
                return;
            }
            
            if (!checkPasswordStrength(newPassword).strong) {
                showNotification('Please create a stronger password', 'error');
                return;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Resetting...';
            submitBtn.disabled = true;

            fetch('forgot_password_reset', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    email: userEmail,
                    password: newPassword,
                    confirmPassword: confirmPassword
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    showNotification(data.message, 'success');
                    goToStep(4);
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                } else {
                    showNotification(data.message || 'Failed to reset password', 'error');
                }
            })
            
            // Simulate API call
            setTimeout(() => {
                showNotification('Password reset successful!', 'success');
                goToStep(4);
            }, 2000);
        });

        // Countdown Timer Functions
        function startCountdown() {
            updateTimerDisplay();
            
            clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                countdown--;
                updateTimerDisplay();
                
                if (countdown <= 0) {
                    stopCountdown();
                    resendBtn.disabled = false;
                    resendBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
                    showNotification('Verification code has expired', 'warning');
                }
            }, 1000);
        }

        function stopCountdown() {
            clearInterval(timerInterval);
        }

        function updateTimerDisplay() {
            const minutes = Math.floor(countdown / 60);
            const seconds = countdown % 60;
            timerSpan.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            // Add animation when less than 1 minute
            if (countdown <= 60) {
                timerSpan.classList.add('countdown-animation', 'text-red-500');
            } else {
                timerSpan.classList.remove('countdown-animation', 'text-red-500');
            }
        }

        // Resend Code Button
        resendBtn.addEventListener('click', function() {
            if (this.disabled) return;
            
            this.disabled = true;
            this.classList.add('disabled:opacity-50', 'disabled:cursor-not-allowed');
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
            
            // Simulate API call
            setTimeout(() => {
                startCountdown();
                this.disabled = true;
                this.innerHTML = 'Resend Code';
                showNotification('New verification code sent!', 'success');
            }, 1500);
        });

        // OTP Input Functions
        function moveToNext(input) {
            if (input.value.length === 1) {
                const nextInput = input.nextElementSibling;
                if (nextInput && nextInput.classList.contains('otp-digit')) {
                    nextInput.focus();
                    nextInput.select();
                }
            }
        }



        function handleOtpKeyDown(e, input) {
            if (e.key === 'Backspace' && input.value === '') {
                const prevInput = input.previousElementSibling;
                if (prevInput && prevInput.classList.contains('otp-digit')) {
                    prevInput.focus();
                    prevInput.select();
                }
            }
        }

        // Auto-focus first OTP input when step 2 loads
        otpDigits[0].focus();

        // Password Strength Checker
        newPasswordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            
            // Update strength bar
            strengthBar.style.width = `${strength.score}%`;
            strengthBar.className = `h-full rounded-full password-strength ${strength.color}`;
            
            // Update strength text
            strengthText.textContent = strength.text;
            strengthText.className = `text-sm font-bold font-heading ${strength.textColor}`;
            
            // Update criteria checkmarks
            updatePasswordCriteria(strength.criteria);
            
            // Check password match
            checkPasswordMatch();
            
            // Enable/disable reset button
            updateResetButton();
        });

        // Confirm Password Check
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);

        function checkPasswordMatch() {
            const password = newPasswordInput.value;
            const confirm = confirmPasswordInput.value;
            
            if (!password || !confirm) {
                passwordMatchDiv.classList.add('hidden');
                passwordMismatchDiv.classList.add('hidden');
                return;
            }
            
            if (password === confirm) {
                passwordMatchDiv.classList.remove('hidden');
                passwordMismatchDiv.classList.add('hidden');
            } else {
                passwordMatchDiv.classList.add('hidden');
                passwordMismatchDiv.classList.remove('hidden');
            }
            
            updateResetButton();
        }

        function checkPasswordStrength(password) {
            let score = 0;
            const criteria = {
                length: false,
                uppercase: false,
                lowercase: false,
                number: false,
                special: false
            };
            
            // Check length
            if (password.length >= 8) {
                score += 20;
                criteria.length = true;
            }
            
            // Check uppercase
            if (/[A-Z]/.test(password)) {
                score += 20;
                criteria.uppercase = true;
            }
            
            // Check lowercase
            if (/[a-z]/.test(password)) {
                score += 20;
                criteria.lowercase = true;
            }
            
            // Check number
            if (/[0-9]/.test(password)) {
                score += 20;
                criteria.number = true;
            }
            
            // Check special character
            if (/[^A-Za-z0-9]/.test(password)) {
                score += 20;
                criteria.special = true;
            }
            
            // Determine strength level
            let text, color, textColor;
            if (score >= 80) {
                text = 'Strong';
                color = 'bg-green-500';
                textColor = 'text-green-600';
            } else if (score >= 60) {
                text = 'Good';
                color = 'bg-blue-500';
                textColor = 'text-blue-600';
            } else if (score >= 40) {
                text = 'Fair';
                color = 'bg-yellow-500';
                textColor = 'text-yellow-600';
            } else {
                text = 'Weak';
                color = 'bg-red-500';
                textColor = 'text-red-600';
            }
            
            return {
                score,
                text,
                color,
                textColor,
                criteria,
                strong: score >= 80
            };
        }

        function updatePasswordCriteria(criteria) {
            const items = passwordCriteria.querySelectorAll('div');
            
            // Show/hide criteria box
            if (newPasswordInput.value.length > 0) {
                passwordCriteria.classList.remove('hidden');
            } else {
                passwordCriteria.classList.add('hidden');
                return;
            }
            
            // Update checkmarks
            items[0].querySelector('i').className = criteria.length ? 
                'fas fa-check text-green-500 mr-2' : 'fas fa-times text-red-300 mr-2';
            
            items[1].querySelector('i').className = (criteria.uppercase && criteria.lowercase) ? 
                'fas fa-check text-green-500 mr-2' : 'fas fa-times text-red-300 mr-2';
            
            items[2].querySelector('i').className = criteria.number ? 
                'fas fa-check text-green-500 mr-2' : 'fas fa-times text-red-300 mr-2';
            
            items[3].querySelector('i').className = criteria.special ? 
                'fas fa-check text-green-500 mr-2' : 'fas fa-times text-red-300 mr-2';
        }

        function updateResetButton() {
            const password = newPasswordInput.value;
            const confirm = confirmPasswordInput.value;
            const strength = checkPasswordStrength(password);
            
            if (password && confirm && password === confirm && strength.strong) {
                resetPasswordBtn.disabled = false;
                resetPasswordBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
            } else {
                resetPasswordBtn.disabled = true;
                resetPasswordBtn.classList.add('disabled:opacity-50', 'disabled:cursor-not-allowed');
            }
        }

        // Toggle Password Visibility
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.querySelector('i');
                const input = this.parentElement.querySelector('input');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'fas fa-eye-slash text-gray-600 hover:text-gray-800 cursor-pointer';
                } else {
                    input.type = 'password';
                    icon.className = 'fas fa-eye text-gray-400 hover:text-gray-600 cursor-pointer';
                }
            });
        });

        // Email Validation
        function validateEmail(email) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
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
                                                                                       type === 'warning' ? 'bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700' : 
                                                                                       'bg-green-100 border-l-4 border-green-500 text-green-700'}`;
            
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 
                                     type === 'warning' ? 'fa-exclamation-triangle' : 
                                     'fa-check-circle'} mr-3"></i>
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
            
            .step {
                transition: opacity 0.3s ease;
            }
        `;
        document.head.appendChild(style);

        // Initialize
        updateStepIndicators(1);

        console.log('Forgot Password page loaded successfully!');
    </script>
</body>
</html>
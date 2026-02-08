<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $metaTags; ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .orchid-gradient {
            background: linear-gradient(135deg, #013220 0%, #0a4d2e 100%);
        }
        .gold-gradient {
            background: linear-gradient(135deg, #CC9933 0%, #e0b450 100%);
        }
        .font-modern {
            font-family: 'Montserrat', sans-serif;
        }
        .font-readable {
            font-family: 'Open Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <!-- Logo Section -->
            <div class="mb-10">
                <div class="flex items-center justify-center gap-4 mb-4">
                    <img src="public/logo/logo.png" alt="Orchid Bakery Logo" class="w-16 h-16">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Orchid Bakery</h1>
                        <p class="text-gray-600 mt-2">Loyalty & Rewards Portal</p>
                    </div>
                </div>
            </div>

            <!-- Forgot Password Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <!-- Back to Login Link -->
                <div class="mb-6">
                    <a href="login" class="inline-flex items-center text-[#CC9933] hover:text-[#b3862d] font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Login
                    </a>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-2">Forgot Password?</h2>
                <p class="text-gray-600 mb-6 font-readable">
                    Enter your email address and we'll send you instructions to reset your password.
                </p>

                <form id="forgotPasswordForm" method="POST">
                    <div class="space-y-5">
                        <!-- Email Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="email" id="email" required
                                    class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition"
                                    placeholder="Enter your registered email">
                            </div>
                            <p class="mt-2 text-sm text-gray-500 font-readable">
                                Make sure this is the same email you used to sign up for your loyalty account.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full orchid-gradient text-white py-3 px-4 rounded-lg font-semibold hover:opacity-95 transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#013220]">
                            Send Reset Instructions
                        </button>

                        <!-- Alternative Options -->
                        <div class="pt-4">
                            <p class="text-center text-gray-600 text-sm mb-4 font-readable">
                                Need more help?
                            </p>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="#"
                                    class="flex-1 text-center py-2 px-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300 font-medium">
                                    <i class="fas fa-headset mr-2"></i>
                                    Contact Support
                                </a>
                                <a href="#"
                                    class="flex-1 text-center py-2 px-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300 font-medium">
                                    <i class="fas fa-question-circle mr-2"></i>
                                    View FAQ
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Success Message (Initially Hidden) -->
                <div id="successMessage" class="hidden mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">Reset instructions sent!</h3>
                            <div class="mt-2 text-sm text-green-700 font-readable">
                                <p>We've sent password reset instructions to your email. Please check your inbox and spam folder.</p>
                                <p class="mt-2">The link will expire in 1 hour for security reasons.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Don't have an account?</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div class="mt-6 text-center">
                        <a href="register.php"
                            class="inline-flex items-center justify-center w-full py-3 border border-[#CC9933] text-[#CC9933] rounded-lg font-medium hover:bg-[#CC9933] hover:text-white transition duration-300">
                            Create New Account
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-gray-500 text-sm">
                <p>© <?php echo date('Y'); ?> Orchid Bakery Loyalty Platform. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script>
        // Notification function (copied from your original code)
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${type === 'success' ? 'bg-green-100 text-green-800 border-l-4 border-green-500' : type === 'warning' ? 'bg-orange-100 text-orange-800 border-l-4 border-orange-500' : type === 'error' ? 'bg-red-100 text-red-800 border-l-4 border-red-500' : 'bg-blue-100 text-blue-800 border-l-4 border-blue-500'}`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'warning' ? 'fa-exclamation-triangle' : type === 'error' ? 'fa-times-circle' : 'fa-info-circle'} mr-3"></i>
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

        // Form validation and submission
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize jQuery Validate
            $('#forgotPasswordForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    email: {
                        required: 'Email is required',
                        email: 'Please enter a valid email address'
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid border-red-500');
                    $(element).removeClass('border-gray-300');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid border-red-500');
                    $(element).addClass('border-gray-300');
                },
                submitHandler: function(form) {
                    const submitButton = $(form).find('button[type="submit"]');
                    const email = $('#email').val();
                    
                    // Disable button and show loading state
                    submitButton.html('<i class="fas fa-spinner fa-spin mr-2"></i> Sending...').prop('disabled', true);
                    
                    // Simulate API call - Replace with actual AJAX call to your backend
                    setTimeout(() => {
                        // For demonstration purposes, we'll simulate a successful response
                        // In production, make an actual fetch/AJAX call to your reset password endpoint
                        
                        // Show success message in the form
                        $('#successMessage').removeClass('hidden');
                        $('#forgotPasswordForm').addClass('hidden');
                        
                        // Show notification
                        showNotification('Password reset instructions have been sent to ' + email, 'success');
                        
                        // Re-enable button after 5 seconds (in case of error)
                        setTimeout(() => {
                            submitButton.html('Send Reset Instructions').prop('disabled', false);
                        }, 5000);
                        
                        /*
                        // Actual API implementation example:
                        const formData = new FormData(form);
                        fetch('api/reset-password.php', {
                            method: 'POST',
                            body: formData
                        }).then(response => response.json())
                          .then(data => {
                            if (data.status) {
                                $('#successMessage').removeClass('hidden');
                                $('#forgotPasswordForm').addClass('hidden');
                                showNotification(data.message, 'success');
                            } else {
                                showNotification(data.message, 'error');
                                submitButton.html('Send Reset Instructions').prop('disabled', false);
                            }
                          })
                          .catch(error => {
                            console.error('Error:', error);
                            showNotification('An error occurred. Please try again.', 'error');
                            submitButton.html('Send Reset Instructions').prop('disabled', false);
                          });
                        */
                    }, 1500); // Simulated delay
                    
                    return false; // Prevent default form submission
                }
            });

            // Add visual feedback on focus
            $('input').on('focus', function() {
                $(this).parent().find('i').css('color', '#CC9933');
            }).on('blur', function() {
                if (!$(this).hasClass('is-invalid')) {
                    $(this).parent().find('i').css('color', '#9CA3AF');
                }
            });
        });
    </script>
</body>
</html>
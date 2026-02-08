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
                        <h1 class="text-2xl font-bold text-gray-900">Orchid Royal Bakery</h1>
                        <p class="text-gray-600 mt-2">Loyalty & Rewards Portal</p>
                    </div>
                </div>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Welcome Back</h2>

                <form id="loginForm" method="POST">
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
                                <input type="email" name="email" required
                                    class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition"
                                    placeholder="Enter your email">
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div>
                            <div class="flex justify-between mb-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Password
                                </label>
                                <a href="forgot_password"
                                    class="text-sm text-[#CC9933] hover:text-[#b3862d] font-medium">
                                    Forgot password?
                                </a>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="passwordInput" type="password" name="password" required
                                    class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition"
                                    placeholder="Enter your password">
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input type="checkbox" id="remember"
                                class="h-4 w-4 text-[#013220] focus:ring-[#013220] border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full orchid-gradient text-white py-3 px-4 rounded-lg font-semibold hover:opacity-95 transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#013220]">
                            Sign In
                        </button>
                    </div>
                </form>

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
                        <a href="register"
                            class="inline-flex items-center justify-center w-full py-3 border border-[#CC9933] text-[#CC9933] rounded-lg font-medium hover:bg-[#CC9933] hover:text-white transition duration-300">
                            Create New Account
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-gray-500 text-sm">
                <p>© <?php echo date('Y'); ?> Orchid Royal Bakery Loyalty Platform. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script>

        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('passwordInput');
            const icon = this.querySelector('i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

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

        //A post function to handle login can be added here
        // Include jQuery and jQuery Validate
        document.addEventListener('DOMContentLoaded', function() {
            
        
                // Initialize jQuery Validate
                $('#loginForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                messages: {
                    email: {
                        required: 'Email is required',
                        email: 'Please enter a valid email'
                    },
                    password: {
                        required: 'Password is required'
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "terms") {
                    error.insertAfter(element.parent());
                    } else {
                    error.insertAfter(element);
                    }
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    const submitButton = $(form).find('button[type="submit"]');
                    submitButton.html('<i class="fas fa-spinner fa-spin mr-2"></i> Logging in...').prop('disabled', true);
                    
                    const formData = new FormData(form);
                    fetch('login', {
                    method: 'POST',
                    body: formData
                    }).then(response => response.json())
                      .then(data => {
                      if (data.status) {
                          showNotification(data.message, 'success');
                          window.location.href = 'dashboard';
                      } else {
                          showNotification(data.message, 'error');
                          submitButton.html('Sign In').prop('disabled', false);
                      }
                      })
                      .catch(error => {
                      console.error('Error:', error);
                      submitButton.html('Sign In').prop('disabled', false);
                      });
                }
                });
        });

    </script>
</body>

</html>
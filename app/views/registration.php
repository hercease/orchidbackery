<!DOCTYPE html>
<html lang="en">
<head>
     <?php echo $metaTags; ?>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <!-- Font Awesome -->
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
        .gold-bg {
            background-color: #CC9933;
        }

        form .error {
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-body">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-2xl w-full">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="login" class="inline-flex items-center text-gray-600 hover:text-[#013220] transition font-body">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Login
                </a>
            </div>

            <!-- Registration Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="md:flex">
                    <!-- Left Column - Form -->
                    <div class="md:w-2/3 p-8">
                        <div class="flex items-center mb-8">
                            <div class="w-12 h-12 rounded-full bg-[#CC9933] flex items-center justify-center mr-3">
                                <img src="public/logo/logo.png" alt="Orchid Bakery Logo">
                            </div>
                            <div>
                                <h1 class="text-1xl font-bold text-gray-900 font-heading">Join Orchid Rewards</h1>
                                <p class="text-gray-600">Create your loyalty account</p>
                            </div>
                        </div>

                        <form name="register" method="POST">
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- First Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                        First Name *
                                    </label>
                                    <input 
                                        type="text" 
                                        name="first_name"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body"
                                        placeholder="John">
                                </div>

                                <!-- Last Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                        Last Name *
                                    </label>
                                    <input 
                                        type="text" 
                                        name="last_name"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body"
                                        placeholder="Doe">
                                </div>

                                <!-- Email -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                        Email Address *
                                    </label>
                                    <input 
                                        type="email" 
                                        name="email"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body"
                                        placeholder="john@example.com">
                                </div>

                                <!-- Phone -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                        Phone Number *
                                    </label>
                                    <input 
                                        type="tel" 
                                        name="phone"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body"
                                        placeholder="0800 123 4567">
                                </div>

                                <!-- Password -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                        Password *
                                    </label>
                                    <input 
                                        type="password" 
                                        name="password"
                                        id="password"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body"
                                        placeholder="••••••••">
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 font-heading">
                                        Confirm Password *
                                    </label>
                                    <input 
                                        type="password" 
                                        name="confirm_password"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#CC9933] focus:border-transparent transition font-body"
                                        placeholder="••••••••">
                                </div>

                                <!-- Terms & Conditions -->
                                <div class="md:col-span-2">
                                    <div class="flex items-start">
                                        <input 
                                            type="checkbox"
                                            name="terms"
                                            id="terms"
                                            required
                                            class="h-4 w-4 text-[#013220] focus:ring-[#013220] border-gray-300 rounded mt-1">
                                        <label for="terms" class="ml-2 block text-sm text-gray-700 font-body">
                                            I agree to the <a href="#" class="text-[#CC9933] hover:underline">Terms & Conditions</a> and <a href="#" class="text-[#CC9933] hover:underline">Privacy Policy</a> of Orchid Bakery Loyalty Program.
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-8">
                                <button type="submit" id="submitBtn"
                                        class="w-full orchid-gradient text-white py-4 px-4 rounded-lg font-semibold hover:opacity-95 transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#013220] font-heading">
                                    Create Account
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right Column - Benefits -->
                    <div class="md:w-1/3 orchid-gradient p-8 text-white">
                        <h3 class="text-xl font-bold mb-6 font-heading">Rewards Benefits</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#CC9933]/20 flex items-center justify-center mr-3">
                                    <i class="fas fa-gift text-[#CC9933]"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold font-heading">Earn Points</h4>
                                    <p class="text-sm text-gray-200 mt-1 font-body">Get points for every bread purchase</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#CC9933]/20 flex items-center justify-center mr-3">
                                    <i class="fas fa-store text-[#CC9933]"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold font-heading">Redeem at Partners</h4>
                                    <p class="text-sm text-gray-200 mt-1 font-body">Use points at various partner locations</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#CC9933]/20 flex items-center justify-center mr-3">
                                    <i class="fas fa-bolt text-[#CC9933]"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold font-heading">Exclusive Offers</h4>
                                    <p class="text-sm text-gray-200 mt-1 font-body">Access member-only discounts and promotions</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#CC9933]/20 flex items-center justify-center mr-3">
                                    <i class="fas fa-chart-line text-[#CC9933]"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold font-heading">Track History</h4>
                                    <p class="text-sm text-gray-200 mt-1 font-body">Monitor your points and redemptions</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-white/20">
                            <p class="text-sm text-gray-200 font-body">
                                Already have an account?
                                <a href="login" class="text-[#CC9933] hover:text-[#e0b450] font-medium ml-1 font-heading">
                                    Sign in here
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script>
    $(document).ready(function() {

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

     
    // Form validation
    $("form[name='register']").validate({
      rules: {
        first_name: {
          required: true,
          minlength: 2
        },
        last_name: {
          required: true,
          minlength: 2
        },
        password: {
          required: true,
          minlength: 6
        },
        phone: {
          required: true,
          minlength: 11,
          maxlength: 11
        },
        confirm_password: {
          required: true,
          equalTo: "#password"
        },
        email: {
          required: true,
          email: true
        },
        terms: {
          required: true
        }
      },
      messages: {
        first_name: {
          required: "<i class='fas fa-exclamation-circle'></i> Please enter your first name",
          minlength: "<i class='fas fa-exclamation-circle'></i> First name must be at least 2 characters"
        },
        last_name: {
          required: "<i class='fas fa-exclamation-circle'></i> Please enter your last name",
          minlength: "<i class='fas fa-exclamation-circle'></i> Last name must be at least 2 characters"
        },
        phone: {
          required: "<i class='fas fa-exclamation-circle'></i> Please enter your phone number",
          minlength: "<i class='fas fa-exclamation-circle'></i> Phone number must be 11 digits",
          maxlength: "<i class='fas fa-exclamation-circle'></i> Phone number must be 11 digits"
        },
        password: {
          required: "<i class='fas fa-exclamation-circle'></i> Please create a password",
          minlength: "<i class='fas fa-exclamation-circle'></i> Password must be at least 6 characters"
        },
        confirm_password: {
          required: "<i class='fas fa-exclamation-circle'></i> Please confirm your password",
          equalTo: "<i class='fas fa-exclamation-circle'></i> Passwords do not match"
        },
        email: {
          required: "<i class='fas fa-exclamation-circle'></i> Please enter your email address",
          email: "<i class='fas fa-exclamation-circle'></i> Please enter a valid email address"
        },
        terms: {
          required: "<i class='fas fa-exclamation-circle'></i> You must agree to the terms and conditions"
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
      submitHandler: function(form){
        // Serialize form data
        const formData = $(form).serialize();
        
        // Show confirmation dialog
        iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Confirm Registration',
                message: 'Are you sure you want to continue with your registration?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        // Hide confirmation dialog
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        
                        // Proceed with form submission
                        $.ajax({
                            type: "POST",
                            url: "register",
                            beforeSend: function(){
                                $('#submitBtn').prop("disabled", true).html('<i class="fas fa-spinner fa-spin me-2"></i> Creating Account...');
                            },
                            data: formData,
                            dataType: 'json',
                            success: function(response){
                                $('#submitBtn').prop("disabled", false).html('Create Account');
                                
                                try {
                                    // Handle different response formats
                                    if (response.status===true) {
                                        // Success
                                        showNotification(response.message, 'success');
                                        // Redirect to login after a short delay
                                        setTimeout(() => {
                                            window.location.href = 'login';
                                        }, 4000);

                                    } else {
                                        // Error
                                        showNotification(response.message, 'error');
                                    }

                                } catch (e) {
                                    console.error("Response parsing error:", e);
                                     showNotification('Invalid response from server.', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                $('#submitBtn').prop("disabled", false).html('Create Account');
                                console.error("AJAX Error:", status, error);
                                showNotification('Network error occurred. Please try again.', 'error');
                            }
                        });
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        
                        // Show cancellation message
                        showNotification('Registration was cancelled', 'info');

                    }]
                ],
                onClosing: function(instance, toast, closedBy){
                    console.info('Closing | closedBy: ' + closedBy);
                },
                onClosed: function(instance, toast, closedBy){
                    console.info('Closed | closedBy: ' + closedBy);
                }
          });
      }
    })
  });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Management - Login</title>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script> -->
    <?php include("../../library/library.php");?>
</head>

<body class="min-h-screen bg-gradient-to-br from-purple-200 to-blue-200 py-12 px-4">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-block p-2 rounded-full bg-purple-100 mb-4">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-600" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                </svg> -->
                <div class="h-20 w-20 rounded-full shadow-md flex items-center justify-center overflow-hidden">
                    <img src="../assets/Screenshot 2025-02-05 215045.svg" class="profile-image2 w-full h-full object-cover"  alt="Profile Image">
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Welcome Back</h1>
            <p class="mt-2 text-gray-600">Continue your journey of making a difference</p>
        </div>

        <!-- Form -->
        <form id="loginForm" class="bg-white rounded-xl shadow-lg p-8 space-y-6">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition-all"
                    placeholder="john@example.com">
                <span class="error-message text-red-500 text-sm hidden"></span>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition-all"
                        placeholder="••••••••">
                    <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path class="show-password hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path class="show-password hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            <path class="hide-password" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                <span class="error-message text-red-500 text-sm hidden"></span>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>
                <a href="#" class="text-sm text-purple-600 hover:text-purple-500">Forgot password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                Sign In
            </button>

            <!-- Sign Up Link -->
            <div class="text-center text-sm">
                <span class="text-gray-600">Don't have an account?</span>
                <a href="signup.php" class="text-purple-600 hover:text-purple-500 font-medium ml-1">Sign up</a>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Password Toggle
            $('#togglePassword').on('click', function() {
                const passwordInput = $('#password');
                const showIcons = $('.show-password');
                const hideIcon = $('.hide-password');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    showIcons.removeClass('hidden');
                    hideIcon.addClass('hidden');
                } else {
                    passwordInput.attr('type', 'password');
                    showIcons.addClass('hidden');
                    hideIcon.removeClass('hidden');
                }
            });

            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                // Reset error messages
                $('.error-message').addClass('hidden').text('');

                // Get form values
                const email = $('#email').val().trim();
                const password = $('#password').val();

                // Validation
                let isValid = true;

                if (!email) {
                    showError($('#email'), 'Email is required');
                    isValid = false;
                } else if (!isValidEmail(email)) {
                    showError($('#email'), 'Please enter a valid email address');
                    isValid = false;
                }

                if (!password) {
                    showError($('#password'), 'Password is required');
                    isValid = false;
                }

                if (isValid) {
                    // Here you would typically make an API call to your backend
                    console.log('Form submitted:', {
                        email,
                        password,
                        remember: $('#remember').is(':checked')
                    });

                    // For demo purposes, show success message
                    alert('Login successful!');
                }
            });

            function showError($input, message) {
                $input.next('.error-message').removeClass('hidden').text(message);
                $input.addClass('border-red-500');
            }

            function isValidEmail(email) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            }

            // Clear error styling on input
            $('input').on('input', function() {
                $(this).removeClass('border-red-500');
                $(this).next('.error-message').addClass('hidden').text('');
            });
        });
    </script>
</body>

</html>
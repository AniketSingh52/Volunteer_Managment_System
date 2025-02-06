<?php
session_start();
include("../../config/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = trim($_POST['password']);


    // Validate input
    if (empty($email) || empty($password)) {
        $error = "Email and Password are required.";
        echo "
        <script>
        alert('invalid input');
        </script>";
    } else {
        // Check if user exists in the database
        $query = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Verify password
            if ($password === $user['password']) {
                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $a = $user['user_id'];;

                echo "
                <script>
                alert('success login');
                </script>";


                // Redirect to dashboard or home page
                //header("Location: dashboard.php");
                //  exit();
            } else {
                echo "
                <script>
                alert('Invalid Password');
                </script>";
            }
        } else {
            echo "
                <script>
                alert('Invalid Email');
                </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Management - Login</title>
    <?php include("../../library/library.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="min-h-screen bg-gradient-to-br from-purple-200 to-blue-200 py-6 px-4">
    <div class="items-center w-full px-5 mt-0 mb-6 justify-items-center animate-bounce duration-150">
        <div class="p-2 rounded-l-lg border-l-4  border-green-500 bg-gray-100 -6 rounded-r-xl backdrop-blur-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <div class=" text-lg text-green-600">
                        <p>Login Successful.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="items-center w-full px-5 mt-0 mb-6 justify-items-center animate-pulse duration-150">
        <div class="p-2 rounded-l-lg border-l-4 border-red-500 bg-gray-100 rounded-r-xl backdrop-blur-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-circle-exclamation text-lg text-red-400"></i>
                </div>
                <div class="ml-3">
                    <div class="text-lg text-red-600">
                        <p>Login Failed !! Please try again.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-block p-2 rounded-full bg-purple-100 mb-4">
                <div class="h-20 w-20 rounded-full shadow-md flex items-center justify-center overflow-hidden">
                    <img src="../assets/Screenshot 2025-02-05 215045.svg" class="profile-image2 w-full h-full object-cover" alt="Profile Image">
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Welcome Back</h1>
            <p class="mt-2 text-gray-600">Continue your journey of making a difference</p>
        </div>

        <!-- Form -->
        <form id="loginForm" class="bg-white rounded-xl shadow-lg p-8 space-y-6" method="POST" action="login_in.php">
            <?php if (isset($error)): ?>
                <div class="text-red-500 text-sm"><?php echo $error; ?></div>
            <?php endif; ?>

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
                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded transition-all">
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



            // Clear error styling on input
            $('input').on('input', function() {
                $(this).removeClass('border-red-500');
                $(this).next('.error-message').addClass('hidden').text('');
            });
        });
    </script>
</body>

</html>
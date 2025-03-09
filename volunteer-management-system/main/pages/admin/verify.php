<?php
session_start();
error_reporting(0);
ini_set('display_errors', 1);
include("../../../config/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enterotp = $_POST['otp'];

    if (isset($_SESSION['OTP'])) {
        $otpp = $_SESSION['OTP'];

        if ($otpp == $enterotp) {
            unset($_SESSION['OTP']);
            $email = $_SESSION['email'];
            unset($_SESSION['email']);


            $sql = "SELECT admin_id FROM administration WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['admin_id2'] = $row['admin_id']; // Set Staff_id in session
            }

            //session_destroy();

            echo '<META HTTP-EQUIV="Refresh" Content="0.5; URL=changepass.php">';
        } else {
            echo '<script>alert("WRONG OTP !! Please enter Correct OTP");</script>';
        }
    } else {
        echo '<script>alert("Generate OTP first");</script>';
        echo '<META HTTP-EQUIV="Refresh" Content="0.5; URL=forgot.php">';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Management - Login</title>
    <?php include("../../../library/library.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="min-h-screen bg-gradient-to-br  from-green-200 to-indigo-200 py-6 px-4">


    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-block p-2 rounded-full bg-purple-100 mb-4">
                <div class="h-20 w-20 rounded-full shadow-md flex items-center justify-center overflow-hidden">
                    <img src="../../assets/Screenshot 2025-02-05 215045.svg" class="profile-image2 w-full h-full object-cover" alt="Profile Image">
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">OTP verification</h1>
            <p class="mt-2 text-gray-600">Enter the OTP sent On you registerd email</p>
        </div>

        <!-- Form -->
        <form id="loginForm" class="bg-white rounded-xl shadow-lg p-8 space-y-3" method="POST" action="verify.php">


            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Enter OTP</label>
                <input type="text" id="otp" name="otp" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition-all"
                    placeholder="*****">
                <span class="error-message text-red-500 text-sm hidden"></span>
            </div>

            <!-- Password -->




            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                Verify
            </button>

            <!-- Sign Up Link -->
            <div class="text-center text-sm">
                <span class="text-gray-600">Want to retry ?</span>
                <a href="forgot.php" class="text-purple-600 hover:text-purple-500 font-medium ml-1">Resend OTP</a>
            </div>
        </form>


    </div>

    <script>
        $(document).ready(function() {

        });
    </script>
</body>

</html>
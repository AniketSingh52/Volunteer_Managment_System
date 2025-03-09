<?php
session_start();
error_reporting(0);
ini_set('display_errors', 1);
include("../../../config/connect.php");
$admin_id2 = $_SESSION['admin_id2'];
if (!$admin_id2) {
    echo "<script>alert('Verify Your email First.'); window.location.href='forgot.php';</script>";
    exit;
} else {

    $sql = "SELECT name FROM administration WHERE admin_id = '$admin_id2'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name']; // Set Staff_id in session
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
            <h1 class="text-3xl font-bold text-gray-900">Change Password page</h1>
            <p class="mt-2 text-gray-600">Hello!! <?= $name ?> Enter the new password You want to get</p>
        </div>

        <!-- Form -->
        <form id="yourFormID" class="bg-white rounded-xl shadow-lg p-8 space-y-3">


            <!-- Email -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" id="name" name="name" readonly disabled
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition-all"
                    value="<?= $name ?>">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <div class="relative">
                    <input minlength="8" type="password" id="password" name="Npassword" required
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

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <div class="relative">
                    <input minlength="8" type="password" id="password2" name="Cpassword" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition-all"
                        placeholder="••••••••">
                    <button type="button" id="togglePassword2" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path class="show-password2 hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path class="show-password2 hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            <path class="hide-password2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                <span class="error-message text-red-500 text-sm hidden"></span>
            </div>


            <!-- Password -->




            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                Change
            </button>


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

            // Password Toggle
            $('#togglePassword2').on('click', function() {
                const passwordInput = $('#password2');
                const showIcons = $('.show-password2');
                const hideIcon = $('.hide-password2');

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



            $("#yourFormID").submit(function(e) {

                // Check if the listener has already been added to prevent duplication
                const form = document.getElementById("yourFormID");
                const userid = <?= $admin_id2 ?>;
                e.preventDefault(); // Prevent default form submission

                //var formData = $(this).serialize(); // Serialize form data

                let formData = new FormData(form);

                // Log form data to console
                console.log("Form data:");
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                let cpass = $('#password2').val()
                let Npass = $('#password').val();
                if (cpass == Npass) {

                    $.ajax({
                        url: "backend/changepass.php", // Update with your correct path to dl.php
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false, // Prevent jQuery from processing data
                        contentType: false, // Let browser set the correct content type
                        dataType: 'json', // Expect a JSON response
                        success: function(response) {
                            if (response.status === 'success') {
                                alert(response.message); // Show success message
                                window.location.href = 'admin_control_panel.php';
                                // form.reset(); // Reset the form
                                //loadContent('dl');
                            } else {
                                alert(response.message); // Show error message if any
                                // loadContent('dl');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error: " + status + " " + error);
                            alert("AJAX Error: " + status + " " + error);
                        }
                    });

                } else {
                    alert("Confirm Password and Change Password Should be Same!!");
                    // location.reload();
                }
                //   Send AJAX request
                // $.ajax({
                //     url: "Backend/add_post.php", // Update with your correct path to dl.php
                //     type: "POST",
                //     data: formData,
                //     cache: false,
                //     processData: false, // Prevent jQuery from processing data
                //     contentType: false, // Let browser set the correct content type
                //     dataType: 'json', // Expect a JSON response
                //     success: function(response) {
                //         if (response.status === 'success') {
                //             alert(response.message); // Show success message
                //             //form.submit();
                //             $('#preview-image').attr('src', "");
                //             $('#preview-image').addClass('hidden');
                //             $('#upload-prompt').removeClass('hidden');
                //             form.reset(); // Reset the form

                //             //loadContent('dl');
                //         } else {
                //             alert(response.message); // Show error message if any
                //             // loadContent('dl');
                //         }
                //     },
                //     error: function(xhr, status, error) {
                //         console.log("AJAX Error: " + status + " " + error);
                //         alert("AJAX Error: " + status + " " + error);
                //     }
                // });
            });

        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Management System - Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-xl shadow-md">
        
        <div class="text-center">
            <div class="flex items-center justify-center">
                <a href="login_in.php" title="Back To login" class="text-blue-600 hover:text-blue-800 mr-2  mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Sign up for Volunteer Management
                </h2>
            </div>
            <p class="mt-2 text-sm text-gray-600">
                Choose how you want to join our platform
            </p>
        </div>
        <div class="mt-8 space-y-6">
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button id="volunteerBtn" class="w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    As Volunteer
                </button>
                <button id="organizationBtn" class="w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    As Organisation
                </button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#volunteerBtn").click(function() {
                $("#volunteerForm").show();
                $("#organizationForm").hide();
            });

            $("#organizationBtn").click(function() {
                $("#organizationForm").show();
                $("#volunteerForm").hide();
            });

            $(".profile-input").change(function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();
                reader.onload = function(event) {
                    var img = $(e.target).closest('.relative').find('.profile-image');
                    var icon = $(e.target).closest('.relative').find('.profile-icon');
                    img.attr('src', event.target.result);
                    img.show();
                    icon.hide();
                }
                reader.readAsDataURL(file);
            });
        });
    </script>
</body>

</html>
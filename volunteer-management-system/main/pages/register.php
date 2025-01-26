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
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Sign up for Volunteer Management
            </h2>
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

            <form id="volunteerForm" class="mt-8 space-y-6 hidden" action="#" method="POST">
                <h3 class="text-xl font-bold text-center mb-4">Volunteer Sign Up</h3>
                <div class="flex justify-center mb-4">
                    <div class="relative">
                        <div class="w-24 h-24 rounded-full bg-gray-200 border-gray-500  border-2  shadow-md flex items-center justify-center overflow-hidden">
                            <i class="fas fa-user text-4xl text-gray-400 profile-icon"></i>
                            <img  class="profile-image w-full h-full object-cover" style="display: none;" alt="Profile Image">
                        </div>
                        <label for="volunteer-profile-photo" class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-2 cursor-pointer">
                            <i class="fas fa-camera text-white"></i>
                            <input type="file" id="volunteer-profile-photo" class="hidden profile-input" accept="image/*">
                        </label>
                    </div>
                </div>
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="volunteer-name" class="sr-only">Full Name</label>
                        <input id="volunteer-name" name="name" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Full Name">
                    </div>
                    <div>
                        <label for="volunteer-email" class="sr-only">Email address</label>
                        <input id="volunteer-email" name="email" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Email address">
                    </div>
                    <div>
                        <label for="volunteer-skills" class="sr-only">Skills</label>
                        <input id="volunteer-skills" name="skills" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Skills (comma separated)">
                    </div>
                </div>
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sign Up as Volunteer
                    </button>
                </div>
            </form>

            <form id="organizationForm" class="mt-8 space-y-6 hidden" action="#" method="POST">
                <h3 class="text-xl font-bold text-center mb-4">Organization Sign Up</h3>
                <div class="flex justify-center mb-4">
                    <div class="relative">
                        <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                            <i class="fas fa-building text-4xl text-gray-400 profile-icon"></i>
                            <img class="profile-image w-full h-full object-cover" style="display: none;" alt="Profile Image">
                        </div>
                        <label for="org-profile-photo" class="absolute bottom-0 right-0 bg-green-500 rounded-full p-2 cursor-pointer">
                            <i class="fas fa-camera text-white"></i>
                            <input type="file" id="org-profile-photo" class="hidden profile-input" accept="image/*">
                        </label>
                    </div>
                </div>
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="org-name" class="sr-only">Organization Name</label>
                        <input id="org-name" name="name" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Organization Name">
                    </div>
                    <div>
                        <label for="org-email" class="sr-only">Email address</label>
                        <input id="org-email" name="email" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Email address">
                    </div>
                    <div>
                        <label for="org-description" class="sr-only">Organization Description</label>
                        <textarea id="org-description" name="description" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Organization Description" rows="3"></textarea>
                    </div>
                </div>
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Sign Up as Organization
                    </button>
                </div>
            </form>
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
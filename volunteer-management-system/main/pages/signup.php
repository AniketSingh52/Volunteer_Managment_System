<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Management System - Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../js/multiselect-dropdown.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline@2.7/dist/preline.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Hide the spinner in input type="number" */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* input[type="number"] {
           / -moz-appearance: textfield;
            /* For Firefox */
        /* }*/
    </style>
</head>

<body class="bg-gradient-to-r from-teal-300 to-gray-300 min-h-screen flex justify-center items-center">


    <?php include("../../config/connect.php"); ?>
    <div class="max-w-xl w-full space-y-8 p-8 bg-white rounded-xl shadow-md mt-6 mb-6">
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

            <!-- Volunteer Registration Form -->
            <form class="bg-gradient-to-br from-blue-200 to-purple-200 p-8 rounded-lg shadow-lg w-full   mt-8 space-y-6 hidden transition-all" id="volunteerForm" action="#" method="POST">
                <h1 class="text-2xl font-bold text-center mb-8">Volunteer SignUp Form</h1>
                <div class="relative flex justify-between items-center mb-8 ">
                    <div class="absolute bottom-6 transform w-full h-1 bg-gray-300 transition-all duration-500 " id="progress-line"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center progress-step font-bold" data-title="Personal">1</div>
                        <span class="text-sm mt-2">Personal</span>
                    </div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center progress-step font-bold" data-title="Login">2</div>
                        <span class="text-sm mt-2">Login</span>
                    </div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center progress-step font-bold" data-title="Profile">3</div>
                        <span class="text-sm mt-2">Profile</span>
                    </div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center progress-step font-bold" data-title="Others">4</div>
                        <span class="text-sm mt-2">Others</span>
                    </div>
                </div>



                <!-- 1ST STEP Personal -->
                <div class="form-step active m-3">
                    <div class="grid gap-6 mb-6">
                        <div>
                            <label for="name" class="text-gray-700 text-sm mb-2 block font-semibold ">Name</label>
                            <input name="name" id="name" type="text" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter name" />
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="DOB" class="text-gray-700 text-sm mb-2 block font-semibold ">Date Of Birth</label>
                            <input name="DOB" id="DOB" type="date" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" placeholder="Enter DOB" />
                        </div>
                        <div>
                            <label for="Contact" class="text-gray-800 text-sm mb-2 block font-semibold ">Contact</label>
                            <input name="Contact" id="Contact" type="number" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white  focus:ring-blue-500 outline-blue-500 transition-all " placeholder="Enter Contact" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        </div>

                    </div>

                    <div class="grid sm:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="gender" class="text-gray-700 text-sm mb-2 block font-semibold ">Gender</label>
                            <select name="gender" id="gender" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 outline-blue-500 transition-all">
                                <option VALUE="" selected disabled>Select Your Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="Others">Others</option>

                            </select>
                        </div>
                        <div>
                            <label for="occupation" class="text-gray-800 text-sm mb-2 block font-semibold ">Occupation</label>
                            <select name="occupation" id="occupation" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 outline-blue-500 transition-all">
                                <option VALUE="" selected disabled>Select Your Occupation</option>
                                <option value="employee">Employee</option>
                                <option value="business man">Business Man</option>
                                <option value="student">Student</option>
                                <option value="others">Others</option>

                            </select>
                        </div>

                    </div>
                    <div class="grid mb-4">
                        <div>
                            <label for="address" class="text-gray-800 text-sm mb-2 block font-semibold ">Address</label>
                            <textarea name="address" id="address" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" rows="4" placeholder="Enter your address here..."> </textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-next bg-blue-500 text-white px-4 py-2 rounded font-bold">Next</button>
                </div>
                <!-- 2nd Login -->
                <div class="form-step hidden m-3">
                    <div class="grid gap-6 mb-4">
                        <div>
                            <label for="email" class="text-gray-700 text-sm mb-2 block font-semibold ">Email</label>
                            <input name="email" id="email" type="text" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter Email" />
                        </div>
                        <div>
                            <label for="password" class="text-gray-800 text-sm mb-2 block font-semibold ">Password</label>
                            <!-- Strong Password -->
                            <div class="w-full">
                                <div class="flex mb-2">
                                    <div class="flex-1 relative">
                                        <!-- Password Input Field -->
                                        <input type="password" name="password" id="hs-strong-password-with-indicator-and-hint" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter password">

                                        <!-- Toggle Button -->
                                        <button type="button" id="toggle-password" class="absolute -inset-y-4 mx-auto right-0 text-center mb-2 pr-3 flex items-center text-gray-500 hover:text-blue-600 transition-colors">
                                            <svg id="show-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <svg id="hide-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                            </svg>
                                        </button>
                                        <!-- Password Strength Indicator -->
                                        <div id="hs-strong-password" data-hs-strong-password='{
                    "target": "#hs-strong-password-with-indicator-and-hint",
                    "hints": "#hs-strong-password-hints",
                    "stripClasses": "hs-strong-password:opacity-100 hs-strong-password-accepted:bg-red-900 h-2 flex-auto rounded-full bg-blue-700 opacity-50 mx-1"
                }' class="flex mt-2 -mx-1"></div>
                                    </div>
                                </div>

                                <!-- Password Hints -->
                                <div id="hs-strong-password-hints" class="mb-3">
                                    <div>
                                        <span class="text-sm font-medium text-blue-500">Level:</span>
                                        <span data-hs-strong-password-hints-weakness-text='["Empty", "Weak", "Medium", "Strong", "Very Strong", "Super Strong"]' class="text-sm font-semibold text-blue-800"></span>
                                    </div>

                                    <h4 class="my-2 text-sm font-semibold text-gray-800">
                                        Your password must contain:
                                    </h4>

                                    <ul class="space-y-1 text-sm text-gray-500 dark:text-neutral-500">
                                        <li data-hs-strong-password-hints-rule-text="min-length" class="hs-strong-password-active:text-red-800 flex items-center gap-x-2">
                                            <span class="hidden" data-check="">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </span>
                                            <span data-uncheck="">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M18 6 6 18"></path>
                                                    <path d="m6 6 12 12"></path>
                                                </svg>
                                            </span>
                                            Minimum number of characters is 6.
                                        </li>
                                        <li data-hs-strong-password-hints-rule-text="lowercase" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                                            <span class="hidden" data-check="">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </span>
                                            <span data-uncheck="">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M18 6 6 18"></path>
                                                    <path d="m6 6 12 12"></path>
                                                </svg>
                                            </span>
                                            Should contain lowercase.
                                        </li>
                                        <li data-hs-strong-password-hints-rule-text="uppercase" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                                            <span class="hidden" data-check="">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </span>
                                            <span data-uncheck="">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M18 6 6 18"></path>
                                                    <path d="m6 6 12 12"></path>
                                                </svg>
                                            </span>
                                            Should contain uppercase.
                                        </li>
                                        <li data-hs-strong-password-hints-rule-text="numbers" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                                            <span class="hidden" data-check="">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </span>
                                            <span data-uncheck="">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M18 6 6 18"></path>
                                                    <path d="m6 6 12 12"></path>
                                                </svg>
                                            </span>
                                            Should contain numbers.
                                        </li>
                                        <li data-hs-strong-password-hints-rule-text="special-characters" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                                            <span class="hidden" data-check="">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </span>
                                            <span data-uncheck="">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M18 6 6 18"></path>
                                                    <path d="m6 6 12 12"></path>
                                                </svg>
                                            </span>
                                            Should contain special characters.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- End Strong Password -->
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" class="btn btn-prev bg-gray-500 text-white px-4 py-2 rounded font-semibold">Previous</button>
                        <button type="button" class="btn btn-next bg-blue-500 text-white px-4 py-2 rounded font-bold">Next</button>
                    </div>
                </div>
                <!--3rd Profile -->
                <div class="form-step hidden m-3">
                    <label class="text-gray-800 text-sm mb-2 block font-semibold ">Profile Photo</label>
                    <div class="grid  gap-6 mb-4">
                        <div class="flex justify-center m2">
                            <div class="relative">
                                <div class="w-44 h-44 rounded-full bg-gray-200 border-gray-500  border-2  shadow-md flex items-center justify-center overflow-hidden">
                                    <i class="fas fa-user text-4xl text-gray-400 profile-icon"></i>
                                    <img class="profile-image w-full h-full object-cover" style="display: none;" alt="Profile Image">
                                </div>
                                <label for="volunteer-profile-photo" class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-2 cursor-pointer">
                                    <i class="fas fa-camera text-white"></i>
                                    <input type="file" id="volunteer-profile-photo" class="hidden profile-input" accept="image/*">
                                </label>
                            </div>
                        </div>
                        <div>
                            <label for="username" class="text-gray-800 text-sm font-semibold mb-2 block">Username</label>
                            <input name="username" id="username" type="text" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter Username" />
                        </div>

                    </div>
                    <div class="flex justify-between">
                        <button type="button" class="btn btn-prev bg-gray-500 text-white px-4 py-2 rounded font-semibold">Previous</button>
                        <button type="button" class="btn btn-next bg-blue-500 text-white px-4 py-2 rounded font-bold">Next</button>
                    </div>
                </div>
                <!-- 4th Others -->
                <div class="form-step hidden m-3">
                    <div class="grid gap-6 mb-6 w-full">
                        <div>
                            <label for="skill" class="text-gray-700 text-sm mb-2 block font-semibold ">Your Skills:</label>
                            <!-- <input name="skill" id="name" type="text" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter name" /> -->
                            <select name="skill" multiple multiselect-search="true"
                                multiselect-select-all="true"
                                multiselect-max-items="6"
                                multiselect-hide-x="false"
                                id="skill" class="w-full ">
                                <option value="1">Communication</option>
                                <option value="2">Management</option>
                                <option value="3">Art</option>
                                <option value="4">Technical</option>
                                <option value="5">others</option>
                                <?php
                                /*$query = "SELECT D_id, Name FROM department";
                                $result = $conn->query($query);
                                 if ($result->num_rows > 0) {
                                     while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['D_id'] . '">' . $row['Name'] . '</option>';
                                     }
                                 }*/
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="causes" class="text-gray-700 text-sm mb-2 block font-semibold ">Causes for Which You Would Like To Volunteer:</label>
                            <!-- <input name="skill" id="name" type="text" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter name" /> -->
                            <select name="cause" multiple
                                multiselect-search="true"
                                multiselect-select-all="true"
                                multiselect-max-items="5"
                                multiselect-hide-x="false"
                                id="cause" class=" text-gray-800 font-extralight px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all">
                                <option value="1">Animal Rescue</option>
                                <option value="2">Cleaning Drives</option>
                                <option value="2">Awareness Campaign</option>
                                <option value="2">Envirnomental Drives</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" class="btn btn-prev bg-gray-500 text-white px-4 py-2 rounded font-semibold">Previous</button>
                        <input type="submit" value="Sign Up" class="bg-blue-700 tracking-wide text-white px-4 py-2 rounded cursor-pointer font-bold">
                    </div>
                </div>
            </form>

            <!-- Organization Registration Form -->
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

    <!-- JavaScript for Toggle Password -->
    <script>
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('hs-strong-password-with-indicator-and-hint');
        const showIcon = document.getElementById('show-icon');
        const hideIcon = document.getElementById('hide-icon');

        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            showIcon.classList.toggle('hidden', !isPassword);
            hideIcon.classList.toggle('hidden', isPassword);
        });
    </script>


    <!-- Js for Next and Previous Button -->
    <script>
        const prevBtns = document.querySelectorAll(".btn-prev");
        const nextBtns = document.querySelectorAll(".btn-next");
        const progressSteps = document.querySelectorAll(".progress-step");
        const formSteps = document.querySelectorAll(".form-step");
        const progressLine = document.getElementById("progress-line");

        let formStepsNum = 0;

        nextBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum++;
                updateFormSteps();
                updateProgressBar();
            });
        });

        prevBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum--;
                updateFormSteps();
                updateProgressBar();
            });
        });

        function updateFormSteps() {
            formSteps.forEach((formStep, index) => {
                formStep.classList.toggle("hidden", index !== formStepsNum);
                formStep.classList.toggle("active", index === formStepsNum);
            });
        }

        function updateProgressBar() {
            progressSteps.forEach((step, index) => {
                if (index <= formStepsNum) {
                    step.classList.add("bg-blue-500", "text-white");
                    step.classList.remove("bg-gray-300", "text-gray-500");
                } else {
                    step.classList.add("bg-gray-300", "text-gray-500");
                    step.classList.remove("bg-blue-500", "text-white");
                }
            });

            const activeSteps = Array.from(progressSteps).slice(0, formStepsNum + 1);
            const percentage = ((activeSteps.length - 1) / (progressSteps.length - 1)) * 100;
            progressLine.style.background = `linear-gradient(to right, #3b82f6 ${percentage}%, #d1d5db ${percentage}%)`;
        }

        updateProgressBar();
    </script>

    <!-- Js for Form Hide and show and Profile Photo Change on File select -->
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
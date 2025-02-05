<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Management System - Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--Jquery-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/multiselect-dropdown.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline@2.7/dist/preline.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include("../../library/library.php"); ?>
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
    <?php //include('../../library/library.php'); 
    ?>
</head>

<body class="min-h-screen bg-gradient-to-br from-purple-200 to-blue-200 py-12 px-4 flex justify-center items-center">


    <?php include("../../config/connect.php"); ?>
    <div class="max-w-xl w-full space-y-8 p-8 bg-white rounded-xl shadow-md mt-6 mb-6">
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

            <!-- Volunteer Registration Form -->
            <form class="bg-gradient-to-br from-blue-200 to-purple-200 p-8 rounded-lg shadow-lg w-full   mt-8 space-y-6 hidden transition-all" id="volunteerForm" action="Backend/register.php" method="POST" enctype="multipart/form-data">
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
                            <label for="name" class="text-gray-700 text-sm mb-2 block font-semibold ">Full Name</label>
                            <input required name="name" id="name" type="text" class=" bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter name" />
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="DOB" class="text-gray-700 text-sm mb-2 block font-semibold ">Date Of Birth</label>
                            <input required name="DOB" id="DOB" type="date" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" placeholder="Enter DOB" />
                        </div>
                        <div>
                            <label for="Contact" class="text-gray-800 text-sm mb-2 block font-semibold ">Contact</label>
                            <input required name="Contact" type="text"
                                class="contact-field bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white focus:ring-blue-500 outline-blue-500 transition-all"
                                placeholder="00000 00000"
                                maxlength="10"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        </div>

                    </div>

                    <div class="grid sm:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="gender" class="text-gray-700 text-sm mb-2 block font-semibold ">Gender</label>
                            <select required name="gender" id="gender" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 outline-blue-500 transition-all">
                                <option VALUE="" selected disabled>Select Your Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Others</option>

                            </select>
                        </div>
                        <div>
                            <label for="occupation" class="text-gray-800 text-sm mb-2 block font-semibold ">Occupation</label>
                            <select required name="occupation" id="occupation" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 outline-blue-500 transition-all">
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
                            <textarea required name="address" id="address" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" rows="4" placeholder="Enter your address here..."> </textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-next bg-blue-500 text-white px-4 py-2 rounded font-bold">Next</button>
                </div>
                <!-- 2nd Login -->
                <div class="form-step hidden m-3">
                    <div class="grid gap-6 mb-4">
                        <div>
                            <label for="email" class="text-gray-700 text-sm mb-2 block font-semibold ">Email</label>
                            <input onchange="email_verify(this)" required name="email" id="email" type="text" class="border-2 bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter Email" />
                            <p id="usernameWarning" class="text-red-500 text-sm mt-1 ml-2 hidden">Email already Registered.</p>
                        </div>
                        <div>
                            <label for="password" class="text-gray-800 text-sm mb-2 block font-semibold ">Password</label>
                            <!-- Strong Password -->
                            <div class="w-full">
                                <div class=" mb-2">
                                    <div class="flex-1 relative">
                                        <!-- Password Input Field -->
                                        <input required="" type="password" minlength="8" name="password" id="hs-strong-password-with-indicator-and-hint" class="password bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter password">


                                        <!-- Toggle Button -->
                                        <button type="button" id="toggle-password" class="absolute inset-y-0 mx-auto right-0 text-center flex items-center text-gray-500 hover:text-blue-600 transition-colors h-full pr-3">
                                            <svg id="show-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <svg id="hide-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div>
                                        <span id="passwordWarning" class="passwordWarning text-red-500 text-sm hidden">Password must be at least 8 characters</span>
                                        <!-- Password Strength Indicator -->
                                        <div id="hs-strong-password" data-hs-strong-password="{
                    &quot;target&quot;: &quot;#hs-strong-password-with-indicator-and-hint&quot;,
                    &quot;hints&quot;: &quot;#hs-strong-password-hints&quot;,
                    &quot;stripClasses&quot;: &quot;hs-strong-password:opacity-100 hs-strong-password-accepted:bg-red-900 h-2 flex-auto rounded-full bg-blue-700 opacity-50 mx-1&quot;
                }" class="flex mt-2 -mx-1">
                                            <div class="hs-strong-password:opacity-100 hs-strong-password-accepted:bg-red-900 h-2 flex-auto rounded-full bg-blue-700 opacity-50 mx-1"></div>
                                            <div class="hs-strong-password:opacity-100 hs-strong-password-accepted:bg-red-900 h-2 flex-auto rounded-full bg-blue-700 opacity-50 mx-1"></div>
                                            <div class="hs-strong-password:opacity-100 hs-strong-password-accepted:bg-red-900 h-2 flex-auto rounded-full bg-blue-700 opacity-50 mx-1"></div>
                                            <div class="hs-strong-password:opacity-100 hs-strong-password-accepted:bg-red-900 h-2 flex-auto rounded-full bg-blue-700 opacity-50 mx-1"></div>
                                            <div class="hs-strong-password:opacity-100 hs-strong-password-accepted:bg-red-900 h-2 flex-auto rounded-full bg-blue-700 opacity-50 mx-1"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Hints -->
                                <div id="hs-strong-password-hints" class="mb-3">
                                    <div>
                                        <span class="text-sm font-medium text-blue-500">Level:</span>
                                        <span data-hs-strong-password-hints-weakness-text="[&quot;Empty&quot;, &quot;Weak&quot;, &quot;Medium&quot;, &quot;Strong&quot;, &quot;Very Strong&quot;, &quot;Super Strong&quot;]" class="text-sm font-semibold text-blue-800">Empty</span>
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
                                            <span data-uncheck="" class="">
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
                                            <span data-uncheck="" class="">
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
                        <button type="button" id="emailnext" class="btn btn-next bg-blue-500 text-white px-4 py-2 rounded font-bold">Next</button>
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
                                    <input name="profile" required type="file" id="volunteer-profile-photo" class="hidden profile-input" accept="image/*">
                                </label>
                            </div>
                        </div>
                        <div>
                            <label for="username" class="text-gray-800 text-sm font-semibold mb-2 block">Username</label>
                            <input required onchange="username_verify(this)" name="username" id="username" type="text" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter Username" />
                            <p id="usernameWarning2" class="text-red-500 text-sm mt-1 ml-2 hidden">Username already Exists.</p>

                        </div>

                    </div>
                    <div class="flex justify-between">
                        <button type="button" class="btn btn-prev bg-gray-500 text-white px-4 py-2 rounded font-semibold">Previous</button>
                        <button type="button" id="usernamenext" class="btn btn-next bg-blue-500 text-white px-4 py-2 rounded font-bold">Next</button>
                    </div>
                </div>
                <!-- 4th Others -->
                <div class="form-step hidden m-3">
                    <div class="grid gap-6 mb-6 w-full">
                        <div>
                            <label for="skill" class="text-gray-700 text-sm mb-2 block font-semibold ">Your Skills:</label>
                            <!-- <input name="skill" id="name" type="text" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter name" /> -->
                            <select required name="skill[]" multiple multiselect-search="true"
                                multiselect-select-all="true"
                                multiselect-max-items="6"
                                multiselect-hide-x="false"
                                id="skill" class="w-full ">

                                <?php
                                $query = "SELECT * FROM skill";
                                $result = $conn->query($query);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['skill_id'] . '">' . $row['skill_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No Skill Availabe</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="causes" class="text-gray-700 text-sm mb-2 block font-semibold ">Causes for Which You Would Like To Volunteer:</label>
                            <!-- <input name="skill" id="name" type="text" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter name" /> -->
                            <select required name="cause[]" multiple
                                multiselect-search="true"
                                multiselect-select-all="true"
                                multiselect-max-items="5"
                                multiselect-hide-x="false"
                                id="cause" class=" text-gray-800 font-extralight px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all">
                                <?php
                                $query = "SELECT * FROM causes";
                                $result = $conn->query($query);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['cause_id'] . '">' . $row['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No Skill Availabe</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" class="btn btn-prev bg-gray-500 text-white px-4 py-2 rounded font-semibold">Previous</button>
                        <input type="submit" value="Sign Up" class="bg-blue-500 btn-next tracking-wide text-white px-4 py-2 rounded cursor-pointer font-bold">
                    </div>
                </div>
            </form>

            <!-- Organization Registration Form -->
            <form class="bg-gradient-to-br from-blue-200 to-purple-200 p-8 rounded-lg shadow-lg w-full   mt-8 space-y-6 hidden transition-all" id="organizationForm" action="Backend/register.php" method="POST" enctype="multipart/form-data">
                <h1 class="text-2xl font-bold text-center mb-8">Organization SignUp Form</h1>
                <div class="relative flex justify-between items-center mb-8 ">
                    <div class="absolute bottom-6 transform w-full h-1 bg-gray-300 transition-all duration-500 " id="progress-line1"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center progress-step1 font-bold" data-title="Personal">1</div>
                        <span class="text-sm mt-2">Organisation</span>
                    </div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center progress-step1 font-bold" data-title="Login">2</div>
                        <span class="text-sm mt-2">Login</span>
                    </div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center progress-step1 font-bold" data-title="Profile">3</div>
                        <span class="text-sm mt-2">Profile</span>
                    </div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center progress-step1 font-bold" data-title="Others">4</div>
                        <span class="text-sm mt-2">Others</span>
                    </div>
                </div>



                <!-- 1ST STEP Personal -->
                <div class="form-step1 active m-3">
                    <div class="grid gap-6 mb-6">
                        <div>
                            <label for="name" class="text-gray-700 text-sm mb-2 block font-semibold ">Organization Name</label>
                            <input required name="name" type="text" class=" bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter name" />
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="DOE" class="text-gray-700 text-sm mb-2 block font-semibold ">Date Of Establishment</label>
                            <input required name="DOE" type="date" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" max="<?php echo date('Y-m-d', strtotime('-2 years')); ?>" placeholder="Enter Establishment Date" />
                        </div>
                        <div>
                            <label for="Contact" class="text-gray-800 text-sm mb-2 block font-semibold ">Contact</label>
                            <input required name="Contact" type="text"
                                class="contact-field bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white focus:ring-blue-500 outline-blue-500 transition-all"
                                placeholder="00000 00000"
                                maxlength="10"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        </div>

                    </div>

                    <div class="grid mb-4">
                        <div>
                            <label for="org_type" class="text-gray-700 text-sm mb-2 block font-semibold ">Organization Type</label>
                            <select required name="org_type" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 outline-blue-500 transition-all">
                                <option VALUE="" selected disabled>Select Type of Organization</option>
                                <?php
                                $query = "SELECT * FROM `organization_type`";
                                $result = $conn->query($query);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['type_id'] . '">' . $row['type_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No Type Availabe</option>';
                                }
                                ?>

                            </select>
                        </div>


                    </div>
                    <div class="grid mb-4">
                        <div>
                            <label for="address" class="text-gray-800 text-sm mb-2 block font-semibold ">Address</label>
                            <textarea required name="address" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" rows="4" placeholder="Enter your address here..."> </textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-next1 bg-blue-500 text-white px-4 py-2 rounded font-bold">Next</button>
                </div>
                <!-- 2nd Login -->
                <div class="form-step1 hidden m-3">
                    <div class="grid gap-6 mb-4">
                        <div>
                            <label for="email" class="text-gray-700 text-sm mb-2 block font-semibold ">Email</label>
                            <input onchange="email_verify2(this)" id="email2" required name="email" type="text" class="border-2 bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter Email" />
                            <p id="usernameWarning3" class=" text-red-500 text-sm mt-1 ml-2 hidden">Email already Registered.</p>
                        </div>
                        <div>
                            <label for="password" class="text-gray-800 text-sm mb-2 block font-semibold ">Password</label>
                            <!-- Strong Password -->
                            <div class="w-full">
                                <div class=" mb-2">
                                    <div class="flex-1 relative">
                                        <!-- Password Input Field -->
                                        <input required type="password" minlength="8" name="password" id="password2" class="password bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter password">


                                        <!-- Toggle Button -->
                                        <button type="button" id="toggle-password2" class="absolute inset-y-0 mx-auto right-0 text-center flex items-center text-gray-500 hover:text-blue-600 transition-colors h-full pr-3">
                                            <svg id="show-icon2" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <svg id="hide-icon2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div>
                                        <span id="passwordWarning" class="passwordWarning text-red-500 text-sm hidden">Password must be at least 8 characters</span>

                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" class="btn btn-prev1 bg-gray-500 text-white px-4 py-2 rounded font-semibold">Previous</button>
                        <button type="button" id="emailnext2" class=" btn btn-next1 bg-blue-500 text-white px-4 py-2 rounded font-bold">Next</button>
                    </div>
                </div>
                <!--3rd Profile -->
                <div class="form-step1 hidden m-3">
                    <label class="text-gray-800 text-sm mb-2 block font-semibold ">Profile Photo</label>
                    <div class="grid  gap-6 mb-4">
                        <div class="flex justify-center m2">
                            <div class="relative">
                                <div class="w-44 h-44 rounded-full bg-gray-200 border-gray-500  border-2  shadow-md flex items-center justify-center overflow-hidden">
                                    <i class="fas fa-user text-4xl text-gray-400 profile-icon2"></i>
                                    <img class="profile-image2 w-full h-full object-cover" style="display: none;" alt="Profile Image">
                                </div>
                                <label for="org-profile-photo" class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-2 cursor-pointer">
                                    <i class="fas fa-camera text-white"></i>
                                    <input name="profile" required type="file" id="org-profile-photo" class="hidden profile-input2" accept="image/*">
                                </label>
                            </div>
                        </div>
                        <div>
                            <label for="username" class="text-gray-800 text-sm font-semibold mb-2 block">Username</label>
                            <input required onchange="username_verify2(this)" name="username" id="username" type="text" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter Username" />
                            <p id="usernameWarning4" class="text-red-500 text-sm mt-1 ml-2 hidden">Username already Exists.</p>

                        </div>

                    </div>
                    <div class="flex justify-between">
                        <button type="button" class="btn btn-prev1 bg-gray-500 text-white px-4 py-2 rounded font-semibold">Previous</button>
                        <button type="button" id="usernamenext2" class="btn btn-next1 bg-blue-500 text-white px-4 py-2 rounded font-bold">Next</button>
                    </div>
                </div>
                <!-- 4th Others -->
                <div class="form-step1 hidden m-3">
                    <div class="grid gap-6 mb-6 w-full">
                        <div>
                            <label for="causes" class="text-gray-700 text-sm mb-2 block font-semibold ">Causes for Which You Would Like To Volunteer:</label>
                            <!-- <input name="skill" id="name" type="text" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter name" /> -->
                            <select required name="cause[]" multiple
                                multiselect-search="true"
                                multiselect-select-all="true"
                                multiselect-max-items="5"
                                multiselect-hide-x="false"
                                id="cause" class=" text-gray-800 font-extralight px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all">
                                <?php
                                $query = "SELECT * FROM causes";
                                $result = $conn->query($query);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['cause_id'] . '">' . $row['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No Skill Availabe</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" class="btn btn-prev1 bg-gray-500 text-white px-4 py-2 rounded font-semibold">Previous</button>
                        <input type="submit" value="Sign Up" class="bg-blue-500 btn-next tracking-wide text-white px-4 py-2 rounded cursor-pointer font-bold">
                    </div>
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

        // New validation functions
        function validateCurrentStep() {
            const currentStep = formSteps[formStepsNum];
            const inputs = currentStep.querySelectorAll('input, select, textarea');
            let allValid = true;

            inputs.forEach(input => {
                if (input.hasAttribute('required')) {
                    if (input.type === 'file') {
                        if (!input.files.length) allValid = false;
                    } else if (!input.checkValidity()) {
                        allValid = false;
                    }
                }
            });

            return allValid;
        }

        function updateNextButtonState() {
            const currentStep = formSteps[formStepsNum];
            const nextBtn = currentStep.querySelector('.btn-next');
            if (nextBtn) {
                const isValid = validateCurrentStep();
                nextBtn.disabled = !isValid;

                // Add opacity styling
                if (isValid) {
                    nextBtn.classList.remove('opacity-50', 'bg-cyan-800');
                    nextBtn.classList.add('bg-blue-500');
                } else {
                    nextBtn.classList.add('opacity-50', 'bg-cyan-800');
                    nextBtn.classList.remove('bg-blue-500');
                }
            }
        }

        // Modified form step update function
        function updateFormSteps() {
            formSteps.forEach((formStep, index) => {
                const isActive = index === formStepsNum;
                formStep.classList.toggle("hidden", !isActive);
                formStep.classList.toggle("active", isActive);

                if (isActive) {
                    // Add event listeners to all inputs in active step
                    const inputs = formStep.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        input.addEventListener('input', updateNextButtonState);
                        input.addEventListener('change', updateNextButtonState);
                    });
                }
            });
            updateNextButtonState();
        }

        // Modified next button handler
        nextBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                if (validateCurrentStep()) {
                    formStepsNum++;
                    updateFormSteps();
                    updateProgressBar();
                }
            });
        });

        prevBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum--;
                updateFormSteps();
                updateProgressBar();
            });
        });

        // Rest of your existing progress bar code...
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

        // Initialize
        updateProgressBar();
        updateFormSteps();
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

            // Contact Number Validation
            $(".contact-field").change(function() {
                var contact = $(this).val();

                // Check if the input has exactly 10 digits and is a number
                if (!/^\d{10}$/.test(contact)) {
                    alert("Invalid Contact Number. Please enter a 10-digit number.");
                    $(this).val(""); // Clear the invalid input
                }
            });

            // Password Validation for Each Field
            $(".password").on("input", function() {
                $(this).parent().next().find(".passwordWarning").toggleClass("hidden", this.value.length >= 8);
            });

        });
    </script>
    <!-- Email and username Verification ajax -->
    <script>
        //email validation
        function email_verify(a) {
            const email2 = a.value;
            //alert(email2);
            const warning = document.getElementById("usernameWarning");
            const submitBtn = document.getElementById('emailnext');
            const pass = document.getElementById('hs-strong-password-with-indicator-and-hint');

            if (email2.length > 0) {
                //alert("habibi2");
                $.ajax({
                    url: "Backend/email_username_verify.php", // PHP file to check username
                    method: "POST",
                    data: {
                        email: email2
                    },
                    success: function(response) {
                        //console.log("Raw response:", response); // Debugging
                        response = response.trim(); // Remove extra spaces and new lines

                        if (response === "exists") {
                            warning.classList.remove("hidden");
                            submitBtn.disabled = true; // Disable submit button
                            pass.disabled = true;
                            submitBtn.classList.add("bg-gray-300", "text-gray-500");
                            submitBtn.classList.remove("bg-blue-500", "text-white");
                            //alert(1);
                        } else if (response === "available") {
                            warning.classList.add("hidden"); // Hide warning if username is available
                            submitBtn.disabled = false; // Enable submit button
                            pass.disabled = false;
                            submitBtn.classList.remove("bg-gray-300", "text-gray-500");
                            submitBtn.classList.add("bg-blue-500", "text-white");
                            // alert(2);
                        } else {
                            console.error("Unexpected response:", response);
                        }
                    },

                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " " + error);
                    }
                });
            } else {
                // alert("habibi3");
                warning.classList.add("hidden"); // Hide warning if input is empty
                submitBtn.disabled = false; // Enable submit button
                pass.disabled = false;
                submitBtn.classList.remove("bg-gray-300", "text-gray-500");
                submitBtn.classList.add("bg-blue-500", "text-white");
            }
        }



        //Username Validation

        function username_verify(a) {
            const username = a.value;
            //alert(email2);
            const warning = document.getElementById("usernameWarning2");
            const submitBtn = document.getElementById('usernamenext');
            const pass = document.getElementById('volunteer-profile-photo');

            if (username.length > 0) {
                //alert("habibi2");
                $.ajax({
                    url: "Backend/email_username_verify.php", // PHP file to check username
                    method: "POST",
                    data: {
                        username: username
                    },
                    success: function(response) {
                        //console.log("Raw response:", response); // Debugging
                        response = response.trim(); // Remove extra spaces and new lines

                        if (response === "exists") {
                            warning.classList.remove("hidden");
                            submitBtn.disabled = true; // Disable submit button
                            pass.disabled = true;
                            submitBtn.classList.add("bg-gray-300", "text-gray-500");
                            submitBtn.classList.remove("bg-blue-500", "text-white");
                            //alert(1);
                        } else if (response === "available") {
                            warning.classList.add("hidden"); // Hide warning if username is available
                            submitBtn.disabled = false; // Enable submit button
                            pass.disabled = false;
                            submitBtn.classList.remove("bg-gray-300", "text-gray-500");
                            submitBtn.classList.add("bg-blue-500", "text-white");
                            // alert(2);
                        } else {
                            console.error("Unexpected response:", response);
                        }
                    },

                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " " + error);
                    }
                });
            } else {
                // alert("habibi3");
                warning.classList.add("hidden"); // Hide warning if input is empty
                submitBtn.disabled = false; // Enable submit button
                pass.disabled = false;
                submitBtn.classList.remove("bg-gray-300", "text-gray-500");
                submitBtn.classList.add("bg-blue-500", "text-white");
            }
        }
    </script>

    <!-- Organization Ajax -->

    <!-- Js for Next and Previous Button Organization -->
    <script>
        const prevBtns1 = document.querySelectorAll(".btn-prev1");
        const nextBtns1 = document.querySelectorAll(".btn-next1");
        const progressSteps1 = document.querySelectorAll(".progress-step1");
        const formSteps1 = document.querySelectorAll(".form-step1");
        const progressLine1 = document.getElementById("progress-line1");
        let formStepsNum1 = 0;

        // New validation functions
        function validateCurrentStep2() {
            const currentStep = formSteps1[formStepsNum1];
            const inputs = currentStep.querySelectorAll('input, select, textarea');
            let allValid = true;

            inputs.forEach(input => {
                if (input.hasAttribute('required')) {
                    if (input.type === 'file') {
                        if (!input.files.length) allValid = false;
                    } else if (!input.checkValidity()) {
                        allValid = false;
                    }
                }
            });

            return allValid;
        }

        function updateNextButtonState2() {
            const currentStep = formSteps1[formStepsNum1];
            const nextBtn = currentStep.querySelector('.btn-next1');
            if (nextBtn) {
                const isValid = validateCurrentStep2();
                nextBtn.disabled = !isValid;

                // Add opacity styling
                if (isValid) {
                    nextBtn.classList.remove('opacity-50', 'bg-cyan-800');
                    nextBtn.classList.add('bg-blue-500');
                } else {
                    nextBtn.classList.add('opacity-50', 'bg-cyan-800');
                    nextBtn.classList.remove('bg-blue-500');
                }
            }
        }

        // Modified form step update function
        function updateFormSteps2() {
            formSteps1.forEach((formStep, index) => {
                const isActive = index === formStepsNum1;
                formStep.classList.toggle("hidden", !isActive);
                formStep.classList.toggle("active", isActive);

                if (isActive) {
                    // Add event listeners to all inputs in active step
                    const inputs = formStep.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        input.addEventListener('input', updateNextButtonState2);
                        input.addEventListener('change', updateNextButtonState2);
                    });
                }
            });
            updateNextButtonState2();
        }

        // Modified next button handler
        nextBtns1.forEach((btn) => {
            btn.addEventListener("click", () => {
                if (validateCurrentStep2()) {
                    formStepsNum1++;
                    updateFormSteps2();
                    updateProgressBar2();
                }
            });
        });

        prevBtns1.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum1--;
                updateFormSteps2();
                updateProgressBar2();
            });
        });

        // Rest of your existing progress bar code...
        function updateProgressBar2() {
            progressSteps1.forEach((step, index) => {
                if (index <= formStepsNum1) {
                    step.classList.add("bg-blue-500", "text-white");
                    step.classList.remove("bg-gray-300", "text-gray-500");
                } else {
                    step.classList.add("bg-gray-300", "text-gray-500");
                    step.classList.remove("bg-blue-500", "text-white");
                }
            });

            const activeSteps2 = Array.from(progressSteps1).slice(0, formStepsNum1 + 1);
            const percentage2 = ((activeSteps2.length - 1) / (progressSteps1.length - 1)) * 100;
            progressLine1.style.background = `linear-gradient(to right, #3b82f6 ${percentage2}%, #d1d5db ${percentage2}%)`;
        }

        // Initialize
        updateProgressBar2();
        updateFormSteps2();
    </script>

    <!-- Toggle password -->
    <script>
        const togglePassword2 = document.getElementById('toggle-password2');
        const passwordInput2 = document.getElementById('password2');
        const showIcon2 = document.getElementById('show-icon2');
        const hideIcon2 = document.getElementById('hide-icon2');

        togglePassword2.addEventListener('click', () => {
            const isPassword = passwordInput2.type === 'password';
            passwordInput2.type = isPassword ? 'text' : 'password';
            showIcon2.classList.toggle('hidden', !isPassword);
            hideIcon2.classList.toggle('hidden', isPassword);
        });



        //Email verification
        function email_verify2(a) {
            const email2 = a.value;
            // alert(email2);
            const warning = document.getElementById("usernameWarning3");
            const submitBtn = document.getElementById('emailnext2');
            const pass = document.getElementById('password2');

            if (email2.length > 0) {
                //alert("habibi2");
                $.ajax({
                    url: "Backend/email_username_verify.php", // PHP file to check username
                    method: "POST",
                    data: {
                        email: email2
                    },
                    success: function(response) {
                        console.log("Raw response:", response); // Debugging
                        response = response.trim(); // Remove extra spaces and new lines

                        if (response === "exists") {
                            warning.classList.remove("hidden");
                            submitBtn.disabled = true; // Disable submit button
                            pass.disabled = true;
                            submitBtn.classList.add("bg-gray-300", "text-gray-500");
                            submitBtn.classList.remove("bg-blue-500", "text-white");
                            //alert(1);
                        } else if (response === "available") {
                            warning.classList.add("hidden"); // Hide warning if username is available
                            submitBtn.disabled = false; // Enable submit button
                            pass.disabled = false;
                            submitBtn.classList.remove("bg-gray-300", "text-gray-500");
                            submitBtn.classList.add("bg-blue-500", "text-white");
                            //alert(2);
                        } else {
                            console.error("Unexpected response:", response);
                        }
                    },

                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " " + error);
                    }
                });
            } else {
                //alert("habibi3");
                warning.classList.add("hidden"); // Hide warning if input is empty
                submitBtn.disabled = false; // Enable submit button
                pass.disabled = false;
                submitBtn.classList.remove("bg-gray-300", "text-gray-500");
                submitBtn.classList.add("bg-blue-500", "text-white");
            }
        }

        //Username Validation
        function username_verify2(a) {
            const username = a.value;
            //alert(email2);
            const warning = document.getElementById("usernameWarning4");
            const submitBtn = document.getElementById('usernamenext2');
            const pass = document.getElementById('org-profile-photo');

            if (username.length > 0) {
                //alert("habibi2");
                $.ajax({
                    url: "Backend/email_username_verify.php", // PHP file to check username
                    method: "POST",
                    data: {
                        username: username
                    },
                    success: function(response) {
                        //console.log("Raw response:", response); // Debugging
                        response = response.trim(); // Remove extra spaces and new lines

                        if (response === "exists") {
                            warning.classList.remove("hidden");
                            submitBtn.disabled = true; // Disable submit button
                            pass.disabled = true;
                            submitBtn.classList.add("bg-gray-300", "text-gray-500");
                            submitBtn.classList.remove("bg-blue-500", "text-white");
                            //alert(1);
                        } else if (response === "available") {
                            warning.classList.add("hidden"); // Hide warning if username is available
                            submitBtn.disabled = false; // Enable submit button
                            pass.disabled = false;
                            submitBtn.classList.remove("bg-gray-300", "text-gray-500");
                            submitBtn.classList.add("bg-blue-500", "text-white");
                            // alert(2);
                        } else {
                            console.error("Unexpected response:", response);
                        }
                    },

                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " " + error);
                    }
                });
            } else {
                // alert("habibi3");
                warning.classList.add("hidden"); // Hide warning if input is empty
                submitBtn.disabled = false; // Enable submit button
                pass.disabled = false;
                submitBtn.classList.remove("bg-gray-300", "text-gray-500");
                submitBtn.classList.add("bg-blue-500", "text-white");
            }
        }

        //Profile Image Choosing
        $(document).ready(function() {
            $(".profile-input2").change(function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();
                reader.onload = function(event) {
                    var img = $(e.target).closest('.relative').find('.profile-image2');
                    var icon = $(e.target).closest('.relative').find('.profile-icon2');
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
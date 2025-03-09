<?php include("../../../config/connect.php"); ?>

<?php
session_start();
ob_clean(); // Cle // Return JSON response
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');
$admin_id = $_SESSION['admin_id'];

if (!$admin_id) {
    echo "<script>alert('User not logged in.'); window.location.href='login_in2.php';</script>";
    exit;
} else {
    //echo "<script>alert('$user_id');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <?php include('../../../library/library.php'); ?>
    <!-- For Latest Event Images can be deleted coursel-->
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet" />

    <!-- For svgs sidebar-->
    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet" />

    <!-- For svgs sidebar-->
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Post And Comment Using Alpine.js Don't Touch -->
    <script
        defer
        src="https://unpkg.com/alpinejs@3.1.1/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Volunteer Management</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap");

        .transition-transform {
            transition-property: transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .multiselect-dropdown {
            height: 60px;
        }

        .placeholder {
            margin-left: 10px;
            text-align: center;
            justify-content: center;
            margin-top: 12px;
            color: #afafaf !important;
            font-weight: 600;

        }

        @media (min-width: 768px) {
            .main.active {
                margin-left: 0px;
                width: 100%;
            }

            .footer.active {
                margin-left: 0px;
                width: 100%;
            }
        }

        @media (min-width: 768px) {
            .md\:ml-64 {
                margin-left: 16rem;
            }

            .md\:hidden {
                display: none;
            }

            .md\:w-\[calc\(100\%-256px\)\] {
                width: calc(100% - 256px);
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .lg\:col-span-2 {
                grid-column: span 2 / span 2;
            }

            .lg\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .lg\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
    </style>

</head>

<body class="text-gray-800 font-inter">

    <!-- Sidebar -->
    <?php include('layouts/sidebar2.php'); ?>

    <!-- Main -->
    <main
        class="w-full md:w-[calc(100%-288px)] md:ml-72 bg-gray-200 min-h-screen transition-all main">

        <!-- Navbar -->
        <?php include('layouts/navbar2.php'); ?>

        <!-- Contents -->
        <div class="p-4 dynamiccontents" id="dynamiccontents">

            <!-- Hero Section -->
            <div class="relative isolate overflow-hidden bg-gradient-to-b from-indigo-100/20">
                <div class="mx-auto max-w-7xl px-6 pt-2 pb-6 sm:pb-10 lg:flex lg:px-8 ">
                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl lg:flex-shrink-0 lg:pt-8">
                        <h1 class="mt-10 text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                            Add Admin
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600">
                            Add Members to manage the website more easily ans effectively .
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="mx-auto max-w-7xl px-6 pb-24 lg:px-8">
                <form id="yourFormID" method="POST" enctype="multipart/form-data" class="space-y-12">
                    <!-- Event Poster Section -->
                    <div class="bg-white rounded-2xl shadow-sm p-8 space-y-6">
                        <div class="border-b border-gray-200 pb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Profile Image</h2>
                            <p class="mt-1 text-sm text-gray-500">The image that will be displayed besides his profile.</p>
                        </div>

                        <div class="flex justify-center">
                            <div class="relative group">
                                <label for="volunteer-profile-photo" class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-2 cursor-pointer">
                                    <i class="fas fa-camera text-white"></i>
                                </label>
                                <div class="h-[400px] w-[600px] bg-gray-100 border-2 border-dashed border-gray-300 rounded-2xl overflow-hidden group-hover:border-indigo-500 transition-colors duration-300">
                                    <img id="preview-image" class="profile-image w-full h-full object-cover hidden">
                                    <div class="flex flex-col items-center justify-center h-full" id="upload-prompt">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-12h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 mt-4">
                                            <label for="volunteer-profile-photo" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                                <span>Upload a file</span>
                                                <input name="poster" required type="file" id="volunteer-profile-photo" class="sr-only profile-input" accept="image/*">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="bg-white rounded-2xl shadow-sm p-8 space-y-8">
                        <div class="border-b border-gray-200 pb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Basic Information</h2>
                            <p class="mt-1 text-sm text-gray-500">Details about The admin.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                            <!-- Organizer -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input required
                                    type="text"
                                    name="name"
                                    class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div>

                            <!-- Creation Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date of Registration</label>
                                <input
                                    name="date_of_registration"
                                    type="date"
                                    value="<?php echo date('Y-m-d'); ?>"
                                    readonly
                                    disabled
                                    class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div>

                        </div>
                    </div>


                    <!-- Description -->
                    <div class="bg-white rounded-2xl shadow-sm p-8 space-y-8">
                        <div class="border-b border-gray-200 pb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Admin Privileges</h2>
                            <p class="mt-1 text-sm text-gray-500">Admin Login and access Control setting.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                            <!-- Organizer -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input required
                                    placeholder="xyz@gmail.com"
                                    type="email"
                                    name="email"
                                    class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div>

                            <!-- Creation Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" required
                                        class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm"
                                        placeholder="**********">
                                    <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path class="show-password hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path class="show-password hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            <path class="hide-password" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-1">
                            <!-- Organizer -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Role</label>
                                <select required name="role" class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                                    <option value="" disabled selected>Select the role</option>
                                    <option value="super">Super Admin</option>
                                    <option value="Manager">Event Manager</option>
                                </select>

                            </div>


                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center">
                        <button
                            type="submit"
                            name="submit"
                            class="inline-flex justify-center rounded-lg bg-indigo-600 px-12 py-4 text-lg font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all duration-200 transform hover:-translate-y-0.5">
                           Add 
                        </button>
                    </div>
                </form>
            </div>
        </div>

        </div>
        <!-- End Content -->





    </main>




    <!-- Footer -->
    <?php include('layouts/footer2.php'); ?>



    <script>
        $(document).ready(function() {

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

            $("#yourFormID").submit(function(e) {

                // Check if the listener has already been added to prevent duplication
                const form = document.getElementById("yourFormID");
                e.preventDefault(); // Prevent default form submission

                //var formData = $(this).serialize(); // Serialize form data

                let formData = new FormData(form);

                // Log form data to console
                console.log("Form data:");
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                //   Send AJAX request
                $.ajax({
                    url: "Backend/add_admin.php", // Update with your correct path to dl.php
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false, // Prevent jQuery from processing data
                    contentType: false, // Let browser set the correct content type
                    dataType: 'json', // Expect a JSON response
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message); // Show success message
                            //form.submit();
                            $('#preview-image').attr('src', "");
                            $('#preview-image').addClass('hidden');
                            $('#upload-prompt').removeClass('hidden');
                            form.reset(); // Reset the form

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
            });
        });
    </script>

    <script src="../../../js/multiselect-dropdown.js">
    </script>






    <!-- Js for Form Hide and show and Profile Photo Change on File select -->
    <script>
        $(document).ready(function() {
            // Image preview
            $('#volunteer-profile-photo').change(function(e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-image').attr('src', e.target.result).removeClass('hidden');
                        $('#upload-prompt').addClass('hidden');
                    }
                    reader.readAsDataURL(e.target.files[0]);
                }
            });


            // $(".profile-input").change(function(e) {
            //     var file = e.target.files[0];
            //     var reader = new FileReader();
            //     reader.onload = function(event) {
            //         var img = $(e.target).closest('.relative').find('.profile-image');
            //         var icon = $(e.target).closest('.relative').find('.profile-icon');
            //         img.attr('src', event.target.result);
            //         img.show();
            //         icon.hide();
            //     }
            //     reader.readAsDataURL(file);
            // });


        });
    </script>
    <script src="https://unpkg.com/@popperjs/core@2">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../../js/main.js"></script>

    <!-- Home Page NavBar Sidebar Don't Touch -->
    <script>
        // start: Sidebar
        const sidebarToggle = document.querySelector(".sidebar-toggle");
        const sidebarOverlay = document.querySelector(".sidebar-overlay");
        const sidebarMenu = document.querySelector(".sidebar-menu");
        const footer = document.querySelector(".footer");
        const main = document.querySelector(".main");

        sidebarToggle.addEventListener("click", function(e) {
            e.preventDefault();
            main.classList.toggle("active");
            footer.classList.toggle("active");
            sidebarOverlay.classList.toggle("hidden");
            sidebarMenu.classList.toggle("-translate-x-full");
        });
        sidebarOverlay.addEventListener("click", function(e) {
            e.preventDefault();
            main.classList.add("active");
            footer.classList.add("active");
            sidebarOverlay.classList.add("hidden");
            sidebarMenu.classList.add("-translate-x-full");
        });
        document
            .querySelectorAll(".sidebar-dropdown-toggle")
            .forEach(function(item) {
                item.addEventListener("click", function(e) {
                    e.preventDefault();
                    const parent = item.closest(".group");
                    if (parent.classList.contains("selected")) {
                        parent.classList.remove("selected");
                    } else {
                        document
                            .querySelectorAll(".sidebar-dropdown-toggle")
                            .forEach(function(i) {
                                i.closest(".group").classList.remove("selected");
                            });
                        parent.classList.add("selected");
                    }
                });
            });
        // end: Sidebar

        // start: Popper
        const popperInstance = {};
        document.querySelectorAll(".dropdown").forEach(function(item, index) {
            const popperId = "popper-" + index;
            const toggle = item.querySelector(".dropdown-toggle");
            const menu = item.querySelector(".dropdown-menu");
            menu.dataset.popperId = popperId;
            popperInstance[popperId] = Popper.createPopper(toggle, menu, {
                modifiers: [{
                        name: "offset",
                        options: {
                            offset: [0, 8],
                        },
                    },
                    {
                        name: "preventOverflow",
                        options: {
                            padding: 24,
                        },
                    },
                ],
                placement: "bottom-end",
            });
        });
        document.addEventListener("click", function(e) {
            const toggle = e.target.closest(".dropdown-toggle");
            const menu = e.target.closest(".dropdown-menu");
            if (toggle) {
                const menuEl = toggle
                    .closest(".dropdown")
                    .querySelector(".dropdown-menu");
                const popperId = menuEl.dataset.popperId;
                if (menuEl.classList.contains("hidden")) {
                    hideDropdown();
                    menuEl.classList.remove("hidden");
                    showPopper(popperId);
                } else {
                    menuEl.classList.add("hidden");
                    hidePopper(popperId);
                }
            } else if (!menu) {
                hideDropdown();
            }
        });

        function hideDropdown() {
            document.querySelectorAll(".dropdown-menu").forEach(function(item) {
                item.classList.add("hidden");
            });
        }

        function showPopper(popperId) {
            popperInstance[popperId].setOptions(function(options) {
                return {
                    ...options,
                    modifiers: [
                        ...options.modifiers,
                        {
                            name: "eventListeners",
                            enabled: true
                        },
                    ],
                };
            });
            popperInstance[popperId].update();
        }

        function hidePopper(popperId) {
            popperInstance[popperId].setOptions(function(options) {
                return {
                    ...options,
                    modifiers: [
                        ...options.modifiers,
                        {
                            name: "eventListeners",
                            enabled: false
                        },
                    ],
                };
            });
        }
        // end: Popper

        // start: Tab
        document.querySelectorAll("[data-tab]").forEach(function(item) {
            item.addEventListener("click", function(e) {
                e.preventDefault();
                const tab = item.dataset.tab;
                const page = item.dataset.tabPage;
                const target = document.querySelector(
                    '[data-tab-for="' + tab + '"][data-page="' + page + '"]'
                );
                document
                    .querySelectorAll('[data-tab="' + tab + '"]')
                    .forEach(function(i) {
                        i.classList.remove("active");
                    });
                document
                    .querySelectorAll('[data-tab-for="' + tab + '"]')
                    .forEach(function(i) {
                        i.classList.add("hidden");
                    });
                item.classList.add("active");
                target.classList.remove("hidden");
            });
        });
    </script>
</body>

</html>
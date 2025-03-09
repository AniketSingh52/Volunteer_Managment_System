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

    <title>Volunteer Management</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap");

        .transition-transform {
            transition-property: transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
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
            <div class="max-w-7xl mx-auto px-2 py-0">

                <!-- Sidebar -->

                <!-- Main Content -->
                <div class="flex flex-col flex-1 min-w-full overflow-hidden">
                    <!-- Main Content Area -->
                    <main class="relative flex-1 overflow-y-auto focus:outline-none">
                        <div class="py-6">
                            <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                                <h1 class="text-3xl font-bold text-gray-900">Admin Management</h1>
                            </div>
                            <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">

                                <!-- Volunteer & organization Count -->

                                <!-- User Management Section -->
                                <div class="mt-8 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <h2 class="text-lg font-semibold text-gray-900">List Of Admins</h2>
                                            <div class="flex items-center space-x-2">
                                                <!-- <div class="relative">
                                                    <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                        <option>All Users</option>
                                                        <option>Only Volunteer</option>
                                                        <option>Only Organisation</option>
                                                    </select>
                                                </div> -->

                                            </div>
                                        </div>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        User
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Role
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Status
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Joined
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-center  text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Actions
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">

                                                <?php
                                                $sql = "SELECT * from administration where admin_id != '$admin_id'";
                                                $result2 = $conn->query($sql);

                                                // Check if there are events
                                                if ($result2->num_rows > 0) {
                                                    $rows = $result2->fetch_all(MYSQLI_ASSOC);

                                                    foreach ($rows as $row) {
                                                        
                                                        $id = $row['admin_id'];
                                                        $name2 = $row['name'];
                                                        $email = $row['email'];

                                                        $admin_image = $row['profile_picture'];
                                                        $admin_type = $row['role'] == "super" ? "Super Admin" : "Event Manager";
                                                        // echo $row['activation_status'];
                                                        $activation_status = $row['status'] == "active" ? "Active" : "Deactive";
                                                        // echo $activation_status;
                                                        $activation_style = ($row['status'] == "active") ? "bg-green-100 text-green-800 hover:bg-green-800/90 font-medium hover:text-white" : "bg-red-100 text-red-800 hover:bg-red-800/90 font-medium hover:text-white";
                                                        $admin_name_style = ($row['role'] == 'super') ? " bg-fuchsia-100 hover:bg-fuchsia-800/90 text-fuchsia-800 hover:text-white" : "bg-indigo-100 hover:bg-indigo-800/90 font-medium text-indigo-800 hover:text-white";

                                                        $admin_image = preg_replace('/^\.\.\//', '', $admin_image);

                                                        $dor = date('M j, y', strtotime($row['date_of_registration']));




                                                ?>
                                                        <tr>
                                                            <td class=" py-4  whitespace-nowrap px-10">
                                                                <div class="flex items-center">
                                                                    <div class="flex-shrink-0 h-10 w-10">
                                                                        <img class="h-10 w-10 rounded-full" src="<?= $admin_image ?>" alt="<?= $name2 ?>">
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            <?= $name2 ?>
                                                                        </div>
                                                                        <div class="text-sm text-gray-500 font-mono">
                                                                            @<?= $email ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4  text-center whitespace-nowrap">
                                                                <span class="px-2 py-1 inline-flex text-xs  leading-5 font-semibold rounded-full <?= $admin_name_style ?>">
                                                                    <?= $admin_type ?>
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                                <span class="px-4  py-2 inline-flex text-sm leading-5 font-semibold rounded-full <?= $activation_style ?>">
                                                                    <?= $activation_status ?>
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                                <?= $dor ?>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                                <div class="flex items-center justify-center space-x-2 user_action">

                                                                    <button data-action="<?= ($activation_status == "Active") ? "deactive" : "active" ?>" data-adminid="<?= $id ?>" class=" px-4 py-2 text-center rounded-lg w-full hover:scale-105 transition-all duration-300 hover:ring-2 hover:ring-red-800 text-white <?= ($activation_status == "Active") ? "bg-red-600" : "bg-green-600" ?>"><?= ($activation_status == "Active") ? "Deactivate" : "Active" ?></button>
                                                                    <!-- <button data-action="unsuspend" data-userid="<?= $id ?>" class="bg-red-600 px-4 py-2 rounded-lg w-1/2 hover:text-red-900 text-white">Deactivate</button> -->
                                                                </div>
                                                            </td>
                                                        </tr>

                                                <?php

                                                    }
                                                } else {
                                                    echo "<H1 class='text-3xl text-center p-10 m-10'>No admin Avaialbe</H1>";
                                                }
                                                ?>


                                            </tbody>
                                        </table>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </main>
                </div>


            </div>
        </div>
        <!-- End Content -->

    </main>



    <script>
        $(document).ready(function() {


            $(document).on('click', '.user_action button', function() {
                let action = $(this).data("action");
                let admin = $(this).data("adminid");
                let button = $(this);

                // alert(action);
                // alert(admin);
              
                    $.ajax({
                        url: "backend/manage_admin.php", // Backend PHP script
                        method: "POST",
                        data: {
                            action: action,
                            admin_id2: admin
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                // alert(response.message); // Show success message
                                // location.reload();
                                if (action == "deactive") {
                                    button.addClass('bg-green-600').removeClass('bg-red-600');
                                    button.html("Active");
                                    button.data("action", "active")
                                } else {
                                    button.removeClass('bg-green-600').addClass('bg-red-600');
                                    button.html("Deactive");
                                    button.data("action", "deactive")
                                }

                            } else {
                                alert(response.message);
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


    <!-- Footer -->
    <?php include('layouts/footer2.php'); ?>

    <!-- Home Page NavBar Sidebar Don't Touch -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
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
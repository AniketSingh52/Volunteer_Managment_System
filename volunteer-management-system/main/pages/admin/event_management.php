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



$query = "SELECT status, COUNT(*) AS event_count FROM events GROUP BY status";
$result = $conn->query($query);
// Initialize variables
$ongoing = 0;
$scheduled = 0;
$completed = 0;
$cancelled = 0;

// Fetch the results and store in variables
while ($row = $result->fetch_assoc()) {
    switch ($row['status']) {
        case 'Ongoing':
            $ongoing = $row['event_count'];
            break;
        case 'Scheduled':
            $scheduled = $row['event_count'];
            break;
        case 'Completed':
            $completed = $row['event_count'];
            break;
        case 'Cancelled':
            $cancelled = $row['event_count'];
            break;
    }
}


$sql2 = "SELECT * FROM `events` WHERE status='Ongoing' ORDER BY `date_of_creation` DESC";

$result2 = $conn->query($sql2);



// if ($result->num_rows > 0) {

//     $rows = $result->fetch_all(MYSQLI_ASSOC);
// }

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

        .read-more-link,
        .read-less-link {
            color: #05d910;
            text-decoration: none;
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
            <div class="max-w-7xl mx-auto pt-5 pb-12 px-6">

                <!-- Header -->
                <div class="flex justify-between items-center mb-8 mt-3">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900">Event Management</h1>
                        <p class="mt-1 text-gray-500">Manage and monitor Events</p>
                    </div>

                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-2 mb-10">
                    <!-- User Status Chart -->
                    <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-lg font-semibold text-gray-900">Event Traffic</h2>
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-200 rounded-full mr-1"></div>
                                    <span class="text-xs text-gray-600">Event Creation</span>
                                </div>
                                <!-- <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-500 rounded-full mr-1"></div>
                                    <span class="text-xs text-gray-600">Inactive</span>
                                </div> -->
                            </div>
                        </div>
                        <div class="relative h-64">
                            <canvas id="eventTrafficChart"></canvas>
                        </div>
                    </div>

                    <!-- Event Types Chart -->
                    <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-gray-900">Event Types</h2>
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-1"></div>
                                    <span class="text-xs text-gray-600">Ongoing</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-1"></div>
                                    <span class="text-xs text-gray-600">Scheduled</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-purple-500 rounded-full mr-1"></div>
                                    <span class="text-xs text-gray-600">Completed</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-500 rounded-full mr-1"></div>
                                    <span class="text-xs text-gray-600">Cancelled</span>
                                </div>
                            </div>
                        </div>
                        <div class="relative h-64">
                            <canvas id="eventTypesChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="bg-white rounded-xl shadow-sm mb-8">
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px">
                            <button data-status="Ongoing" class="w-1/3 py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span>Ongoing Events</span>
                                <span class="ml-2 bg-blue-100 text-blue-600 py-0.5 px-2.5 rounded-full text-xs font-medium"><?= $ongoing ?></span>
                            </button>
                            <button data-status="Scheduled" class="w-1/3 py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Scheduled Events</span>
                                <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs font-medium"><?= $scheduled ?></span>
                            </button>
                            <button data-status="Completed" class="w-1/3 py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center justify-center space-x-2">
                                <i class='bx bx-check-shield text-xl'></i>
                                <span>Completed Events</span>
                                <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs font-medium"><?= $completed ?></span>
                            </button>
                            <button data-status="Cancelled" class="w-1/3 py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center justify-center space-x-2">
                                <i class='bx bx-calendar-x text-xl'></i>
                                <span>Cancelled Events</span>
                                <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs font-medium"><?= $cancelled ?></span>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Event List -->
                <div class="space-y-6 event_list" id="events-list">
                    <!-- Event Card 1 -->

                </div>



            </div>
        </div>
        <!-- End Content -->

    </main>

    <script src="../../../js/moreless.js">
    </script>

    <script>
        $(document).ready(function() {


            $(document).on('click', '.action_list button', function() {
                let action = $(this).data("action");
                let event = $(this).data("userid");

                // alert(action);
                // alert(event);
                if (action != "IGNORE") {
                    $.ajax({
                        url: "backend/event_management.php", // Backend PHP script
                        method: "POST",
                        data: {
                            action: action,
                            event_id: event
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                // alert(response.message); // Show success message
                                location.reload();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error: " + status + " " + error);
                            alert("AJAX Error: " + status + " " + error);
                        }
                    });

                }
            });

            function initialize() {
                let all = "Ongoing";
                $.ajax({
                    url: "backend/event_populate.php",
                    method: "POST",
                    data: {
                        type: all
                    },
                    success: function(response) {
                        $("#events-list").html(response); // Insert new content

                        // Wait until DOM updates before applying moreLess
                        $("#events-list").promise().done(function() {
                            if ($(".example").length > 0) { // Ensure elements exist
                                $(".example").moreLess({
                                    moreLabel: "... Read more",
                                    lessLabel: "... Read less",
                                    moreClass: "read-more-link",
                                    lessClass: "read-less-link",
                                    wordsCount: 20,
                                });
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " " + error);
                    }
                });
            }

            initialize();

            $(document).on('click', 'nav button', function() {
                // Remove active classes from all tabs
                $('nav button').removeClass('border-blue-500 text-blue-600').addClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');

                // Add active classes to clicked tab
                $(this).addClass('border-blue-500 text-blue-600').removeClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');
                let Type = $(this).data("status");
                // alert(Type);

                $.ajax({
                    url: "backend/event_populate.php", // Backend PHP script
                    method: "POST",
                    data: {
                        type: Type
                    },
                    success: function(response) {
                        $("#events-list").html(response); // Show results
                        $("#events-list").promise().done(function() {
                            $(".example").each(function() {
                                $(this).removeClass("moreLess-initialized"); // Remove previous state
                            });

                            if ($(".example").length > 0) {
                                $(".example").moreLess({
                                    moreLabel: "... Read more",
                                    lessLabel: "... Read less",
                                    moreClass: "read-more-link",
                                    lessClass: "read-less-link",
                                    wordsCount: 20,
                                });
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX Error: " + status + " " + error);
                        alert("AJAX Error: " + status + " " + error);
                    }
                });
            });

            // Event Types Chart
            const eventTypesCtx = document.getElementById('eventTypesChart').getContext('2d');
            const eventTypesChart = new Chart(eventTypesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Ongoing', 'Scheduled', 'Completed', 'Cancelled'],
                    datasets: [{
                        data: [<?= $ongoing ?>, <?= $scheduled ?>, <?= $completed ?>, <?= $cancelled ?>],
                        backgroundColor: [
                            'rgb(34, 197, 94)',
                            'rgb(59, 130, 246)',
                            'rgb(168, 85, 247)',
                            'rgb(239, 68, 68)'
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        //   legend: {
                        //     display: false
                        //   },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.formattedValue || '';
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((context.raw / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });


            fetch('backend/get_chart_data.php')
                .then(response => response.json())
                .then(data => {
                    // Extract labels (months) and data
                    const labels = data.map(item => item.month);
                    // const users = data.map(item => parseInt(item.user_count));
                    const events = data.map(item => parseInt(item.event_count));
                    // const posts = data.map(item => parseInt(item.post_count));

                    // Update Chart.js
                    new Chart(document.getElementById('eventTrafficChart'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Monthly Events Creation',
                                data: events,
                                borderWidth: 1,
                                fill: true,
                                pointBackgroundColor: 'rgb(16, 185, 129)',
                                borderColor: 'rgb(16, 185, 129)',
                                backgroundColor: 'rgb(16 185 129 / .15)',
                                tension: 0.2
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching chart data:', error));




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
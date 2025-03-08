<?php include("../../../config/connect.php"); ?>

<?php
session_start();
ob_clean(); // Cle // Return JSON response
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');
$user_id = $_SESSION['user_id'];

if (!$user_id) {
    echo "<script>alert('User not logged in.'); window.location.href='../login_in.php';</script>";
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
            <div class="max-w-7xl mx-auto px-2 pt-5 pb-12">

                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900">Event Management</h1>

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
                <div class="space-y-6 event_list">
                    <!-- Event Card 1 -->
                    <?php
                    if ($result2->num_rows > 0) {

                        $rows = $result2->fetch_all(MYSQLI_ASSOC);
                        foreach ($rows as $row) {

                            $event_id = $row['event_id'];
                            $event_name = $row['event_name'];
                            $from_date = date('jS M y', strtotime($row['from_date']));
                            $to_date = date('jS M y', strtotime($row['to_date']));
                            $from_time = $row['from_time'];
                            $to_time = $row['to_time'];

                            $from_time = date("h:i A", strtotime($from_time));
                            $to_time = date("h:i A", strtotime($to_time));
                            $volunteer_needed = $row['volunteers_needed'];
                            $max_application = $row['maximum_application'];

                            $event_image = $row['poster'];
                            // $event_image = preg_replace('/^\.\.\//', '', $event_image);
                            $date_of_creation = $row['date_of_creation'];
                            $status = $row['status'];

                            //'Ongoing','Scheduled','Completed','Cancelled'
                            if ($status == "Ongoing") {
                                $status_style = " bg-green-500 hover:bg-green-800/90  duration-300 transition-all ";
                            } elseif ($status == "Scheduled") {
                                $status_style = " bg-sky-500 hover:bg-sky-800/90  duration-300 transition-all ";
                            } elseif ($status == "Completed") {
                                $status_style = " bg-indigo-500 hover:bg-indigo-800/90  duration-300 transition-all ";
                            } else {
                                $status_style = " bg-red-500 hover:bg-red-800/90  duration-300 transition-all ";
                            }

                            $creation_date = new DateTime($date_of_creation);
                            $today = new DateTime();
                            $diff = $today->diff($creation_date);

                            if (
                                $diff->days == 0
                            ) {
                                $days_ago = "Today";
                            } else {
                                $days_ago = ($diff->days <= 10) ? "{$diff->days} days ago" : date('jS M y', strtotime($date_of_creation));
                            }


                            $query = "SELECT 
                                event_id, 
                                COUNT(*) AS total_applications, 
                                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending_count, 
                                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) AS rejected_count, 
                                SUM(CASE WHEN status = 'accepted' THEN 1 ELSE 0 END) AS accepted_count
                            FROM events_application
                            WHERE event_id = ?  -- Replace '?' with the specific event_id you want
                            GROUP BY event_id;
                            ";

                            // Prepare and execute the statement
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("i", $event_id); // "i" for integer
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Initialize variables
                            $pending_count = 0;
                            $rejected_count = 0;
                            $accepted_count = 0;
                            $total_applications = 0;


                            // Fetch the results and store in variables
                            if ($row = $result->fetch_assoc()) {
                                $pending_count = $row['pending_count'];
                                $rejected_count = $row['rejected_count'];
                                $accepted_count = $row['accepted_count'];
                                $total_applications = $row['total_applications'];
                            }



                    ?>

                            <!-- Event Card 1 -->
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                                <div class="md:flex">
                                    <div class="md:w-1/3 relative group">
                                        <img
                                            src="<?= $event_image ?>"
                                            alt="<?= $event_name ?>"
                                            class="h-48 w-full object-cover md:h-full transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute top-4 left-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $status_style ?> text-white shadow-lg">
                                                <?= $status ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-6 md:w-2/3">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-900"><?= $event_name ?>
                                                    <span class=" ml-3 text-gray-700 border-2 text-sm border-gray-200 shadow-sm rounded-xl px-2 py-1 bg-gray-200"><?= $days_ago ?></span>

                                                </h3>
                                                <div class="mt-2 flex flex-col items-start text-gray-500 text-sm space-y-2">
                                                    <span class="mt-2 flex items-center font-normal text-base text-gray-600">
                                                        <svg class="h-5 w-5 mr-2 bg-sky-100 rounded-lg text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <?= $from_date ?> • <?= $to_date ?>
                                                    </span>
                                                    <span class="mt-2 flex items-center font-normal text-base text-gray-600">
                                                        <svg class="h-5 w-5 mr-2 bg-violet-100 rounded-lg text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <?= $from_time ?> - <?= $to_time ?>
                                                    </span>
                                                    <div class="mt-2 flex items-center font-semibold text-base text-gray-600">
                                                        <svg
                                                            class="h-5 w-5 mr-2 bg-green-100 rounded-lg text-green-600"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                                                        </svg>
                                                        Volunteer Needed:<?= $accepted_count ?><?= $volunteer_needed ?>
                                                    </div>
                                                    <div class="mt-2 flex items-center font-bold text-base text-gray-600">
                                                        <svg
                                                            class="h-5 w-5 mr-2 bg-green-100 rounded-lg text-fuchsia-600"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                                                        </svg>
                                                        Max Application:<?= $total_applications ?>/<?= $max_application ?>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="flex space-x-2">
                                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white bg-red-500">
                                                   Active
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="grid grid-cols-3 gap-4">
                                                <div class="bg-gray-100 shadow-md p-4 rounded-lg text-center ">
                                                    <p class="text-sm font-medium text-gray-500">Total Applications</p>
                                                    <p class="mt-2 text-xl font-bold text-gray-900"> <?= $total_applications ?></p>
                                                </div>
                                                <div class="bg-gray-100 shadow-md p-4 rounded-lg text-center">
                                                    <p class="text-sm font-medium text-gray-500">Approved</p>
                                                    <p class="mt-2 text-xl font-bold text-green-600"><?= $accepted_count ?></p>
                                                </div>
                                                <div class="bg-gray-100 shadow-md p-4 rounded-lg text-center">
                                                    <p class="text-sm font-medium text-gray-500">Pending</p>
                                                    <p class="mt-2 text-xl font-bold text-amber-500"><?= $pending_count ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-6 flex justify-end space-x-4">
                                            <button onclick="window.location.href='event_detail.php?id=<?= base64_encode($event_id) ?>'"
                                                class="px-4 hover:scale-105 transition-all duration-300 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                View Details
                                            </button>
                                            <button onclick="window.location.href='Event_Applications.php?id=<?= base64_encode($event_id) ?>'"
                                                class="px-4 py-2 hover:scale-105 transition-all duration-300 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                View Applications
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    <?php
                        }
                    } else {

                        echo "
                            <h1 class=' text-2xl font-semibold'>No Events Created</h1>
                            ";
                    }
                    ?>
                </div>



            </div>
        </div>
        <!-- End Content -->

    </main>



    <script>
        $(document).ready(function() {


            $(document).on('click', '.user_action button', function() {
                let action = $(this).data("action");
                let user = $(this).data("userid");

                alert(action);
                alert(user);
                if (action != "IGNORE") {


                    $.ajax({
                        url: "backend/user_management.php", // Backend PHP script
                        method: "POST",
                        data: {
                            action: action,
                            user_id: user
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

            // User Status Chart
            // const userStatusCtx = document.getElementById('userStatusChart').getContext('2d');
            // const userStatusChart = new Chart(userStatusCtx, {
            //     type: 'line',
            //     data: {
            //         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            //         datasets: [{
            //                 label: 'Active Users',
            //                 data: [0, 0, 0, 0, 0, 1850, 1950, 2050, 2150, 2250, 2350, 2450],
            //                 borderColor: 'rgb(59, 130, 246)',
            //                 backgroundColor: 'rgba(59, 130, 246, 0.1)',
            //                 tension: 0.3,
            //                 fill: true
            //             },
            //             {
            //                 label: 'Inactive Users',
            //                 data: [300, 280, 260, 240, 220, 200, 180, 160, 140, 120, 100, 90],
            //                 borderColor: 'rgb(239, 68, 68)',
            //                 backgroundColor: 'rgba(239, 68, 68, 0.1)',
            //                 tension: 0.3,
            //                 fill: true
            //             }

            //         ]
            //     },
            //     options: {
            //         responsive: true,
            //         maintainAspectRatio: false,

            //         plugins: {
            //             //   legend: {
            //             //     display: false
            //             //   },
            //             // legend: {
            //             //     position: 'top',
            //             //     labels: {
            //             //         padding: 10 // Increase this value to add space **below** the legend
            //             //     }
            //             // },
            //             tooltip: {
            //                 mode: 'index',
            //                 intersect: false
            //             }
            //         },
            //         scales: {
            //             y: {
            //                 beginAtZero: true,
            //                 grid: {
            //                     drawBorder: false
            //                 },
            //                 ticks: {
            //                     padding: 10 // Adds space between Y-axis labels and the chart
            //                 }
            //             },
            //             x: {
            //                 // grid: {
            //                 //   display: false
            //                 // }
            //                 ticks: {
            //                     padding: 10 // Adds space between X-axis labels and the chart
            //                 }
            //             }
            //         }
            //     }
            // });

            // Event Types Chart
            const userStatusCtx = document.getElementById('userStatusChart').getContext('2d');
            const userStatusChart = new Chart(userStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Active', 'Deactive'],
                    datasets: [{
                        data: [<?= $unsuspended ?>, <?= $suspended ?>],
                        backgroundColor: [
                            'rgb(34, 197, 74)',
                            'rgb(239, 68, 78)'
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




            // Yearly Website Traffic Chart
            // new Chart(document.getElementById('web-traffic'), {
            //     type: 'line',
            //     data: {
            //         labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'],
            //         datasets: [{
            //                 label: 'User',
            //                 data: generateRandomData(6),
            //                 borderWidth: 1,
            //                 fill: true,
            //                 pointBackgroundColor: 'rgb(59, 130, 246)',
            //                 borderColor: 'rgb(59, 130, 246)',
            //                 backgroundColor: 'rgb(59 130 246 / .15)',
            //                 tension: .2
            //             },
            //             {
            //                 label: 'Event',
            //                 data: generateRandomData(6),
            //                 borderWidth: 1,
            //                 fill: true,
            //                 pointBackgroundColor: 'rgb(16, 185, 129)',
            //                 borderColor: 'rgb(16, 185, 129)',
            //                 backgroundColor: 'rgb(16 185 129 / .15)',
            //                 tension: .2
            //             },
            //             {
            //                 label: 'Post',
            //                 data: generateRandomData(6),
            //                 borderWidth: 1,
            //                 fill: true,
            //                 pointBackgroundColor: 'rgb(244, 63, 94)',
            //                 borderColor: 'rgb(244, 63, 94)',
            //                 backgroundColor: 'rgb(244 63 94 / .15)',
            //                 tension: .2
            //             },
            //         ]
            //     },
            //     options: {
            //         scales: {

            //             y: {
            //                 beginAtZero: true
            //             }
            //         }
            //     }
            // });


            // function generateNDays(n) {
            //     const data = []
            //     for (let i = 0; i < n; i++) {
            //         const date = new Date()
            //         date.setDate(date.getDate() - i)
            //         data.push(date.toLocaleString('en-US', {
            //             month: 'short',
            //             day: 'numeric'
            //         }))
            //     }
            //     return data
            // }

            // function generateRandomData(n) {
            //     const data = []
            //     for (let i = 0; i < n; i++) {
            //         data.push(Math.round(Math.random() * 10))
            //     }
            //     return data
            // }
            // end: Chart


            fetch('backend/get_chart_data.php')
                .then(response => response.json())
                .then(data => {
                    // Extract labels (months) and data
                    const labels = data.map(item => item.month);
                    const users = data.map(item => parseInt(item.user_count));
                    const events = data.map(item => parseInt(item.event_count));
                    const posts = data.map(item => parseInt(item.post_count));

                    // Update Chart.js
                    new Chart(document.getElementById('web-traffic'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'User Registrations',
                                    data: users,
                                    borderWidth: 1,
                                    fill: true,
                                    pointBackgroundColor: 'rgb(59, 130, 246)',
                                    borderColor: 'rgb(59, 130, 246)',
                                    backgroundColor: 'rgb(59 130 246 / .15)',
                                    tension: 0.2
                                },
                                {
                                    label: 'Events Created',
                                    data: events,
                                    borderWidth: 1,
                                    fill: true,
                                    pointBackgroundColor: 'rgb(16, 185, 129)',
                                    borderColor: 'rgb(16, 185, 129)',
                                    backgroundColor: 'rgb(16 185 129 / .15)',
                                    tension: 0.2
                                },
                                {
                                    label: 'Posts Created',
                                    data: posts,
                                    borderWidth: 1,
                                    fill: true,
                                    pointBackgroundColor: 'rgb(244, 63, 94)',
                                    borderColor: 'rgb(244, 63, 94)',
                                    backgroundColor: 'rgb(244 63 94 / .15)',
                                    tension: 0.2
                                }
                            ]
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
        });
    </script>


    <!-- Footer -->
    <?php include('layouts/footer2.php'); ?>

    <!-- Home Page NavBar Sidebar Don't Touch -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../js/main.js"></script>

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
<?php include("../../config/connect.php"); ?>

<?php
session_start();
$user_id = $_SESSION['user_id'];

if (!$user_id) {
    echo "<script>alert('User not logged in.'); window.location.href='login_in.php';</script>";
    exit;
} else {
    //echo "<script>alert('$user_id');</script>";
}

$sql = "SELECT * FROM user WHERE user_id = '$user_id'";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $name = $row['name'];
    $type = $row['user_type'] == "V" ? "Volunteer" : "Organisation";
    $profile = $row['profile_picture']; //Original String
    $profile = preg_replace('/^\.\.\//', '', $profile); // Remove "../" from the start
    //echo "<script>alert('$profile');</script>";  

}

if($type== "Volunteer"){
    echo "<script>alert('You are not authorized to view this page.'); window.location.href='admin.php';</script>";
    exit;

}


$query = "SELECT status, COUNT(*) AS event_count FROM events WHERE organization_id = ? GROUP BY status";

// Prepare and execute the statement
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id); // "i" for integer
$stmt->execute();
$result = $stmt->get_result();

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


$sql = "SELECT * FROM `events`
            WHERE organization_id = ? AND status='Ongoing'  
            ORDER BY `date_of_creation` DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result2 = $stmt->get_result();



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
    <?php include('../../library/library.php'); ?>
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
    <?php include('../layouts/sidebar.php'); ?>

    <!-- Main -->
    <main
        class="w-full md:w-[calc(100%-288px)] md:ml-72 bg-gray-200 min-h-screen transition-all main">

        <!-- Navbar -->
        <?php include('../layouts/navbar.php'); ?>

        <!-- Contents -->
        <div class="p-4 dynamiccontents" id="dynamiccontents">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900">My Events</h1>
                    <button onclick="window.location.href='add_event.php'"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create New Event
                    </button>
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
                            $event_image = preg_replace('/^\.\.\//', '', $event_image);
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
                                                        Volunteer Needed: <?= $accepted_count?>/<?= $volunteer_needed ?>
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
                                                        Max Application: <?= $total_applications?>/<?= $max_application ?>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="flex space-x-2">
                                                <button class="p-2 text-gray-400 hover:text-gray-500" onclick="window.location.href='edit_event.php?id=<?= base64_encode($event_id) ?>'">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </button>
                                                <button class="delete-event p-2 text-gray-400 hover:text-gray-500" data-event-id="<?= $event_id ?>">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="grid grid-cols-3 gap-4">
                                                <div class="bg-gray-100 shadow-md p-4 rounded-lg text-center ">
                                                    <p class="text-sm font-medium text-gray-500">Total Applications</p>
                                                    <p class="mt-2 text-xl font-bold text-gray-900"><?= $total_applications?></p>
                                                </div>
                                                <div class="bg-gray-100 shadow-md p-4 rounded-lg text-center">
                                                    <p class="text-sm font-medium text-gray-500">Approved</p>
                                                    <p class="mt-2 text-xl font-bold text-green-600"><?= $accepted_count?></p>
                                                </div>
                                                <div class="bg-gray-100 shadow-md p-4 rounded-lg text-center">
                                                    <p class="text-sm font-medium text-gray-500">Pending</p>
                                                    <p class="mt-2 text-xl font-bold text-amber-500"><?= $pending_count?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-6 flex justify-end space-x-4">
                                            <button onclick="window.location.href='event_detail.php?id=<?= base64_encode($event_id) ?>'"
                                                class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                View Details
                                            </button>
                                            <button onclick="window.location.href='Event_Applications.php?id=<?= base64_encode($event_id) ?>'"
                                                class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
                            <h1 class=' text-2xl font-semibold'>No Event Created</h1>
                            ";
                    }
                    ?>

                    <!-- Event Card 2 -->
                    <!-- <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                        <div class="md:flex">
                            <div class="md:w-1/3 relative group">
                                <img
                                    src="https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&fit=crop&q=80&w=800"
                                    alt="Youth Mentorship Program"
                                    class="h-48 w-full object-cover md:h-full transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute top-4 left-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-500 text-white shadow-lg">
                                        Scheduled
                                    </span>
                                </div>
                            </div>
                            <div class="p-6 md:w-2/3">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">Youth Mentorship Program</h3>
                                        <div class="mt-2 flex items-center text-gray-500 text-sm space-x-4">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                March 25, 2024
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                04:00 PM - 06:00 PM
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="p-2 text-gray-400 hover:text-gray-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                        <button class="p-2 text-gray-400 hover:text-gray-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                                            <p class="text-sm font-medium text-gray-500">Total Applications</p>
                                            <p class="mt-2 text-xl font-bold text-gray-900">12</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                                            <p class="text-sm font-medium text-gray-500">Approved</p>
                                            <p class="mt-2 text-xl font-bold text-green-600">8</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                                            <p class="text-sm font-medium text-gray-500">Pending</p>
                                            <p class="mt-2 text-xl font-bold text-amber-500">4</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end space-x-4">
                                    <button onclick="window.location.href='/events/2'"
                                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        View Details
                                    </button>
                                    <button onclick="window.location.href='/events/2/applications'"
                                        class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        View Applications
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Event Card 3 -->
                    <!-- <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                        <div class="md:flex">
                            <div class="md:w-1/3 relative group">
                                <img
                                    src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&fit=crop&q=80&w=800"
                                    alt="Food Bank Distribution"
                                    class="h-48 w-full object-cover md:h-full transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute top-4 left-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500 text-white shadow-lg">
                                        Deleted
                                    </span>
                                </div>
                            </div>
                            <div class="p-6 md:w-2/3">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">Food Bank Distribution</h3>
                                        <div class="mt-2 flex items-center text-gray-500 text-sm space-x-4">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                March 22, 2024
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                08:00 AM - 12:00 PM
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="p-2 text-gray-400 hover:text-gray-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                                            <p class="text-sm font-medium text-gray-500">Total Applications</p>
                                            <p class="mt-2 text-xl font-bold text-gray-900">18</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                                            <p class="text-sm font-medium text-gray-500">Approved</p>
                                            <p class="mt-2 text-xl font-bold text-green-600">12</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                                            <p class="text-sm font-medium text-gray-500">Pending</p>
                                            <p class="mt-2 text-xl font-bold text-amber-500">6</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end space-x-4">
                                    <button onclick="window.location.href='/events/3'"
                                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        View Details
                                    </button>
                                    <button onclick="window.location.href='/events/3/applications'"
                                        class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        View Applications
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    // Tab switching functionality
                    $('nav button').click(function() {
                        // Remove active classes from all tabs
                        $('nav button').removeClass('border-blue-500 text-blue-600').addClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');

                        // Add active classes to clicked tab
                        $(this).addClass('border-blue-500 text-blue-600').removeClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');
                        let Type = $(this).data("status");
                       // alert(Type);
                        var organizer_id = <?= $user_id ?>


                        $.ajax({
                            url: "Backend/my_events.php", // Backend PHP script
                            method: "POST",
                            data: {
                                type: Type,
                                org_id: organizer_id
                            },
                            success: function(response) {
                                $(".event_list").html(response); // Show results
                                //  $("#events-list").html(""); // Clear results if input is empty
                            },
                            error: function(xhr, status, error) {
                                console.log("AJAX Error: " + status + " " + error);
                                alert("AJAX Error: " + status + " " + error);
                            }
                        });
                    });

                    // $('nav button').click(function() {
                    //     // Remove active classes from all tabs
                    //     $('nav button').removeClass('border-blue-500 text-blue-600').addClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');

                    //     // Add active classes to clicked tab
                    //     $(this).addClass('border-blue-500 text-blue-600').removeClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');
                    // });

                    $(".delete-event").click(function(e) {
                        e.preventDefault();
                        let eventId = $(this).data("event-id");
                        //alert(eventId);

                        if (confirm("Are you sure you want to delete this event?")) {
                            $.ajax({
                                url: "Backend/delete_event.php",
                                type: "POST",
                                data: {
                                    event_id: eventId
                                },
                                dataType: "json", // Expect JSON response
                                success: function(response) {
                                    if (response.status === 'success') {
                                        alert(response.message); // Show success message
                                        location.reload(); // Reload the page after deletion
                                    } else {
                                        alert(response.message); // Show error message
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log("AJAX Error: " + status + " " + error);
                                    console.log("Server Response: " + xhr.responseText);
                                }
                            });
                        }
                    });




                });
            </script>
        </div>
        <!-- End Content -->

    </main>






    <!-- Footer -->
    <?php include('../layouts/footer.php'); ?>

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
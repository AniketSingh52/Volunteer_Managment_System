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

$sql = "SELECT * from user";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $availabe = 1;
} else {
    $availabe = 0;
}

    $applications = $result->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT 
            SUM(CASE WHEN latest_action = 'Suspend' THEN 1 ELSE 0 END) AS suspended_users,
            SUM(CASE WHEN latest_action = 'unsuspend' OR latest_action IS NULL THEN 1 ELSE 0 END) AS unsuspended_users
        FROM (
            SELECT 
                u.user_id,
                (SELECT action 
                 FROM admin_manage_user amu 
                 WHERE amu.user_id = u.user_id 
                 ORDER BY amu.date DESC 
                 LIMIT 1) AS latest_action
            FROM user u
        ) AS user_status";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $suspended = $row['suspended_users']; //DEACTIVE
    $unsuspended = $row['unsuspended_users']; //ACTIVE 

 
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
    <link href="https://cdn.jsdelivr.net/npm/lucide-icons@0.294.0/dist/umd/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>


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
            <div class="max-w-7xl mx-auto px-6 py-4">

                <!-- Header -->
                <div class="flex justify-between items-center mb-8 mt-3">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900">User Management</h1>
                        <p class="mt-1 text-gray-500">Manage and monitor user accounts</p>
                    </div>

                </div>


                <!-- Charts Section -->
                <div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-2 mb-10">
                    <!--User traffic Chart -->
                    <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-gray-900">User Traffic</h2>
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-200 rounded-full mr-1"></div>
                                    <span class="text-xs text-gray-600">Volunteer</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-200 rounded-full mr-1"></div>
                                    <span class="text-xs text-gray-600">Organization</span>
                                </div>

                            </div>
                        </div>
                        <div class="relative h-64 ">
                            <canvas class=" min-w-full" id="userTraffic"></canvas>
                        </div>
                    </div>

                    <!-- User Status Chart -->
                    <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-lg font-semibold text-gray-900">User Status</h2>
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-1"></div>
                                    <span class="text-xs text-gray-600">Active</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-500 rounded-full mr-1"></div>
                                    <span class="text-xs text-gray-600">Inactive</span>
                                </div>
                            </div>
                        </div>
                        <div class="relative h-64">
                            <canvas id="userStatusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- User List -->
                <div class="space-y-6 mb-6">
                    <!-- User Card -->



                    <?php
                    foreach ($applications as $applicunt):

                        $applicunt_id = $applicunt['user_id'];

                        $sql = "SELECT * FROM `admin_manage_user` WHERE user_id=? ORDER by date Desc limit 1";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $applicunt_id); // "i" for integer
                        $stmt->execute();
                        $result2 = $stmt->get_result();
                        $user_status = "Active";
                        $user_status_style = " bg-green-400 text-white ";
                        if ($result2->num_rows > 0) {

                            $row = $result2->fetch_assoc();
                            // echo $row['action'];
                            $user_status = ($row['action'] == "Suspend") ? "Deactive" : "Active";
                            $user_status_style = ($row['action'] == "Suspend") ? " bg-red-500 text-white " : " bg-green-400 text-white ";
                        }


                        $profile = $applicunt['profile_picture']; //Original String
                        // $profile = preg_replace('/^\.\.\//', '', $profile); // Remove "../" from the start
                        $date_of_joining = date('jS M y', strtotime($applicunt['registration_date']));
                        $user_type = $applicunt['user_type'] == "V" ? "Volunteer" : "Organisation";

                        $user_type_style = $applicunt['user_type'] == "V" ? " bg-green-400 text-white " : " bg-indigo-400 text-white ";
                        $gender = $applicunt['gender'];
                        switch ($gender) {
                            case 'M':
                                $gender = 'Male';

                                break;
                            case 'F':
                                $gender = 'Female';

                                break;
                            case 'O':
                                $gender = 'Others';

                                break;
                            default:
                                $gender = 'Not Specified';
                                break;
                        }


                        if ($user_type != "Organisation") {
                            $query = "SELECT status,COUNT(*) AS total from events_application where volunteer_id=? group by status";

                            // Prepare and execute the statement
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("i", $applicunt_id); // "i" for integer
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Initialize variables
                            $accepted = 0;
                            $rejected = 0;
                            $pending = 0;


                            // Fetch the results and store in variables
                            while ($row = $result->fetch_assoc()) {
                                switch ($row['status']) {
                                    case 'accepted':
                                        $accepted = $row['total'];
                                        break;
                                    case 'pending':
                                        $pending = $row['total'];
                                        break;
                                    case 'rejected':
                                        $rejected = $row['total'];
                                        break;
                                }
                            }
                        } else {

                            $query = "SELECT status, COUNT(*) AS event_count FROM events WHERE organization_id = ? GROUP BY status";

                            // Prepare and execute the statement
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("i", $applicunt_id); // "i" for integer
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

                            $sql = "SELECT type_name FROM `organization_type` WHERE type_id=(SELECT type_id FROM `organization_belongs_type` WHERE user_id=?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $applicunt_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $org_type_name = $row['type_name'];
                        }



                    ?>
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <!-- Header Section -->
                                <div class="flex items-start justify-between">
                                    <div class="flex flex-grow space-x-6">
                                        <img
                                            src="<?= $profile ?>"
                                            alt="<?= $applicunt['name'] ?>"
                                            class="h-24 w-24 rounded-xl object-cover border-2 border-gray-200">
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="text-2xl font-bold text-gray-900"><?= $applicunt['name'] ?> <span class=" ml-3 text-sm border-2  shadow-sm rounded-xl px-2 py-1  <?= $user_type_style ?> "><?= $user_type ?></span></h3>
                                                    <p class="text-base text-gray-500">User ID: @<?= $applicunt['user_name'] ?></p>
                                                </div>
                                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium <?= $user_status_style ?>">
                                                    <?= $user_status ?>
                                                </span>
                                            </div>
                                            <div class="mt-4 flex items-center space-x-4">
                                                <div class="flex items-center">
                                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    <p class="ml-1.5 text-base font-medium text-gray-600">Volunteer Score: <?= $accepted * 100 ?></p>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <p class="ml-1.5 text-base font-medium text-gray-600">Joined: <?= $date_of_joining ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Details Grid -->
                                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <div>
                                            <h4 class="text-lg font-medium text-gray-500 mb-1">Personal Information</h4>
                                            <div class="space-y-2">
                                                <div class="flex items-center">
                                                    <svg class="h-4 w-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="text-base text-gray-600">DOB/DOE: <?= $applicunt['DOB/DOE'] ?></span>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="h-4 w-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    <?php
                                                    if ($user_type != "Organisation") {

                                                    ?>
                                                        <span class="text-base text-gray-600">Gender: <?= $gender ?></span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="text-base text-gray-600">Organization Type: <?= $org_type_name ?></span>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <h4 class="text-lg font-medium text-gray-500 mb-1">Contact Information</h4>
                                            <div class="space-y-2">
                                                <div class="flex items-center">
                                                    <svg class="h-4 w-4 text-purple-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="text-base text-gray-600"><?= $applicunt['email'] ?></span>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="h-4 w-4 text-indigo-800 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                    </svg>
                                                    <span class="text-base text-gray-600">+91 <?= $applicunt['contact'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <h4 class="text-lg font-medium text-gray-500 mb-1">Location</h4>
                                            <div class="space-y-2">
                                                <div class="flex items-start">
                                                    <svg class="h-4 w-4 text-violet-700 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <span class="text-base text-gray-600"> <?= $applicunt['address'] ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <h4 class="text-lg font-medium text-gray-500 mb-1"> <?= ($user_type != "Organisation") ? "Skills" : "Causes" ?></h4>
                                            <div class="mt-2 flex flex-wrap gap-2">

                                                <?php
                                                if ($user_type != "Organisation") {

                                                    $sql = "SELECT skill_name FROM `skill` WHERE skill_id in (SELECT skill_id FROM `volunteer_skill` WHERE user_id=?)";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->bind_param("i", $applicunt_id);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    $index = 0;
                                                    $styles = [
                                                        "bg-amber-100 text-amber-800 hover:bg-amber-200",
                                                        "bg-violet-100 text-violet-800 hover:bg-violet-200",
                                                        "bg-rose-100 text-rose-800 hover:bg-rose-200",
                                                        "bg-fuchsia-100 text-fuchsia-800 hover:bg-fuchsia-200 ",
                                                        "bg-emerald-100 text-emerald-800 hover:bg-emerald-200 "
                                                    ];

                                                    if ($result->num_rows > 0) {

                                                        while ($row = $result->fetch_assoc()) {
                                                            $skill_name = $row['skill_name'];
                                                            $style = $styles[$index % 2];
                                                            $index++;
                                                            echo '
                                                         <span class=" ' . $style . '   inline-flex items-center px-3 py-1 rounded-full text-base font-medium  cursor-pointer">' . $skill_name . '</span>
                                                            ';
                                                        }
                                                    } else {
                                                        echo '
                                                            <span class=" bg-orange-100 text-orange-800 hover:bg-orange-200  rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 cursor-pointer"> No Skill</span>
                                                                                    ';
                                                    }
                                                } else {
                                                    $sql = "SELECT name FROM `causes` WHERE cause_id in (SELECT cause_id FROM `user_workfor_causes` WHERE user_id=?)";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->bind_param("i", $applicunt_id);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    $index = 0;
                                                    $styles = [
                                                        "bg-amber-100 text-amber-800 hover:bg-amber-200",
                                                        "bg-violet-100 text-violet-800 hover:bg-violet-200",
                                                        "bg-rose-100 text-rose-800 hover:bg-rose-200",
                                                        "bg-fuchsia-100 text-fuchsia-800 hover:bg-fuchsia-200 ",
                                                        "bg-emerald-100 text-emerald-800 hover:bg-emerald-200 "
                                                    ];

                                                    if ($result->num_rows > 0) {

                                                        while ($row = $result->fetch_assoc()) {
                                                            $cause_name = $row['name'];
                                                            $style = $styles[$index % 5];
                                                            $index++;
                                                            echo '
                                                         <span class=" ' . $style . '   inline-flex items-center px-3 py-1 rounded-full text-base font-medium  cursor-pointer">' . $cause_name . '</span>
                                                            ';
                                                        }
                                                    } else {
                                                        echo '
                                                            <span class=" bg-orange-100 text-orange-800 hover:bg-orange-200  rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 cursor-pointer"> No Skill</span>
                                                                                    ';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Activity Statistics -->

                                <div class="mt-6 grid grid-cols-4 gap-4">
                                    <?php
                                    if ($user_type != "Organisation") {

                                    ?>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-base font-semibold text-gray-500">Total Applications</div>
                                            <div class="text-lg font-semibold text-gray-900"><?= $accepted + $rejected + $pending ?></div>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-base font-semibold text-gray-500">Events Attended</div>
                                            <div class="text-lg font-semibold text-gray-900"><?= $accepted ?></div>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-base font-semibold text-gray-500">Pending Participation</div>
                                            <div class="text-lg font-semibold text-gray-900"><?= $pending ?></div>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-base font-semibold text-gray-500">Rejected Applications</div>
                                            <div class="text-lg font-semibold text-gray-900"><?= $rejected ?></div>
                                        </div>

                                    <?php } else { ?>

                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-base font-semibold text-gray-500">Ongoing Events</div>
                                            <div class="text-lg font-semibold text-gray-900"><?= $ongoing ?></div>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-base font-semibold text-gray-500">Scheduled Events</div>
                                            <div class="text-lg font-semibold text-gray-900"><?= $scheduled ?></div>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-base font-semibold text-gray-500">Cancelled</div>
                                            <div class="text-lg font-semibold text-gray-900"><?= $cancelled ?></div>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-base font-semibold text-gray-500">Completed</div>
                                            <div class="text-lg font-semibold text-gray-900"><?= $completed ?></div>
                                        </div>


                                    <?php

                                    } ?>
                                </div>

                                <!-- Account Status History -->
                                <!-- <div class="mt-6">
                                <h4 class="text-lg font-medium text-gray-500 mb-3">Account Status History</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                <span class="text-sm text-gray-600">Account activated by Admin (Sarah Wilson)</span>
                                            </div>
                                            <span class="text-sm text-gray-500">Mar 15, 2024 10:30 AM</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                                <span class="text-sm text-gray-600">Account deactivated by Admin (John Smith)</span>
                                            </div>
                                            <span class="text-sm text-gray-500">Mar 10, 2024 3:45 PM</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                <span class="text-sm text-gray-600">Initial account activation</span>
                                            </div>
                                            <span class="text-sm text-gray-500">Mar 1, 2024 9:00 AM</span>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                                <!-- Action Buttons -->
                                <div class="mt-6 action_list flex justify-end space-x-4">
                                    <button data-action="IGNORE" onclick="window.location.href='profile2.php?id=<?= base64_encode($applicunt_id) ?>'" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover:scale-105 transition-all duration-300">
                                        View Full Profile
                                        <?php
                                        if ($user_status == "Active") {

                                        ?>
                                            <button data-action="Suspend" data-userid="<?= $applicunt_id ?>" class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 hover:scale-105 transition-all duration-300">
                                                Deactivate
                                            </button>
                                        <?php
                                        } else {

                                        ?>
                                            <button data-action="unsuspend" data-userid="<?= $applicunt_id ?>" class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 hover:scale-105 transition-all duration-300">
                                                Activate
                                            </button>
                                        <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php
                    if ($availabe == 0) {
                        echo "<h1 class=' text-2xl h-72 text-center mb-40'>No Users Yet</h1> ";
                    }

                    ?>

                    <!-- Additional user cards would go here -->
                </div>



            </div>
        </div>
        <!-- End Content -->

    </main>



    <script>
        $(document).ready(function() {
            $(document).on('click', '.action_list button', function() {
                let action = $(this).data("action");
                let user = $(this).data("userid");

                // alert(action);
                // alert(user);
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
                                //alert(response.message); // Show success message
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

            fetch('backend/get_user_traffic.php')
                .then(response => response.json())
                .then(data => {
                    // Extract labels (months) and data
                    const labels = data.map(item => item.month);
                    const usersV = data.map(item => parseInt(item.volunteer_count));
                    const usersO = data.map(item => parseInt(item.organization_count));


                    // Update Chart.js
                    new Chart(document.getElementById('userTraffic'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Volunteer Registrations',
                                    data: usersV,
                                    borderWidth: 1,
                                    fill: true,
                                    pointBackgroundColor: 'rgb(59, 130, 246)',
                                    borderColor: 'rgb(59, 130, 246)',
                                    backgroundColor: 'rgb(59 130 246 / .15)',
                                    tension: 0.2
                                },
                                {
                                    label: 'Organization Registration',
                                    data: usersO,
                                    borderWidth: 1,
                                    fill: true,
                                    pointBackgroundColor: 'rgb(16, 185, 129)',
                                    borderColor: 'rgb(16, 185, 129)',
                                    backgroundColor: 'rgb(16 185 129 / .15)',
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
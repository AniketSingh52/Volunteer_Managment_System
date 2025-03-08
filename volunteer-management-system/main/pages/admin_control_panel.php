<?php include("../../config/connect.php"); ?>

<?php
session_start();
error_reporting(0);
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
    <?php include('admin/layouts/sidebar2.php'); ?>

    <!-- Main -->
    <main
        class="w-full md:w-[calc(100%-288px)] md:ml-72 bg-gray-200 min-h-screen transition-all main">

        <!-- Navbar -->
        <?php include('admin/layouts/navbar2.php'); ?>

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
                                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                            </div>
                            <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">

                                <!-- Volunteer & organization Count -->
                                <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 md:grid-cols-2">
                                    <!-- Total Organization Card -->
                                    <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-center">
                                            <div class="p-3 rounded-full bg-indigo-100">
                                                <svg class="w-8 h-8 text-violet-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <div class="ml-5">
                                                <p class=" text-lg font-semibold text-gray-500 truncate">Registered Organizations</p>
                                                <p class="text-3xl font-bold text-gray-900">2,543</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="flex items-center justify-between">
                                                <div class="text-sm text-green-600 font-semibold flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                    </svg>
                                                    12.5%
                                                </div>
                                                <div class="text-sm text-gray-500">vs last month</div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Active Volunteers Card -->
                                    <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-center">
                                            <div class="p-3 rounded-full bg-amber-100">
                                                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            </div>
                                            <div class="ml-5">
                                                <p class="text-lg font-semibold text-gray-500 truncate">Registered Volunteers</p>
                                                <p class="text-3xl font-bold text-gray-900">1,875</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="flex items-center justify-between">
                                                <div class="text-sm text-green-600 font-semibold flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                    </svg>
                                                    15.3%
                                                </div>
                                                <div class="text-sm text-gray-500">vs last month</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Bento Grid Layout -->
                                <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3">
                                    <!-- Total Users Card -->
                                    <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-center">
                                            <div class="p-3 rounded-full bg-indigo-100">
                                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <div class="ml-5">
                                                <p class="text-sm font-medium text-gray-500 truncate">Total Users</p>
                                                <p class="text-3xl font-semibold text-gray-900">2,543</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="flex items-center justify-between">
                                                <div class="text-sm text-green-600 font-semibold flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                    </svg>
                                                    12.5%
                                                </div>
                                                <div class="text-sm text-gray-500">vs last month</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Events Card -->
                                    <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-center">
                                            <div class="p-3 rounded-full bg-blue-100">
                                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="ml-5">
                                                <p class="text-sm font-medium text-gray-500 truncate">Total Events</p>
                                                <p class="text-3xl font-semibold text-gray-900">487</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="flex items-center justify-between">
                                                <div class="text-sm text-green-600 font-semibold flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                    </svg>
                                                    8.2%
                                                </div>
                                                <div class="text-sm text-gray-500">vs last month</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Posts Card -->
                                    <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-center">
                                            <div class="p-3 rounded-full bg-green-100">
                                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                                </svg>
                                            </div>
                                            <div class="ml-5">
                                                <p class="text-sm font-medium text-gray-500 truncate">Total Posts</p>
                                                <p class="text-3xl font-semibold text-gray-900">1,256</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="flex items-center justify-between">
                                                <div class="text-sm text-red-600 font-semibold flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                                    </svg>
                                                    3.2%
                                                </div>
                                                <div class="text-sm text-gray-500">vs last month</div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <!-- Charts Section -->
                                <div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-2">
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

                                <!-- User Management Section -->
                                <div class="mt-8 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <h2 class="text-lg font-semibold text-gray-900">Latest User Registration</h2>
                                            <div class="flex items-center space-x-2">
                                                <div class="relative">
                                                    <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                        <option>All Users</option>
                                                        <option>Only Volunteer</option>
                                                        <option>Only Organisation</option>
                                                    </select>
                                                </div>
                                                <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <i class='bx bx-cog mr-2'></i>
                                                    Manage Users
                                                </button>
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
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Type
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Status
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Joined
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-center  text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Actions
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150" alt="">
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    Jane Cooper
                                                                </div>
                                                                <div class="text-sm text-gray-500">
                                                                    jane.cooper@example.com
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">Volunteer</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Active
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        Jan 10, 2023
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <div class="flex space-x-2">
                                                            <button class="bg-green-600 px-4 py-2 rounded-lg w-1/2 hover:text-indigo-900 text-white">Active</button>
                                                            <button class="bg-red-600 px-4 py-2 rounded-lg w-1/2 hover:text-red-900 text-white">Deactivate</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&q=80&w=150" alt="">
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    John Smith
                                                                </div>
                                                                <div class="text-sm text-gray-500">
                                                                    john.smith@example.com
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">Organization</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Inactive
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        Mar 15, 2023
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <div class="flex space-x-2">
                                                            <button class="bg-green-600 px-4 py-2 rounded-lg w-1/2 hover:bg-green-900 text-white transition-all duration-300 hover:scale-105">Active</button>
                                                            <button class="bg-red-600 px-4 py-2 rounded-lg w-1/2 hover:bg-red-900 text-white transition-all duration-300 hover:scale-105">Deactivate</button>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="px-6 py-4 border-t border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <div class="text-sm text-gray-700">
                                                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">25</span> results
                                            </div>
                                            <div class="flex space-x-2">
                                                <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                    View More
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Event Management Section -->
                                <div class="mt-8 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <h2 class="text-lg font-semibold text-gray-900">Event Management</h2>
                                            <div class="flex items-center space-x-2">
                                                <div class="relative">
                                                    <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                        <option>All Events</option>
                                                        <option>Ongoing Events</option>
                                                        <option>Scheduled Events</option>
                                                        <option>Completed Events</option>
                                                        <option>Cancelled Events</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Event
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Organizer
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Date
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Status
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Applications
                                                    </th>
                                                    <th scope="col" class="px-6 text-center py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Actions
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded object-cover" src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=150" alt="">
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    Community Garden Clean-up
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">Green Earth Initiative</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        Mar 20, 2024
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Ongoing
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        24
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <div class="flex space-x-2">
                                                            <button class="bg-indigo-600 w-1/2 rounded-xl px-4 py-2 hover:bg-indigo-900 text-white transition-all duration-300 hover:scale-105">View</button>
                                                            <button class="bg-red-600 w-1/2 rounded-lg hover:bg-red-900 text-white transition-all duration-300 hover:scale-105">Cancel</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded object-cover" src="https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&fit=crop&q=80&w=150" alt="">
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    Youth Mentorship Program
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">Youth Forward</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        Mar 25, 2024
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            Scheduled
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        12
                                                    </td>
                                                    <td class="px-6 py-4 w-1/4 whitespace-nowrap text-sm font-medium">
                                                        <div class="flex space-x-2">
                                                            <button class="bg-indigo-600 w-1/2 rounded-xl px-4 py-2 hover:bg-indigo-900 text-white transition-all duration-300 hover:scale-105">View</button>
                                                            <button class="bg-red-600 w-1/2 rounded-lg hover:bg-red-900 text-white transition-all duration-300 hover:scale-105">Cancel</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded object-cover" src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&fit=crop&q=80&w=150" alt="">
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    Food Bank Distribution
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">Food for All</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        Mar 22, 2024
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                            Completed
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        18
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <div class="flex space-x-2">
                                                            <button class="text-indigo-600 hover:text-indigo-900">View</button>
                                                            <button class="text-gray-600 hover:text-gray-900">Archive</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="px-6 py-4 border-t border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <div class="text-sm text-gray-700">
                                                Showing <span class="font-medium">1</span> to <span class="font-medium">3</span> of <span class="font-medium">15</span> results
                                            </div>
                                            <div class="flex space-x-2">
                                                <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                    Previous
                                                </button>
                                                <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                    Next
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Activity Section -->
                                <div class="mt-8 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
                                    </div>
                                    <div class="p-6">
                                        <ul class="space-y-6">
                                            <li class="relative flex gap-x-4">
                                                <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                                                    <div class="w-px bg-gray-200"></div>
                                                </div>
                                                <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                                                    <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                                                </div>
                                                <div class="flex-auto py-0.5 text-sm leading-5">
                                                    <div class="flex justify-between gap-x-4">
                                                        <div class="text-gray-500">
                                                            <span class="font-medium text-gray-900">Jane Cooper</span> created a new event <span class="font-medium text-gray-900">Beach Clean-up Drive</span>
                                                        </div>
                                                        <time datetime="2023-01-23T10:32" class="flex-none text-gray-500">10m ago</time>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="relative flex gap-x-4">
                                                <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                                                    <div class="w-px bg-gray-200"></div>
                                                </div>
                                                <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                                                    <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                                                </div>
                                                <div class="flex-auto py-0.5 text-sm leading-5">
                                                    <div class="flex justify-between gap-x-4">
                                                        <div class="text-gray-500">
                                                            <span class="font-medium text-gray-900">Robert Johnson</span> applied to <span class="font-medium text-gray-900">Community Garden Clean-up</span>
                                                        </div>
                                                        <time datetime="2023-01-23T09:12" class="flex-none text-gray-500">1h ago</time>
                                                        <div class="flex-auto py-0.5 text-sm leading-5">
                                                            <div class="flex justify-between gap-x-4">
                                                                <div class="text-gray-500">
                                                                    <span class="font-medium text-gray-900">Robert Johnson</span> applied to <span class="font-medium text-gray-900">Community Garden Clean-up</span>
                                                                </div>
                                                                <time datetime="2023-01-23T09:12" class="flex-none text-gray-500">1h ago</time>
                                                            </div>
                                                        </div>
                                            </li>
                                            <li class="relative flex gap-x-4">
                                                <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                                                    <div class="w-px bg-gray-200"></div>
                                                </div>
                                                <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                                                    <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                                                </div>
                                                <div class="flex-auto py-0.5 text-sm leading-5">
                                                    <div class="flex justify-between gap-x-4">
                                                        <div class="text-gray-500">
                                                            <span class="font-medium text-gray-900">Admin</span> approved <span class="font-medium text-gray-900">Youth Mentorship Program</span>
                                                        </div>
                                                        <time datetime="2023-01-23T15:56" class="flex-none text-gray-500">3h ago</time>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="relative flex gap-x-4">
                                                <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                                                    <div class="w-px bg-gray-200"></div>
                                                </div>
                                                <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                                                    <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                                                </div>
                                                <div class="flex-auto py-0.5 text-sm leading-5">
                                                    <div class="flex justify-between gap-x-4">
                                                        <div class="text-gray-500">
                                                            <span class="font-medium text-gray-900">John Smith</span> posted a new article <span class="font-medium text-gray-900">Volunteering Benefits</span>
                                                        </div>
                                                        <time datetime="2023-01-23T15:56" class="flex-none text-gray-500">5h ago</time>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="relative flex gap-x-4">
                                                <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                                                    <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                                                </div>
                                                <div class="flex-auto py-0.5 text-sm leading-5">
                                                    <div class="flex justify-between gap-x-4">
                                                        <div class="text-gray-500">
                                                            <span class="font-medium text-gray-900">Green Earth Initiative</span> completed <span class="font-medium text-gray-900">Food Bank Distribution</span>
                                                        </div>
                                                        <time datetime="2023-01-23T15:56" class="flex-none text-gray-500">1d ago</time>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- User Traffic -->
                                <div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-1">
                                    <!-- User Status Chart -->
                                    <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between mb-3">
                                            <h2 class="text-lg font-semibold text-gray-900">Yearly Website Traffic</h2>
                                            <div class="flex items-center space-x-2">
                                                <div class="flex items-center">
                                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-1"></div>
                                                    <span class="text-xs text-gray-600">User Registration</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-1"></div>
                                                    <span class="text-xs text-gray-600">Events Created</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <div class="w-3 h-3 bg-red-500 rounded-full mr-1"></div>
                                                    <span class="text-xs text-gray-600">Post Created</span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class=" py-2 px-4">
                                            <canvas id="order-chart"></canvas>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>

                        <!-- <div>
                            <canvas id="order-chart"></canvas>
                        </div> -->
                    </main>
                </div>


            </div>
        </div>
        <!-- End Content -->

    </main>



    <script>
        $(document).ready(function() {

            // User Status Chart
            const userStatusCtx = document.getElementById('userStatusChart').getContext('2d');
            const userStatusChart = new Chart(userStatusCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                            label: 'Active Users',
                            data: [0, 0, 0, 0, 0, 1850, 1950, 2050, 2150, 2250, 2350, 2450],
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Inactive Users',
                            data: [300, 280, 260, 240, 220, 200, 180, 160, 140, 120, 100, 90],
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.3,
                            fill: true
                        }

                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        //   legend: {
                        //     display: false
                        //   },
                        // legend: {
                        //     position: 'top',
                        //     labels: {
                        //         padding: 10 // Increase this value to add space **below** the legend
                        //     }
                        // },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            },
                            ticks: {
                                padding: 10 // Adds space between Y-axis labels and the chart
                            }
                        },
                        x: {
                            // grid: {
                            //   display: false
                            // }
                            ticks: {
                                padding: 10 // Adds space between X-axis labels and the chart
                            }
                        }
                    }
                }
            });





            // Yearly Website Traffic Chart
            new Chart(document.getElementById('order-chart'), {
                type: 'line',
                data: {
                    labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'],
                    datasets: [{
                            label: 'User',
                            data: generateRandomData(6),
                            borderWidth: 1,
                            fill: true,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgb(59 130 246 / .15)',
                            tension: .2
                        },
                        {
                            label: 'Event',
                            data: generateRandomData(6),
                            borderWidth: 1,
                            fill: true,
                            pointBackgroundColor: 'rgb(16, 185, 129)',
                            borderColor: 'rgb(16, 185, 129)',
                            backgroundColor: 'rgb(16 185 129 / .15)',
                            tension: .2
                        },
                        {
                            label: 'Post',
                            data: generateRandomData(6),
                            borderWidth: 1,
                            fill: true,
                            pointBackgroundColor: 'rgb(244, 63, 94)',
                            borderColor: 'rgb(244, 63, 94)',
                            backgroundColor: 'rgb(244 63 94 / .15)',
                            tension: .2
                        },
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

            function generateNDays(n) {
                const data = []
                for (let i = 0; i < n; i++) {
                    const date = new Date()
                    date.setDate(date.getDate() - i)
                    data.push(date.toLocaleString('en-US', {
                        month: 'short',
                        day: 'numeric'
                    }))
                }
                return data
            }

            function generateRandomData(n) {
                const data = []
                for (let i = 0; i < n; i++) {
                    data.push(Math.round(Math.random() * 10))
                }
                return data
            }
            // end: Chart

            
            // Event Types Chart
            const eventTypesCtx = document.getElementById('eventTypesChart').getContext('2d');
            const eventTypesChart = new Chart(eventTypesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Ongoing', 'Scheduled', 'Completed', 'Cancelled'],
                    datasets: [{
                        data: [125, 210, 135, 17],
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
    <?php include('admin/layouts/footer2.php'); ?>

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
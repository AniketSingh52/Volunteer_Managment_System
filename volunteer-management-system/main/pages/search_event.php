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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
    <?php include('../layouts/sidebar.php'); ?>

    <!-- Main -->
    <main
        class="w-full md:w-[calc(100%-288px)] md:ml-72 bg-gray-200 min-h-screen transition-all main">

        <!-- Navbar -->
        <?php include('../layouts/navbar.php'); ?>

        <!-- Contents -->
        <div class="p-4 dynamiccontents" id="dynamiccontents">

            <!-- Search BAR And Filter -->
            <div class="container mx-auto px-4 pt-4 relative">
                <!-- Search Bar and Filter Button -->
                <form class="flex justify-center mb-4" id="form1">
                    <div class="relative w-full md:max-w-5xl  flex items-center">
                        <input type="text" id="searchInput" placeholder="Search events..." class=" h-14 transition-all w-full px-4 py-2 rounded-l-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <a id="cancelSearch" class="absolute text-xl right-44 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-400 hidden">
                            <i class="fas fa-times"></i>
                        </a>
                        <button type="submit" id="searchBtn" class=" text-xl px-4 py-2 h-full bg-blue-500 text-white rounded-r-full hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            <i class="fas fa-search"></i>
                        </button>
                        <a id="filterBtn" class="ml-2 px-4 py-2 flex bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            <i class="fas fa-filter mr-2 m-1"></i>Filter
                        </a>
                    </div>
                </form>

                <!-- Filter Menu (Hidden by default) -->
                <!-- <div id="filterMenu" class="hidden bg-white p-4 rounded-md shadow-md mb-8 max-w-xl mx-auto relative"> -->
                <div id="filterMenu" class="bg-white top-20 z-20 border-2 bright-10 md:right-24  absolute p-4 rounded-md shadow-md mb-8 max-w-xl mx-auto hidden">
                    <button id="closeFilter" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                    <h3 class="text-lg font-semibold mb-4">Filter Options</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="dateFrom" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" id="dateFrom" class=" mt-1 w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-blue-600">
                        </div>

                        <div>
                            <label for="timeFrom" class=" top- block text-sm font-medium text-gray-700">Time</label>
                            <input type="time" id="timeFrom" class=" mt-1 w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-blue-600">
                        </div>

                        <div>
                            <label for="organizer" class="block text-sm font-medium text-gray-700">Organizer</label>
                            <select id="organizer" class=" mt-1 w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                <option value="">Select Organizer</option>
                                <option value="org1">Organizer 1</option>
                                <option value="org2">Organizer 2</option>
                                <option value="org3">Organizer 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button id="applyFilters" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Event Listing -->
            <div class="max-w-7xl mx-auto px-4 py-2 mb-6">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">
                    Available Opportunities
                </h2>
                <div id="events-list" class="space-y-6 ">
                    <!-- <div id="events-list" class="space-y-6 list1"> -->
                    <!-- <div
                        class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="md:flex">
                            <div class="md:w-1/3">
                                <img
                                    class="h-48 w-full object-cover md:h-full"
                                    src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&amp;fit=crop&amp;q=80&amp;w=800"
                                    alt="Community Garden Clean-up" />
                            </div>
                            <div class="p-8 md:w-2/3 relative">
                                <div
                                    class="text-sm absolute font-semibold top-0 right-0 bg-green-500 rounded-sm px-4 py-2 text-white mt-3 mr-3 hover:bg-green-800 hover:text-white transition duration-500 ease-in-out">
                                    Ongoing
                                </div>
                                <div
                                    class="uppercase  tracking-wide text-sm text-blue-600 font-semibold">
                                    Green Earth Initiative
                                    <span class=" ml-3 text-gray-700 border-2 border-gray-200 shadow-sm rounded-xl px-2 py-1 bg-gray-200">10 days</span>
                                </div>

                                <h3 class="mt-1 text-2xl font-semibold text-gray-900">
                                    Community Garden Clean-up
                                </h3>

                                <div class="mt-4 flex items-center text-gray-600">
                                    <svg
                                        class="h-5 w-5 mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    2024-03-20 • 2024-03-20
                                </div>

                                <div class="mt-2 flex items-center text-gray-600">
                                    <svg
                                        class="h-5 w-5 mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    09:00 - 14:00
                                </div>

                                <div class="mt-2 flex items-center text-gray-600">
                                    <svg
                                        class="h-5 w-5 mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Central Community Garden
                                </div>

                                <div class="mt-2 flex items-center font-semibold text-base text-gray-600">
                                    <svg
                                        class="h-5 w-5 mr-2"
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
                                    Volunteer Needed: 0/10
                                </div>
                                <div class=" flex">
                                    <div class="flex mt-2 flex-wrap items-center  font-bold text-base text-gray-600">
                                        Tags:
                                    </div>
                                    <div class="mt-2 flex flex-wrap items-center justify-items-center px-3 font-semibold text-base text-gray-600">

                                        <span class=" ml-2 mt-1 bg-amber-100 text-amber-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-amber-200 cursor-pointer">Animal Rescue</span>
                                        <span class=" ml-2 mt-1 bg-violet-100 text-violet-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-violet-200 cursor-pointer">Social Awareness</span>
                                        <span class=" ml-2 mt-1 bg-rose-100 text-rose-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-rose-200 cursor-pointer">Clean-Up Drives</span>
                                    </div>
                                </div>
                                <div class=" flex mt-2">
                                    <div class="flex mt-2 flex-wrap items-center  font-bold text-base text-gray-600">
                                        Skills:
                                    </div>
                                    <div class="mt-2 flex flex-wrap items-center justify-items-center px-3 font-semibold text-base text-gray-600">
                                        <span class=" ml-2 mt-1 bg-lime-100 text-lime-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-lime-200 cursor-pointer">Communication</span>
                                        <span class="ml-2 mt-1 bg-sky-100 text-sky-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-sky-200 cursor-pointer">Management</span>

                                    </div>
                                </div>

                                <p class="mt-4 text-gray-600 example leading-relaxed text-base">
                                    Join us in maintaining our community garden. Help
                                    plant new vegetables and maintain existing beds.
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex esse autem accusamus iste dolore amet sint magni ad, quas et, ratione doloribus modi nam unde tempore officiis ea. Quod, quae?
                                </p>

                                <div class="mt-6 flex space-x-4">
                                    <a href="event_detail.php">
                                        <button
                                            onclick="window.location.href='/events/1'"
                                            class="bg-blue-600 basis-36 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200">
                                            View More
                                        </button></a>

                                    <button
                                        onclick="window.location.href='/events/1/apply'"
                                        class="bg-green-600 basis-36 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-200">
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="md:flex">
                            <div class="md:w-1/3">
                                <img
                                    class="h-48 w-full object-cover md:h-full"
                                    src="https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&amp;fit=crop&amp;q=80&amp;w=800"
                                    alt="Youth Mentorship Program" />
                            </div>
                            <div class="p-8 md:w-2/3 relative">
                                <div
                                    class="text-sm absolute top-0 right-0 bg-sky-600 rounded-sm px-4 py-2 text-white mt-3 mr-3 hover:bg-sky-800 hover:text-white transition duration-500 ease-in-out">
                                    Scheduled
                                </div>
                                <div
                                    class="uppercase tracking-wide text-sm text-blue-600 font-semibold">
                                    Youth Forward
                                    <span class=" ml-3 bg-gray-300 rounded-xl px-2 py-1 text-gray-500">10 days</span>
                                </div>
                                <h3 class="mt-1 text-2xl font-semibold text-gray-900">
                                    Youth Mentorship Program
                                </h3>

                                <div class="mt-4 flex items-center text-gray-600">
                                    <svg
                                        class="h-5 w-5 mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    2024-03-25 - 2024-06-25
                                </div>

                                <div class="mt-2 flex items-center text-gray-600">
                                    <svg
                                        class="h-5 w-5 mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    16:00 - 18:00
                                </div>

                                <div class="mt-2 flex items-center text-gray-600">
                                    <svg
                                        class="h-5 w-5 mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    City Youth Center
                                </div>

                                <div class="mt-2 flex items-center font-semibold text-base text-gray-600">
                                    <svg
                                        class="h-5 w-5 mr-2"
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
                                    Volunteer Needed: 0/10
                                </div>

                                <p class="mt-4 text-gray-600">
                                    Make a difference in a young person's life through our
                                    mentorship program.
                                </p>

                                <div class="mt-6 flex space-x-4">
                                    <button
                                        onclick="window.location.href='/events/2'"
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                        View More
                                    </button>
                                    <button
                                        onclick="window.location.href='/events/2/apply'"
                                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="md:flex">
                            <div class="md:w-1/3">
                                <img
                                    class="h-48 w-full object-cover md:h-full"
                                    src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&amp;fit=crop&amp;q=80&amp;w=800"
                                    alt="Food Bank Distribution" />
                            </div>
                            <div class="p-8 md:w-2/3 relative">
                                <div
                                    class="text-sm absolute top-0 right-0 bg-red-500 rounded-sm px-4 py-2 text-white mt-3 mr-3 hover:bg-red-800 hover:text-white transition duration-500 ease-in-out">
                                    Cancelled
                                </div>
                                <div
                                    class="uppercase tracking-wide text-sm text-blue-600 font-semibold">
                                    Food for All
                                    <span class=" ml-3 bg-gray-300 rounded-xl px-2 py-1 text-gray-500">10 days</span>
                                </div>
                                <h3 class="mt-1 text-2xl font-semibold text-gray-900">
                                    Food Bank Distribution
                                </h3>

                                <div class="mt-4 flex items-center text-gray-600">
                                    <svg
                                        class="h-5 w-5 mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    2024-03-22 - 2024-03-22
                                </div>

                                <div class="mt-2 flex items-center text-gray-600">
                                    <svg
                                        class="h-5 w-5 mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    08:00 - 12:00
                                </div>

                                <div class="mt-2 flex items-center text-gray-600">
                                    <svg
                                        class="h-5 w-5 mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Community Food Bank
                                </div>
                                <div class="mt-2 flex items-center font-semibold text-base text-gray-600">
                                    <svg
                                        class="h-5 w-5 mr-2"
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
                                    Volunteer Needed: 0/10
                                </div>

                                <p class="mt-4 text-gray-600">
                                    Help sort and distribute food to families in need at
                                    our local food bank.
                                </p>

                                <div class="mt-6 flex space-x-4">
                                    <button
                                        onclick="window.location.href='/events/3'"
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                        View More
                                    </button>
                                    <button
                                        onclick="window.location.href='/events/3/apply'"
                                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> -->



                </div>
            </div>
            <!-- End Of Event Listing -->
        </div>
        <!-- End Content -->





    </main>




    <!-- Footer -->
    <?php include('../layouts/footer.php'); ?>


    <!-- Read Less Read More -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js"></script> -->
    <script src="../../js/moreless.js">
    </script>
    <script>
        $(function() {
            $(".example").moreLess({
                moreLabel: "... Read more",
                lessLabel: "... Read less",
                moreClass: "read-more-link",
                lessClass: "read-less-link",
                wordsCount: 20,
            });
        });
    </script>
    <!-- Read Less Read More end -->


    <!--Show More and Show Less -->
    <script src="../../js/showMoreItems.min.js">
    </script>
    <script>
        $(document).ready(function() {

            $('.list1').showMoreItems({
                startNum: 3,
                afterNum: 3,
                moreText: 'Load More',
                original: true,
            });
        })
    </script>
    <!-- Show More and Show Less END -->




    <script>
        $(document).ready(function() {

            function initialize() {
                let all = "all";
                $.ajax({
                    url: "Backend/search_events.php", // Backend PHP script
                    method: "POST",
                    data: {
                        all: all
                    },
                    success: function(response) {
                        $("#events-list").html(response); // Show results
                        //  $("#events-list").html(""); // Clear results if input is empty
                    }
                });

            }
            initialize();
            $("#searchInput").on("keyup", function() {
                let query = $(this).val().trim();
                // alert(query);

                if (query.length > 0) {
                    $.ajax({
                        url: "Backend/search_events.php", // Backend PHP script
                        method: "POST",
                        data: {
                            search: query
                        },
                        success: function(response) {
                            $("#events-list").html(response); // Show results
                        }
                    });
                } else {
                    // let all = "all";
                    // $.ajax({
                    //     url: "Backend/search_events.php", // Backend PHP script
                    //     method: "POST",
                    //     data: {
                    //         all: all
                    //     },
                    //     success: function(response) {
                    //         $("#events-list").html(response); // Show results
                    //         //  $("#events-list").html(""); // Clear results if input is empty
                    //     }
                    // });
                    initialize();
                }
            });
        });
    </script>



    <!-- Filter and Cancel button js -->
    <script>
        $(document).ready(function() {

            function initialize() {
                let all = "all";
                $.ajax({
                    url: "Backend/search_events.php", // Backend PHP script
                    method: "POST",
                    data: {
                        all: all
                    },
                    success: function(response) {
                        $("#events-list").html(response); // Show results
                        //  $("#events-list").html(""); // Clear results if input is empty
                    }
                });

            }

            $("#filterBtn").click(function() {
                $("#filterMenu").toggleClass("hidden");
            });

            $("#closeFilter, #applyFilters").click(function() {
                $("#filterMenu").addClass("hidden");
            });

            $("#applyFilters").click(function() {
                // Here you would typically send the filter data to your backend
                // and update the event listing based on the response
                console.log("Filters applied");
            });

            $("#searchInput").on("input", function() {
                if ($(this).val().length > 0) {
                    $("#cancelSearch").show();
                } else {
                    $("#cancelSearch").hide();
                }
            });

            $("#cancelSearch").click(function() {
                $("#searchInput").val('');
                initialize();
                $(this).hide();
            });

            $("#searchBtn").click(function() {
                // Here you would typically send the search query to your backend
                // and update the event listing based on the response
                //console.log("Search performed");
            });
            $("#form1").submit(function(e) {

                // Check if the listener has already been added to prevent duplication
                const form = document.getElementById("form1");
                e.preventDefault(); // Prevent default form submission


            });
            
            $(document).on('click', '.apply_button', function(e) {
                let eventID = $(this).data("event");
                let userId = <?= $user_id; ?>;
                let volunteer_need = $(this).data("volunteer_needed");
                let button = $(this);
                e.preventDefault();

                // alert(userId);
                // alert(eventID);
                // alert(volunteer_need);

                if (volunteer_need > 0) {

                    $.ajax({
                        url: "Backend/Event_apply.php", // Backend PHP script
                        method: "POST",
                        data: {
                            user_id: userId,
                            event_id: eventID
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                // Show success message
                                //location.reload();
                                // Modify button appearance and disable it
                                button.attr('disabled', true);
                                button.html('<i class="bx bxs-bookmark-minus mr-4"></i>Applied');
                                button.addClass('bg-emerald-600').removeClass('hover:bg-green-700 hover:scale-105 duration-300 transition-all bg-green-600');
                                alert(response.message);
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error: " + status + " " + error);
                            alert("AJAX Error: " + status + " " + error);
                        }
                    });

                } else {
                    alert("Required Volunteer Count Reached!!");
                }
                // $(this).attr('disabled', true)
                // $(this).html('<i class="bx bxs-bookmark-minus mr-4"></i>Applied');
                // $(this).addClass('bg-emerald-600').removeClass('hover:bg-green-700 hover:scale-105 duration-300 transition-all bg-green-600');

            });


        });
    </script>

    <!-- Filter and Cancel button js end-->



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
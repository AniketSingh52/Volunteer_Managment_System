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

if ($type == "Organisation") {
    echo "<script>alert('You are not authorized to view this page.'); window.location.href='admin.php';</script>";
    exit;
}


$query = "SELECT status, COUNT(*) AS application_count FROM events_application WHERE volunteer_id = ? GROUP BY status";

// Prepare and execute the statement
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id); // "i" for integer
$stmt->execute();
$result = $stmt->get_result();

// Initialize variables
$pending = 0;
$accepted = 0;
$rejected = 0;

// Fetch the results and store in variables
while ($row = $result->fetch_assoc()) {
    switch ($row['status']) {
        case 'pending':
            $pending = $row['application_count'];
            break;
        case 'accepted':
            $accepted = $row['application_count'];
            break;
        case 'rejected':
            $rejected = $row['application_count'];
            break;
    }
}

$sql = "SELECT e.*, ea.status as applicunt_status, ea.date as date_of_application
                    FROM events e
                    JOIN events_application ea ON e.event_id = ea.event_id
                    WHERE ea.volunteer_id = ? AND ea.status='pending' ORDER BY ea.date DESC
                    ";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result2 = $stmt->get_result();
if ($result2->num_rows > 0) {
    $availabe = 1;
} else {
    $availabe = 0;
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
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900">My Participation</h1>
                    <button onclick="window.location.href='search_event.php'"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Apply For Event
                    </button>
                </div>

                <!-- Tabs -->
                <div class="bg-white rounded-xl shadow-sm mb-8">
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px">
                            <button data-status="pending" class="w-1/3 py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span>Pending Application</span>
                                <span class="ml-2 bg-blue-100 text-blue-600 py-0.5 px-2.5 rounded-full text-xs font-medium"><?= $pending ?></span>
                            </button>
                            <button data-status="accepted" class="w-1/3 py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Accepted Application</span>
                                <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs font-medium"><?= $accepted ?></span>
                            </button>
                            <button data-status="rejected" class="w-1/3 py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center justify-center space-x-2">
                                <i class='bx bx-calendar-x text-xl'></i>
                                <span>Rejected Application</span>
                                <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs font-medium"><?= $rejected ?></span>
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

                            $event_name = $row['event_name'];
                            $from_date = date('jS M y', strtotime($row['from_date']));
                            $to_date = date('jS M y', strtotime($row['to_date']));
                            $from_time = $row['from_time'];
                            $to_time = $row['to_time'];

                            $from_time = date("h:i A", strtotime($from_time));
                            $to_time = date("h:i A", strtotime($to_time));

                            $description = $row['description'];
                            $location = $row['location'];
                            $volunteer_needed = $row['volunteers_needed'];
                            $event_id = $row['event_id'];
                            $organization_id = $row['organization_id'];
                            $event_image = $row['poster'];
                            $event_image = preg_replace('/^\.\.\//', '', $event_image);
                            $date_of_creation = $row['date_of_creation'];
                            $status = $row['status'];
                            $applicunt_status = $row['applicunt_status'];
                            $application_date = date('jS M y', strtotime($row['date_of_application']));


                            switch ($applicunt_status) {
                                case 'pending':
                                    $applicunt_status = 'Pending';
                                    $applicunt_status_style = "bg-amber-200 text-amber-800";
                                    break;
                                case 'rejected':
                                    $applicunt_status = 'Rejected';
                                    $applicunt_status_style = "bg-red-200 text-red-800";
                                    break;
                                case 'accepted':
                                    $applicunt_status = 'Accepted';
                                    $applicunt_status_style = "bg-green-200 text-green-800";
                                    break;
                            }

                            //'Ongoing','Scheduled','Completed','Cancelled'
                            if ($status == "Ongoing") {
                                $status_style = " bg-green-500 hover:bg-green-800 ";
                            } elseif ($status == "Scheduled") {
                                $status_style = " bg-sky-500 hover:bg-sky-800 ";
                            } elseif ($status == "Completed") {
                                $status_style = " bg-indigo-500 hover:bg-indigo-800 ";
                            } else {
                                $status_style = " bg-red-500 hover:bg-red-800 ";
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

                            $sql = "SELECT * FROM `user` WHERE user_id=?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $organization_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $organization_name = $row['name'];
                            $organization_email = $row['email'];


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
                                                <div
                                                    class="uppercase mb-2  tracking-wide text-sm text-blue-600 font-semibold">
                                                    <?= $organization_name ?>
                                                    <span class=" ml-3 text-gray-700 border-2 border-gray-200 shadow-sm rounded-xl px-2 py-1 bg-gray-200"><?= $application_date ?></span>
                                                </div>
                                                <h3 class="text-xl font-bold text-gray-900"><?= $event_name ?>


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
                                                    <div class="mt-2 text-base flex items-center text-gray-600">
                                                        <svg
                                                            class="h-5 w-5 mr-2 text-sky-500"
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
                                                        <?= $location ?>
                                                    </div>
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
                                                        Volunteer Needed: <?= $accepted_count ?>/<?= $volunteer_needed ?>
                                                    </div>

                                                    <div class=" flex">
                                                        <div class="flex mt-2 flex-wrap items-center  font-bold text-base text-gray-600">
                                                            Tags:
                                                        </div>
                                                        <div class="mt-2 flex flex-wrap items-center justify-items-center px-3 font-semibold text-base text-gray-600">
                                                            <?php

                                                            //SELECT name FROM `causes` WHERE cause_id in (SELECT cause_id FROM `event_has_causes` WHERE event_id=6);
                                                            $sql = "SELECT name FROM `causes` WHERE cause_id in (SELECT cause_id FROM `event_has_causes` WHERE event_id=?)";
                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->bind_param("i", $event_id);
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
                                                            <span class=" ml-2 mt-1 ' . $style . '  rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300  cursor-pointer">' . $cause_name . '</span>
                                                            ';
                                                                }
                                                            } else {
                                                                echo '
                                                            <span class=" ml-2 mt-1 bg-orange-100 text-orange-800 hover:bg-orange-200  rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300  cursor-pointer"> No Tags</span>
                                                            ';
                                                            }
                                                            ?>


                                                        </div>
                                                    </div>


                                                    <div class=" flex mt-2">
                                                        <div class="flex mt-2 flex-wrap items-center  font-bold text-base text-gray-600">
                                                            Skills:
                                                        </div>
                                                        <div class="mt-2 flex flex-wrap items-center justify-items-center px-3 font-semibold text-base text-gray-600">
                                                            <?php

                                                            //SELECT name FROM `causes` WHERE cause_id in (SELECT cause_id FROM `event_has_causes` WHERE event_id=6);
                                                            $sql = "SELECT skill_name FROM `skill` WHERE skill_id in (SELECT skill_id FROM `event_req_skill` WHERE event_id=?)";
                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->bind_param("i", $event_id);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            $index2 = 0;
                                                            $styles2 = [
                                                                "bg-lime-100 text-lime-800 hover:bg-lime-200",
                                                                "bg-sky-100 text-sky-800 hover:bg-sky-200 "
                                                            ];

                                                            if ($result->num_rows > 0) {

                                                                while ($row = $result->fetch_assoc()) {
                                                                    $skill_name = $row['skill_name'];
                                                                    $style2 = $styles2[$index2 % 2];
                                                                    $index2++;
                                                                    echo '
                                                            <span class=" ml-2 mt-1 ' . $style2 . '  rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300  cursor-pointer">' . $skill_name . '</span>
                                                            ';
                                                                }
                                                            } else {
                                                                echo '
                                                            <span class=" ml-2 mt-1 bg-orange-100 text-orange-800 hover:bg-orange-200  rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300  cursor-pointer"> No Skill</span>
                                                            ';
                                                            }

                                                            ?>




                                                        </div>
                                                    </div>
                                                    <p class="mt-4 text-gray-600 example leading-relaxed text-base">
                                                        <?= $description ?>
                                                    </p>


                                                </div>
                                            </div>


                                            <div class="flex space-x-2">

                                                <span class="inline-flex items-center px-4 py-2 rounded-full hover:scale-105 transition-all text-base font-semibold <?= $applicunt_status_style ?>">
                                                    <?= $applicunt_status ?>
                                                </span>
                                            </div>
                                        </div>


                                        <div class="mt-6 flex justify-end space-x-4">
                                            <button onclick="window.location.href='event_detail.php?id=<?= base64_encode($event_id) ?>'"
                                                class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                View Details
                                            </button>
                                            <button data-event_id="<?= $event_id ?>" class="delete-application flex text-center px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-700 hover:scale-105 transition-all duration-300 " data-event-id="<?= $event_id ?>">
                                                Cancel
                                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    <?php
                        }
                    } else {

                        echo "
                            <h1 class=' text-2xl font-semibold'>No Application Found</h1>
                            ";
                    }
                    ?>

                </div>
            </div>
            <!--Show More and Show Less -->
            <script src="../../js/moreless.js">
            </script>
            <script>
                $(document).ready(function() {

                    $(function() {
                        $(".example").moreLess({
                            moreLabel: "... Read more",
                            lessLabel: "... Read less",
                            moreClass: "read-more-link",
                            lessClass: "read-less-link",
                            wordsCount: 20,
                        });
                    });

                    // Tab switching functionality
                    $(document).on('click', 'nav button', function() {
                        $('nav button').removeClass('border-blue-500 text-blue-600').addClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');

                        // Add active classes to clicked tab
                        $(this).addClass('border-blue-500 text-blue-600').removeClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');
                        let Type = $(this).data("status");
                        // alert(Type);
                        var applicuntId = <?= $user_id ?>


                        $.ajax({
                            url: "Backend/my_participation.php", // Backend PHP script
                            method: "POST",
                            data: {
                                type: Type,
                                user_id: applicuntId
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


                    $(document).on('click', '.delete-application', function(e) {
                        e.preventDefault();
                        let eventId = $(this).data("event_id");
                        let userId=<?= $user_id ?>;
                        // alert(userId);
                        // alert(eventId);

                        if (confirm("Are you sure you want to delete this event?")) {
                            $.ajax({
                                url: "Backend/delete_application.php",
                                type: "POST",
                                data: {
                                    event_id: eventId,
                                    user_id:userId
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


                    // $(".delete-event").click(function(e) {
                    // e.preventDefault();
                    // let eventId = $(this).data("event-id");
                    // //alert(eventId);

                    // if (confirm("Are you sure you want to delete this event?")) {
                    //     $.ajax({
                    //         url: "Backend/delete_event.php",
                    //         type: "POST",
                    //         data: {
                    //             event_id: eventId
                    //         },
                    //         dataType: "json", // Expect JSON response
                    //         success: function(response) {
                    //             if (response.status === 'success') {
                    //                 alert(response.message); // Show success message
                    //                 location.reload(); // Reload the page after deletion
                    //             } else {
                    //                 alert(response.message); // Show error message
                    //             }
                    //         },
                    //         error: function(xhr, status, error) {
                    //             console.log("AJAX Error: " + status + " " + error);
                    //             console.log("Server Response: " + xhr.responseText);
                    //         }
                    //     });
                    // }
                    // });




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
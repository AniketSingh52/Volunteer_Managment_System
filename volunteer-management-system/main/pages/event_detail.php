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



//GET THE EVENT ID FOR DETAILS FETCHING

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $event_id = base64_decode($_GET['id']);

    // echo "
    // <script>
    // alert('$event_id');
    // </script>
    // ";

    // SQL query to GET EVENT DETAILS
    $sql = "SELECT * FROM `events`
            WHERE event_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {

        if ($row = $result->fetch_assoc()) {

            $event_name = $row['event_name'];

            //Convert Date to Human Readable Format
            $from_date = date('jS M y', strtotime($row['from_date']));
            $to_date = date('jS M y', strtotime($row['to_date']));

            $from_time = $row['from_time'];
            $to_time = $row['to_time'];


            //Convert 24 Hour format to 12 Hour format
            $from_time = date("h:i A", strtotime($from_time));
            $to_time = date("h:i A", strtotime($to_time));

            $description = $row['description'];
            $location = $row['location'];
            $volunteer_needed = $row['volunteers_needed'];

            $organization_id = $row['organization_id'];
            $max_applications = $row['maximum_application'];
            $event_image = $row['poster'];
            $event_image = preg_replace('/^\.\.\//', '', $event_image);

            $date_of_creation = $row['date_of_creation'];
            $status = $row['status'];

            //'Ongoing','Scheduled','Completed','Cancelled'
            if ($status == "Ongoing") {
                $status_style = " bg-green-500/90 hover:bg-green-800/90  duration-300 transition-all ";
            } elseif ($status == "Scheduled") {
                $status_style = " bg-sky-500/90 hover:bg-sky-800/90  duration-300 transition-all ";
            } elseif ($status == "Completed") {
                $status_style = " bg-indigo-500/90 hover:bg-indigo-800/90  duration-300 transition-all ";
            } else {
                $status_style = " bg-red-500 hover:bg-red-800/90  duration-300 transition-all ";
            }

            //Calculate Days Ago
            $creation_date = new DateTime($from_date);
            $end_date = new DateTime($to_date);
            $today = new DateTime();
            $diff = $creation_date->diff($today);

            if ($creation_date > $today) {
                $days_ago = "{$diff->days} days remaining";
            } elseif ($creation_date < $today) {
                if ($today < $end_date) {
                    $days_ago = "Ongoing";
                } else {
                    $days_ago = "Completed";
                }
            } else {
                $days_ago = "Started";
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

            //Fetch Organizator Details using Organization ID
            $sql = "SELECT * FROM `user` WHERE user_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $organization_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $organization_name = $row['name'];
            $profile2 = $row['profile_picture'];
            $user_address = $row['address'];
            $user_email = $row['email'];
            $user_doe = date('jS M Y', strtotime($row['DOB/DOE']));
            $profile2 = preg_replace('/^\.\.\//', '', $profile2);

            //Fetch Organization Type
            $sql = "SELECT type_name FROM `organization_type` WHERE type_id in (SELECT type_id FROM `organization_belongs_type` WHERE user_id=?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $organization_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $organization_type = $row['type_name'];

            $notice_updates = 0; //Notices flag
        }
    }
} else {
    echo "<script>alert('Select an Event.'); window.location.href='search_event.php';</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Management</title>
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

        /* Style scrollbar track */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Style scrollbar thumb */
        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        /* Style scrollbar on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.7);
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
            <button onclick="history.back()" class="flex items-center gap-1  text-gray-700 font-semibold rounded-lg hover:text-blue-400 transition-all duration-200 px-2 text-xl hover:scale-105">
                <i class=" bx bx-arrow-back text-2xl"></i>Back
            </button>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <!-- Event Header -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-12">
                    <div class="relative h-[500px]">
                        <img
                            src="<?php echo htmlspecialchars($event_image) ?>"
                            alt="<?php echo htmlspecialchars($event_name) ?>"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-12 text-white max-w-3xl">
                            <div class="flex items-center space-x-6 mb-6">
                                <img
                                    src="<?php echo htmlspecialchars($profile2) ?>"
                                    alt="Organizer"
                                    class="w-20 h-20 rounded-full border-4 border-white object-cover shadow-xl">
                                <div>
                                    
                                        <h3 class="text-xl font-semibold mb-1"><?php echo htmlspecialchars($organization_name) ?></h3>
                                
                                    <p class="text-base opacity-90"><?php echo htmlspecialchars($organization_type) ?></p>
                                </div>
                            </div>
                            <h1 class="text-5xl font-bold mb-4 leading-tight"><?php echo htmlspecialchars($event_name) ?></h1>
                            <div class="flex items-center space-x-4">
                                <span class=" <?php echo htmlspecialchars($status_style) ?>  px-4 py-1.5 rounded-full text-sm font-semibold shadow-lg"><?php echo htmlspecialchars($status) ?></span>
                                <span class="bg-white/20 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-medium"><?php echo htmlspecialchars($days_ago) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Content -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-12">
                        <!-- Event Details -->
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <h2 class="text-3xl font-bold mb-8">Event Details</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                                <div class="flex items-center space-x-4 p-4 rounded-xl bg-gray-50">
                                    <div class="p-3 bg-blue-100 rounded-lg">
                                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 font-medium">Date</p>
                                        <p class="text-gray-700 font-semibold"><?php echo htmlspecialchars($from_date) ?> • <?php echo htmlspecialchars($to_date) ?></p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-4 p-4 rounded-xl bg-gray-50">
                                    <div class="p-3 bg-purple-100 rounded-lg">
                                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 font-medium">Time</p>
                                        <p class="text-gray-700 font-semibold"><?php echo htmlspecialchars($from_time) ?> - <?php echo htmlspecialchars($to_time) ?></p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-4 p-4 rounded-xl bg-gray-50">
                                    <div class="p-3 bg-emerald-100 rounded-lg">
                                        <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 font-medium">Location</p>
                                        <p class="text-gray-700 font-semibold"><?php echo htmlspecialchars($location) ?></p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-4 p-4 rounded-xl bg-gray-50">
                                    <div class="p-3 bg-amber-100 rounded-lg">
                                        <svg class="h-6 w-6 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 font-medium">Volunteers</p>
                                        <p class="text-green-500 font-semibold"><?= $accepted_count ?>/<?php echo htmlspecialchars($volunteer_needed) ?> Spots</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-10">
                                <div>
                                    <h3 class="text-xl font-bold mb-4 text-gray-900">About This Event</h3>
                                    <p class="text-gray-600 leading-relaxed text-lg">
                                        <?php echo htmlspecialchars($description) ?>
                                    </p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-bold mb-4 text-gray-900">Tags</h3>
                                    <div class="flex flex-wrap gap-3">

                                        <!-- Populating the Tag based on event_id -->
                                        <?php
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
                                                <span class="' . $style . '  rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 cursor-pointer">' . $cause_name . '</span>
                                                ';
                                            }
                                        } else {
                                            echo '
                                                <span class="rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 cursor-pointer"> No Tags</span>
                                                ';
                                        }
                                        ?>

                                        <!-- <span class="bg-amber-100 text-amber-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-amber-200 cursor-pointer">Animal Rescue</span>
                                        <span class="bg-violet-100 text-violet-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-violet-200 cursor-pointer">Social Awareness</span>
                                        <span class="bg-rose-100 text-rose-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-rose-200 cursor-pointer">Clean-Up Drives</span>
                                        <span class="bg-emerald-100 text-emerald-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-emerald-200 cursor-pointer">Education Tour</span>
                                        <span class="bg-fuchsia-100 text-fuchsia-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-fuchsia-200 cursor-pointer">Donation Collection</span> -->
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-xl font-bold mb-4 text-gray-900">Required Skills</h3>
                                    <div class="flex flex-wrap gap-3">

                                        <!-- Populating the skill required based on event_id -->
                                        <?php
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
                                                <span class=" ' . $style2 . '   rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 cursor-pointer">' . $skill_name . '</span>
                                                 ';
                                            }
                                        } else {
                                            echo '
                                            <span class=" bg-orange-100 text-orange-800 hover:bg-orange-200  rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 cursor-pointer"> No Skill</span>
                                               ';
                                        }

                                        ?>
                                        <!-- <span class="bg-lime-100 text-lime-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-lime-200 cursor-pointer">Communication</span>
                                        <span class="bg-sky-100 text-sky-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-sky-200 cursor-pointer">Management</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Section -->
                        <!-- <div class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex items-center justify-between mb-8">
                                <h2 class="text-3xl font-bold">Reviews</h2>
                                <div class="flex items-center space-x-2">
                                    <span class="text-3xl font-bold text-gray-900">4.8</span>
                                    <div>
                                        <div class="flex text-yellow-400 text-sm">★★★★★</div>
                                        <span class="text-sm text-gray-500">128 reviews</span>
                                    </div>
                                </div>
                            </div>-->

                        <!-- Add Review -->
                        <!-- <div class="mb-10 border-b pb-10">
                            <h3 class="text-xl font-bold mb-6">Share Your Experience</h3>
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3">
                                    <button class="rating-star text-3xl text-gray-300 hover:text-yellow-400 transition-colors">★</button>
                                    <button class="rating-star text-3xl text-gray-300 hover:text-yellow-400 transition-colors">★</button>
                                    <button class="rating-star text-3xl text-gray-300 hover:text-yellow-400 transition-colors">★</button>
                                    <button class="rating-star text-3xl text-gray-300 hover:text-yellow-400 transition-colors">★</button>
                                    <button class="rating-star text-3xl text-gray-300 hover:text-yellow-400 transition-colors">★</button>
                                </div>
                                <textarea
                                    id="review-text"
                                    rows="4"
                                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700"
                                    placeholder="Share your experience with this event..."></textarea>
                                <button
                                    class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 
                         transition-colors duration-200 font-semibold text-lg">
                                    Submit Review
                                </button>
                            </div>
                        </div> -->

                        <!-- Review List -->
                        <!-- <div class="space-y-8">
                           
                            <div class="border-b pb-8">
                                <div class="flex items-start space-x-6">
                                    <img
                                        src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&q=80&w=150"
                                        alt="Reviewer"
                                        class="w-14 h-14 rounded-full object-cover border-2 border-gray-200">
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <h4 class="font-bold text-lg">John Doe</h4>
                                                <div class="flex text-yellow-400 text-base">★★★★★</div>
                                            </div>
                                            <span class="text-sm text-gray-500">2 days ago</span>
                                        </div>
                                        <p class="mt-3 text-gray-600 text-lg leading-relaxed">
                                            Amazing experience! The community was very welcoming and the work was meaningful.
                                            Would definitely volunteer again.
                                        </p>
                                    </div>
                                </div>
                            </div>

                     
                            <div class="border-b pb-8">
                                <div class="flex items-start space-x-6">
                                    <img
                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150"
                                        alt="Reviewer"
                                        class="w-14 h-14 rounded-full object-cover border-2 border-gray-200">
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <h4 class="font-bold text-lg">Jane Smith</h4>
                                                <div class="flex text-yellow-400 text-base">★★★★☆</div>
                                            </div>
                                            <span class="text-sm text-gray-500">1 week ago</span>
                                        </div>
                                        <p class="mt-3 text-gray-600 text-lg leading-relaxed">
                                            Great initiative! The garden looks much better now. The organizers were very helpful
                                            and provided all necessary tools.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->



                        <?php

                        $sql2 = "SELECT * FROM `events_application` WHERE event_id='$event_id' AND volunteer_id='$user_id'";
                        $checkResult2 = $conn->query($sql2);
                        if ($checkResult2->num_rows > 0) {
                            $row3 = $checkResult2->fetch_assoc();
                            if ($row3['status'] == 'accepted') {
                                $notice_updates = 1;
                            }
                        }


                        if ($notice_updates == 1) {
                            // Calculate the Total of the event
                            $sql = "SELECT  COUNT(*) AS Total FROM `event_has_notices` WHERE event_id=?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $event_id);
                            $stmt->execute();
                            $result4 = $stmt->get_result();
                            $row = $result4->fetch_assoc();
                            $notice_total = $row['Total'];




                            // Fetch reviews from the database based on date_time order
                            $sql = "SELECT e.notice, e.date, u.name, u.profile_picture, u.user_name,u.user_type,u.user_id AS ID FROM event_has_notices e
                                JOIN user u ON e.user_id = u.user_id
                                WHERE e.event_id = ?  ORDER BY e.date DESC";

                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $event_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $notices = $result->fetch_all(MYSQLI_ASSOC);


                        ?>

                            <!-- Notice Section -->
                            <div class="bg-white rounded-2xl shadow-lg p-8 ">
                                <div class="flex items-center justify-between mb-8">
                                    <h2 class="text-3xl font-bold">Notices & Updates</h2>
                                    <div class="flex items-center space-x-2 ">
                                        <div>
                                            <span class="text-lg font-semibold text-gray-800"><?= $notice_total ?> Notices</span>
                                        </div>
                                    </div>
                                </div>



                                <!-- Notice List -->
                                <div class="space-y-8 max-h-96 overflow-y-scroll overflow-x-hidden">

                                    <?php foreach ($notices as $notice) :

                                        // REVIEWER PROFILE PHOTO
                                        $card_style = ($notice['ID'] == $organization_id) ? " bg-green-50 " : "";

                                        $profile = preg_replace('/^\.\.\//', '', $notice['profile_picture']);
                                        $notice_type = ($notice['user_type'] == 'V') ? "Volunteer" : "Organisation";
                                        $notice_style = ($notice['user_type'] == 'V') ? "bg-indigo-100 text-indigo-800" : "bg-green-100 text-green-800";

                                    ?>

                                        <div class="border-b pb-8">
                                            <div class="flex <?= $card_style ?> rounded-lg px-3 items-start space-x-6">
                                                <img src="<?= $profile ?>" alt="<?= $notice['name'] ?>" class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                                                <div class="flex-1 ">
                                                    <div class="flex  items-start justify-between mb-2">
                                                        <div>
                                                            <h4 class="font-bold text-lg"><?= $notice['name'] ?>
                                                                <?php if ($card_style != "") {
                                                                    echo ' <span class=" ml-2  text-sm bg-red-100 text-red-800  rounded-xl px-2 py-1">Organizer</span>';
                                                                } else {
                                                                    echo '
                                                                <span class=" ml-2  text-sm ' . $notice_style . ' rounded-xl px-2 py-1">' . $notice_type . '</span>
                                                                ';
                                                                }
                                                                ?>
                                                                <!-- <span class=" ml-2  text-sm <?= $notice_style ?>   rounded-xl px-2 py-1"><?= $notice_type ?></span> -->
                                                            </h4>

                                                            <span class=" text-sm font-mono"> @<?= $notice['user_name'] ?></span>
                                                        </div>
                                                        <span class="text-sm text-gray-500"><?= date('jS M Y', strtotime($notice['date'])) ?></span>
                                                    </div>
                                                    <p class="mt-3 text-gray-600 text-lg leading-relaxed"><?= $notice['notice'] ?></p>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach; ?>

                                </div>

                                <!-- Add Notice-->
                                <div class="mb-6  mt-6 border-b pb-6">
                                    <h3 class="text-xl font-bold mb-6">Share Your Words Here!!</h3>
                                    <form id="notice">
                                        <div class="space-y-6">

                                            <textarea rows="2" id="notice_text" class="w-full px-4 py-3 border rounded-xl text-gray-700" placeholder="Share your experience..."></textarea>
                                            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 transition duration-200 font-semibold text-lg">
                                                Sent
                                            </button>
                                        </div>
                                    </form>
                                </div>


                            </div>


                            <script>
                                $(document).ready(function() {

                                    $("#notice").submit(function(e) {
                                        e.preventDefault();
                                        let noticeText = $("#notice_text").val();
                                        let eventId = <?= $event_id ?>;
                                        let userId = <?= $user_id ?>;
                                        //alert(noticeText);

                                        if (noticeText.trim() == "") {
                                            alert("Please select a rating and enter a review.");
                                            return;

                                        }

                                        $.ajax({
                                            url: "Backend/add_notice.php",
                                            type: "POST",
                                            data: {
                                                event_id: eventId,
                                                user_id: userId,
                                                notice_text: noticeText
                                            },
                                            success: function(response) {

                                                alert("Notice added successfully!");
                                                location.reload();

                                            },
                                            error: function() {
                                                alert("Failed to add Notice.");
                                            }
                                        });
                                    });

                                });
                            </script>


                        <?php } ?>



                        <?php

                        // Calculate the average rating of the event
                        $sql = "SELECT  AVG(rating) AS average FROM `feedback_rating` WHERE event_id=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $event_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $average = number_format($row['average'], 1);
                        $star = round($average);



                        // Fetch reviews from the database based on date_time order
                        $sql = "SELECT r.description, r.date_time, r.rating, u.name, u.profile_picture, u.user_name,u.user_type
                                 FROM feedback_rating r
                                JOIN user u ON r.volunteer_id = u.user_id
                                WHERE r.event_id = ?  ORDER BY `date_time` DESC";

                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $event_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $reviews = $result->fetch_all(MYSQLI_ASSOC);



                        ?>

                        <!-- Reviews Section -->
                        <div class="bg-white rounded-2xl shadow-lg p-8 ">
                            <div class="flex items-center justify-between mb-8">
                                <h2 class="text-3xl font-bold">Reviews</h2>
                                <div class="flex items-center space-x-2 review_info">
                                    <span class="text-3xl font-bold text-gray-900"><?= $average ?></span>
                                    <div>

                                        <div class="flex text-yellow-400 text-sm"><?= str_repeat("★", $star) . str_repeat("☆", 5 - $star) ?></div>
                                        <span class="text-sm text-gray-500"><?= count($reviews) ?> reviews</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Add Review -->
                            <div class="mb-10 border-b pb-10">
                                <h3 class="text-xl font-bold mb-6">Share Your Experience</h3>
                                <form id="reviewForm">
                                    <div class="space-y-6">
                                        <div class="flex items-center space-x-3">

                                            <!-- USER RATING STAR -->
                                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                <button type="button" class="rating-star text-3xl text-gray-300 hover:text-yellow-400 transition-colors" data-value="<?= $i ?>">★</button>
                                            <?php endfor; ?>

                                        </div>

                                        <!-- A hidden field to manage the rating -->
                                        <input type="hidden" name="rating" id="rating" value="0">

                                        <textarea name="review_text" id="review-text" rows="4" class="w-full px-4 py-3 border rounded-xl text-gray-700" placeholder="Share your experience..."></textarea>
                                        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 transition duration-200 font-semibold text-lg">
                                            Submit Review
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Review List -->
                            <div class="space-y-8 review_list">
                                <?php foreach ($reviews as $review) :

                                    // REVIEWER PROFILE PHOTO
                                    $profile = preg_replace('/^\.\.\//', '', $review['profile_picture']);
                                    $rev_type = ($review['user_type'] == 'V') ? "Volunteer" : "Organisation";
                                    $rev_style = ($review['user_type'] == 'V') ? "bg-indigo-100 text-indigo-800" : "bg-green-100 text-green-800";

                                ?>

                                    <div class="border-b pb-8">
                                        <div class="flex items-start space-x-6">
                                            <img src="<?= $profile ?>" alt="Reviewer" class=" w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                                            <div class="flex-1">
                                                <div class="flex items-start justify-between mb-2">
                                                    <div>
                                                        <h4 class="font-bold text-lg"><?= $review['name'] ?>
                                                            <span class=" ml-2  text-sm <?= $rev_style ?> hover:bg-orange-200  rounded-xl px-2 py-1"><?= $rev_type ?></span>
                                                        </h4>
                                                        <span class=" text-sm font-mono">@<?= $review['user_name'] ?></span>
                                                        <div class="flex text-yellow-400 text-base">
                                                            <?= str_repeat("★", $review['rating']) . str_repeat("☆", 5 - $review['rating']) ?>
                                                        </div>
                                                    </div>
                                                    <span class="text-sm text-gray-500"><?= date('jS M Y', strtotime($review['date_time'])) ?></span>
                                                </div>
                                                <p class="mt-2 text-gray-600 text-lg leading-relaxed"><?= $review['description'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-8">
                        <!-- Action Card -->
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex flex-col space-y-4">

                                <?php
                                //if organiser is equal to the logged in user then thebuser is the creator of event
                                if ($organization_id == $user_id) {
                                    echo '
                                <button onclick="window.location.href=\'edit_event.php?id=' . base64_encode($event_id) . '\'" 
                                class="w-full bg-green-600 text-white px-8 py-4 rounded-xl hover:bg-green-700 transition-all duration-200 font-bold text-lg hover:shadow-lg transform hover:-translate-y-0.5">
                                Edit Event
                                </button>';

                                    echo '
                                 <button onclick="window.location.href=\'Event_Applications.php?id=' . base64_encode($event_id) . '\'"
                                    class="w-full bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 
                                    transition-all duration-200 font-bold text-lg hover:shadow-lg transform hover:-translate-y-0.5">
                                  View Applicants
                                </button>
                                
                                
                                ';
                                } elseif ($type == "Organisation") {
                                    echo '
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=' . $user_email . '&su=Inquiry about the Event&body=Hello, I am interested in your event and would like to know more."
                        target="_blank"
                        class="w-full bg-blue-600 text-white text-center px-8 py-4 rounded-xl hover:bg-blue-700  
                                transition-all duration-200 font-bold text-lg hover:shadow-lg transform hover:-translate-y-0.5">
                            Contact Organizer
                        </a>       
                            ';
                                } else {

                                    $sql2 = "SELECT * FROM `events_application` WHERE event_id='$event_id' AND volunteer_id='$user_id'";
                                    $checkResult2 = $conn->query($sql2);
                                    if ($checkResult2->num_rows > 0) {
                                        $row3 = $checkResult2->fetch_assoc();
                                        if ($row3['status'] == 'accepted') {
                                            $notice_updates = 1;
                                        }

                                        echo '
                                <button disabled 
                                class="w-full  bg-emerald-500 text-white px-8 py-4 rounded-xl font-bold text-lg ">
                                <i class="bx bxs-bookmark-minus mr-4"></i>Applied
                                </button>';
                                        echo '
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=' . $user_email . '&su=Inquiry about the Event&body=Hello, I am interested in your event and would like to know more."
                        target="_blank"
                        class="w-full bg-blue-600 text-white text-center px-8 py-4 rounded-xl hover:bg-blue-700  
                                transition-all duration-200 font-bold text-lg hover:shadow-lg transform hover:-translate-y-0.5">
                            Contact Organizer
                        </a>       
                            ';
                                    } else {

                                        echo '
                                <button data-event="' . $event_id . '" data-volunteer_needed="' . $volunteer_needed - $accepted_count . '" data-max_needed="' . $max_applications - $total_applications . '"
                                class=" apply_button w-full bg-green-600 text-white px-8 py-4 rounded-xl hover:bg-green-700 transition-all duration-200 font-bold text-lg hover:shadow-lg transform hover:-translate-y-0.5">
                                Apply Now
                                </button>';

                                        echo '
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=' . $user_email . '&su=Inquiry about the Event&body=Hello, I am interested in your event and would like to know more."
                        target="_blank"
                        class="w-full bg-blue-600 text-white text-center px-8 py-4 rounded-xl hover:bg-blue-700  
                                transition-all duration-200 font-bold text-lg hover:shadow-lg transform hover:-translate-y-0.5">
                            Contact Organizer
                        </a>       
                            ';
                                        //         echo '
                                        //  <button onclick="window.location.href=\'profile.php?id=' . base64_encode($organization_id) . '\'"
                                        //     class="w-full bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 
                                        //     transition-all duration-200 font-bold text-lg hover:shadow-lg transform hover:-translate-y-0.5">
                                        //    Contact Organizer
                                        // </button>

                                        // ';

                                    }
                                }

                                ?>
                                <!-- <button
                                    class="w-full bg-green-600 text-white px-8 py-4 rounded-xl hover:bg-green-700 
                       transition-all duration-200 font-bold text-lg hover:shadow-lg transform hover:-translate-y-0.5">
                                    Apply Now
                                </button>
                                <button
                                    class="w-full bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 
                       transition-all duration-200 font-bold text-lg hover:shadow-lg transform hover:-translate-y-0.5">
                                    Contact Organizer
                                </button> -->
                            </div>
                        </div>

                        <!-- Organization Card -->
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <h3 class="text-2xl font-bold mb-6">About the Organizer</h3>
                            <div class="flex items-center space-x-4 mb-6">
                                <!-- Organizer photo,name and type -->
                                <img
                                    src="<?= $profile2 ?>"
                                    alt="Organizer"
                                    class="w-20 h-20 rounded-full object-cover border-4 border-gray-100 shadow-md">
                                <div>
                                    <h4 class="text-lg font-bold"><?= $organization_name ?></h4>
                                    <p class="text-gray-600"><?= $organization_type ?></p>
                                </div>
                            </div>

                            <!-- Organizer paragraph -->
                            <p class="text-gray-600 text-lg leading-relaxed mb-6">
                                <?= $organization_name ?> is a <?= $organization_type ?> which works for community engagement.
                                We organize various events to promote volunteer participation.
                            </p>

                            <!-- date of establishment -->
                            <div class="flex items-center space-x-4 p-4 rounded-xl bg-gray-50 mb-2">
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 font-medium">Date Of establishment</p>
                                    <p class="text-gray-700 font-semibold"><?= $user_doe ?> </p>
                                </div>
                            </div>

                            <!-- email of organizer -->
                            <div class="flex items-center space-x-4 p-4 rounded-xl bg-gray-50 mb-2">
                                <div class="p-3 bg-violet-100 rounded-lg ">
                                    <i class='bx bx-at text-2xl text-violet-600'></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 font-medium">Email</p>
                                    <p class="text-gray-700 font-semibold"><?= $user_email ?></p>
                                </div>
                            </div>

                            <!-- address of organizer -->
                            <div class="flex items-center space-x-4 p-4 rounded-xl bg-gray-50 mb-3">
                                <div class="p-3 bg-emerald-100 rounded-lg">
                                    <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 font-medium">Address</p>
                                    <p class="text-gray-700 font-semibold"><?= $user_address ?></p>
                                </div>
                            </div>

                            <!-- View organizer button -->
                            <button onclick="window.location.href='profile2.php?id=<?= base64_encode($organization_id) ?>'"
                                class="w-full border-2 border-gray-200 text-gray-700 px-8 py-3 rounded-xl 
                     hover:bg-gray-50 transition-all duration-200 font-semibold text-lg
                     hover:border-gray-300 hover:shadow-md">
                                View Profile
                            </button>
                        </div>

                        <!-- Share Card -->
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <h3 class="text-2xl font-bold mb-6 text-center"><i class='bx bxs-share-alt mr-2'></i> Share Event</h3>



                            <div class="flex flex-col gap-4 max-w-md mx-auto">
                                <button id="copyLink" class="bg-gray-600 text-white px-4 py-3 rounded-xl hover:bg-gray-700 transition-all duration-200 font-semibold hover:shadow-lg transform hover:-translate-y-0.5">
                                    <i class='bx bx-link mr-3 text-2xl'></i> Copy Link
                                </button>
                                <button id="facebookShare" class="share-btn bg-[#1877F2] text-white px-4 py-3 rounded-xl hover:bg-[#1864D9] transition-all duration-200 font-semibold hover:shadow-lg transform hover:-translate-y-0.5">
                                    <i class='bx bxl-facebook mr-3 text-2xl'></i> Facebook
                                </button>
                                <button id="twitterShare" class="share-btn bg-[#1DA1F2] text-white px-4 py-3 rounded-xl hover:bg-[#1A8CD8] transition-all duration-200 font-semibold hover:shadow-lg transform hover:-translate-y-0.5">
                                    <i class='bx bxl-twitter mr-3 text-2xl'></i> Twitter
                                </button>
                                <button id="whatsappShare" class="share-btn bg-[#25D366] text-white px-4 py-3 rounded-xl hover:bg-[#22BF5B] transition-all duration-200 font-semibold hover:shadow-lg transform hover:-translate-y-0.5">
                                    <i class='bx bxl-whatsapp mr-3 text-2xl'></i> WhatsApp
                                </button>
                            </div>
                        </div>



                    </div>
                </div>
            </div>




        </div>
        <!-- End Content -->

    </main>




    <!-- Rating Js -->
    <!-- <script>
        $(document).ready(function() {
            // Handle star rating
            $('.rating-star').hover(
                function() {
                    $(this).prevAll().addBack().addClass('text-yellow-400').removeClass('text-gray-300');
                },
                function() {
                    if (!$(this).hasClass('selected')) {
                        $(this).prevAll().addBack().addClass('text-gray-300').removeClass('text-yellow-400');
                    }
                }
            );

            $('.rating-star').click(function() {
                $('.rating-star').removeClass('selected text-yellow-400').addClass('text-gray-300');
                $(this).prevAll().addBack().addClass('selected text-yellow-400').removeClass('text-gray-300');
            });
        });
    </script> -->


    <!-- AJAX Script for Submitting Reviews -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let eventId = "<?= $event_id ?>"; // Replace with dynamic PHP variable
            let eventUrl = window.location.href; // Gets the current event page URL

            // Facebook Share
            document.getElementById("facebookShare").addEventListener("click", function() {
                let facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(eventUrl)}`;
                window.open(facebookUrl, "_blank");
            });

            // Twitter Share
            document.getElementById("twitterShare").addEventListener("click", function() {
                let twitterUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(eventUrl)}&text=Check%20out%20this%20event!`;
                window.open(twitterUrl, "_blank");
            });

            // WhatsApp Share
            document.getElementById("whatsappShare").addEventListener("click", function() {
                let whatsappUrl = `https://api.whatsapp.com/send?text=Check%20out%20this%20event!%20${encodeURIComponent(eventUrl)}`;
                window.open(whatsappUrl, "_blank");
            });

            document.getElementById("copyLink").addEventListener("click", function() {
                navigator.clipboard.writeText(eventUrl).then(() => {
                    alert("Event link copied to clipboard!");
                });
            });

        });



        $(document).ready(function() {
            let selectedRating = 0;

            $(".rating-star").hover(
                function() {
                    $(this).prevAll().addBack().addClass("text-yellow-400").removeClass("text-gray-300");
                },
                function() {
                    if (!$(this).hasClass("selected")) {
                        $(this).prevAll().addBack().addClass("text-gray-300").removeClass("text-yellow-400");
                    }
                }
            );

            $(".rating-star").click(function() {
                $(".rating-star").removeClass("selected text-yellow-400").addClass("text-gray-300");
                $(this).prevAll().addBack().addClass("selected text-yellow-400").removeClass("text-gray-300");
                selectedRating = $(this).data("value");
                $("#rating").val(selectedRating);
            });

            // Handle AJAX form submission
            $(document).on('click', '.apply_button', function(e) {
                let eventID = $(this).data("event");
                let userId = <?= $user_id; ?>;
                let volunteer_need = $(this).data("volunteer_needed");
                let max_applications = $(this).data("max_needed");
                let button = $(this);
                e.preventDefault();

                // alert(userId);
                // alert(eventID);
                // alert(volunteer_need);

                if (volunteer_need > 0) {

                    if (max_applications > 0) {
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
                        alert("Maximum Application Limit Reached!!");
                    }


                } else {
                    alert("Required Volunteer Count Reached!!");
                }
                // $(this).attr('disabled', true)
                // $(this).html('<i class="bx bxs-bookmark-minus mr-4"></i>Applied');
                // $(this).addClass('bg-emerald-600').removeClass('hover:bg-green-700 hover:scale-105 duration-300 transition-all bg-green-600');

            });


            // To re-initialize the review count and average after review submission
            function initialize(eventId) {
                //alert('HELLO');
                $.ajax({
                    url: "Backend/review_info.php",
                    type: "POST",
                    data: {
                        event_id: eventId
                    },
                    success: function(response) {
                        // alert("Review submitted successfully!");
                        //location.reload();
                        $(".review_info").html(response);
                    }
                });

            }

            // TO HANDLE REVIEW SUBMITION
            $("#reviewForm").submit(function(e) {
                e.preventDefault();
                let reviewText = $("#review-text").val();
                let rating = $("#rating").val();
                let eventId = <?= $event_id ?>;
                let userId = <?= $user_id ?>;

                if (rating == 0 || reviewText.trim() == "") {
                    alert("Please select a rating and enter a review.");
                    return;
                }

                $.ajax({
                    url: "Backend/submit_review.php",
                    type: "POST",
                    data: {
                        event_id: eventId,
                        user_id: userId,
                        rating: rating,
                        review_text: reviewText
                    },
                    success: function(response) {

                        alert("Review submitted successfully!");
                        //location.reload();

                        //to re-fresh the review-list dynamically
                        $.ajax({
                            url: "Backend/submit_review.php",
                            type: "POST",
                            data: {
                                all_id: "all",
                                event_id: eventId
                            },
                            success: function(response) {
                                // alert("Review submitted successfully!");
                                //location.reload();

                                $(".review_list").html(response);

                                // Reset the rating stars
                                $(".rating-star").removeClass("text-yellow-400").addClass("text-gray-300");

                                // Reset the hidden input field
                                $("#rating").val("0");

                                // Clear the textarea
                                $("#review-text").val("");

                                //To initilize the review info (count and average)
                                initialize(eventId);
                            }
                        });

                    },
                    error: function() {
                        alert("Failed to submit review.");
                    }
                });
            });
        });
    </script>



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
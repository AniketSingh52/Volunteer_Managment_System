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


            $volunteer_needed = $row['volunteers_needed'];
            $event_image = $row['poster'];
            $event_image = preg_replace('/^\.\.\//', '', $event_image);

            // $date_of_creation = $row['date_of_creation'];
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


            // Fetch application data from the database based on event_id
            $sql = "SELECT u.*, ea.status as applicunt_status, ea.date as date_of_application
                    FROM user u
                    JOIN events_application ea ON u.user_id = ea.volunteer_id
                    WHERE ea.event_id = ? ORDER BY ea.date ASC
                    ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $event_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $availabe = 1;
            } else {
                $availabe = 0;
            }
            $applications = $result->fetch_all(MYSQLI_ASSOC);


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


            // //Fetch Organizator Details using Organization ID
            // $sql = "SELECT * FROM `user` WHERE user_id=?";
            // $stmt = $conn->prepare($sql);
            // $stmt->bind_param("i", $organization_id);
            // $stmt->execute();
            // $result = $stmt->get_result();
            // $row = $result->fetch_assoc();
            // $organization_name = $row['name'];
            // $profile = $row['profile_picture'];
            // $user_address = $row['address'];
            // $user_email = $row['email'];
            // $user_doe = date('jS M Y', strtotime($row['DOB/DOE']));
            // $profile = preg_replace('/^\.\.\//', '', $profile);

            // //Fetch Organization Type
            // $sql = "SELECT type_name FROM `organization_type` WHERE type_id in (SELECT type_id FROM `organization_belongs_type` WHERE user_id=?)";
            // $stmt = $conn->prepare($sql);
            // $stmt->bind_param("i", $organization_id);
            // $stmt->execute();
            // $result = $stmt->get_result();
            // $row = $result->fetch_assoc();
            // $organization_type = $row['type_name'];
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
    <?php include('../layouts/sidebar.php'); ?>

    <!-- Main -->
    <main
        class="w-full md:w-[calc(100%-288px)] md:ml-72 bg-gray-200 min-h-screen transition-all main">

        <!-- Navbar -->
        <?php include('../layouts/navbar.php'); ?>

        <!-- Contents -->
        <div class="p-4 dynamiccontents" id="dynamiccontents">
            <div class="max-w-7xl mx-auto px-4 py-3">
                <!-- Event Overview -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-12">
                    <div class="relative h-[500px]">
                        <img
                            src="<?= $event_image ?>"
                            alt="<?= $event_name ?>"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-8 text-white">
                            <div class="flex items-center space-x-4 mb-4">
                                <span class="<?= $status_style ?> backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-semibold"><?= $status ?></span>
                                <span class="bg-white/20 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm"><?= $volunteer_needed - $accepted_count ?> spots remaining</span>
                            </div>
                            <h1 class="text-4xl font-bold mb-2"><?= $event_name ?></h1>
                            <p class="text-lg opacity-90"><?= $from_date ?> • <?= $to_date ?>, <?= $from_time ?> - <?= $to_time ?></p>

                        </div>
                    </div>

                    <!-- Event Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 p-8 bg-white">
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-500">Total Applications</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900"><?= $total_applications ?></p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-500">Accepted</p>
                            <p class="mt-2 text-3xl font-bold text-green-600"><?= $accepted_count ?></p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-500">Pending</p>
                            <p class="mt-2 text-3xl font-bold text-amber-500"><?= $pending_count ?></p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-500">Rejected</p>
                            <p class="mt-2 text-3xl font-bold text-red-600"><?= $rejected_count ?></p>
                        </div>
                    </div>
                </div>

                <!-- Applications List -->
                <div class="space-y-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold text-gray-900">Volunteer Applications</h2>
                        <div class="flex space-x-4">
                            <select class="filter rounded-lg px-4 py-2 border-gray-300 text-gray-700 text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="all">All Applications</option>
                                <option value="pending">Pending</option>
                                <option value="accepted">Accepted</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <!-- <select class="rounded-lg  px-4 py-2 border-gray-300 text-gray-700 text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="score">Highest Score</option>
                            </select> -->
                        </div>
                    </div>

                    <!-- Application Cards -->
                    <!-- <div class="space-y-6"> -->
                    <!-- Application 1 -->
                    <!-- <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex space-x-4">
                                        <img
                                            src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&q=80&w=150"
                                            alt="John Doe"
                                            class="h-16 w-16 rounded-full object-cover border-2 border-gray-200">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">John Doe</h3>
                                            <p class="text-sm text-gray-500">@johndoe</p>
                                            <div class="mt-2 flex items-center">
                                                <div class="flex items-center">
                                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    <p class="ml-1 text-sm font-medium text-gray-500">Volunteer Score: 4.8</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                                        Pending
                                    </span>
                                </div>

                                <div class="mt-6">
                                    <h4 class="text-sm font-medium text-gray-500">Skills</h4>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            Communication
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                            Leadership
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            Gardening
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end space-x-4">
                                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        View Profile
                                    </button>
                                    <button class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Reject
                                    </button>
                                    <button class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Accept
                                    </button>
                                </div>
                            </div>
                        </div> -->

                    <!-- Application 2 -->
                    <!-- <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex space-x-4">
                                        <img
                                            src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150"
                                            alt="Jane Smith"
                                            class="h-16 w-16 rounded-full object-cover border-2 border-gray-200">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">Jane Smith</h3>
                                            <p class="text-sm text-gray-500">@janesmith</p>
                                            <div class="mt-2 flex items-center">
                                                <div class="flex items-center">
                                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    <p class="ml-1 text-sm font-medium text-gray-500">Volunteer Score: 4.5</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Accepted
                                    </span>
                                </div>

                                <div class="mt-6">
                                    <h4 class="text-sm font-medium text-gray-500">Skills</h4>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            Team Management
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                            First Aid
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            Environmental Science
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end space-x-4">
                                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        View Profile
                                    </button>
                                    <button class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Reject
                                    </button>
                                    <button class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Accept
                                    </button>
                                </div>
                            </div>
                        </div> -->

                    <!-- Application 3 -->
                    <!-- <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex space-x-4">
                                        <img
                                            src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?auto=format&fit=crop&q=80&w=150"
                                            alt="Mike Johnson"
                                            class="h-16 w-16 rounded-full object-cover border-2 border-gray-200">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">Mike Johnson</h3>
                                            <p class="text-sm text-gray-500">@mikejohnson</p>
                                            <div class="mt-2 flex items-center">
                                                <div class="flex items-center">
                                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    <p class="ml-1 text-sm font-medium text-gray-500">Volunteer Score: 4.2</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                </div>

                                <div class="mt-6">
                                    <h4 class="text-sm font-medium text-gray-500">Skills</h4>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            Project Planning
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                            Community Outreach
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end space-x-4">
                                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        View Profile
                                    </button>
                                    <button class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Reject
                                    </button>
                                    <button class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Accept
                                    </button>
                                </div>
                            </div>
                        </div> -->
                    <!-- </div> -->


                    <!-- Applications List -->
                    <div class="space-y-6 application_list">
                        <!-- Application 1 -->

                        <?php foreach ($applications as $applicunt):
                            $applicunt_status = "";
                            $applicunt_status_style = "";
                            $applicunt_id = $applicunt['user_id'];
                            $profile = $applicunt['profile_picture']; //Original String
                            $profile = preg_replace('/^\.\.\//', '', $profile); // Remove "../" from the start
                            $date_of_joining = date('jS M y', strtotime($applicunt['registration_date']));
                            $date_of_application = date('jS M y', strtotime($applicunt['date_of_application']));
                            switch ($applicunt['applicunt_status']) {
                                case 'pending':
                                    $applicunt_status = 'Pending';
                                    $applicunt_status_style = "bg-amber-100 text-amber-800";
                                    break;
                                case 'rejected':
                                    $applicunt_status = 'Rejected';
                                    $applicunt_status_style = "bg-red-100 text-red-800";
                                    break;
                                case 'accepted':
                                    $applicunt_status = 'Accepted';
                                    $applicunt_status_style = "bg-green-100 text-green-800";
                                    break;
                            }

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
                                                        <h3 class="text-2xl font-bold text-gray-900"><?= $applicunt['name'] ?> <span class=" ml-3 text-sm text-gray-700 border-2 border-gray-200 shadow-sm rounded-xl px-2 py-1 bg-gray-200"><?= $date_of_application ?></span></h3>
                                                        <p class="text-base text-gray-500">User ID: @<?= $applicunt['user_name'] ?></p>
                                                    </div>
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $applicunt_status_style ?>">
                                                        <?= $applicunt_status ?>
                                                    </span>
                                                </div>
                                                <div class="mt-4 flex items-center space-x-4">
                                                    <div class="flex items-center">
                                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                        <p class="ml-1.5 text-base font-medium text-gray-600">Volunteer Score: 4900</p>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i data-lucide="clock" class="h-5 w-5 text-blue-500"></i>
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
                                                        <i data-lucide="calendar" class="h-4 w-4 text-blue-600 mr-2"></i>
                                                        <span class="text-base text-gray-600">DOB: <?= $applicunt['DOB/DOE'] ?></span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i data-lucide="user" class="h-4 w-4 text-green-600 mr-2"></i>
                                                        <span class="text-base text-gray-600">Gender: <?= $gender ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <h4 class="text-lg font-medium text-gray-500 mb-1">Contact Information</h4>
                                                <div class="space-y-2">
                                                    <div class="flex items-center">
                                                        <i data-lucide="mail" class="h-4 w-4 text-purple-700 mr-2"></i>
                                                        <span class="text-base text-gray-600"><?= $applicunt['email'] ?></span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i data-lucide="phone" class="h-4 w-4 text-indigo-800 mr-2"></i>
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
                                                        <i data-lucide="map-pin" class="h-4 w-4 text-violet-700 mr-2 mt-0.5"></i>
                                                        <span class="text-base text-gray-600"> <?= $applicunt['address'] ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <h4 class="text-lg font-medium text-gray-500 mb-1">Skills</h4>
                                                <div class="mt-2 flex flex-wrap gap-2">

                                                    <?php
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


                                                    ?>
                                                    <!-- <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                    Communication
                                                </span>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                                    Leadership
                                                </span>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                    Gardening
                                                </span> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Statistics -->
                                    <div class="mt-6 grid grid-cols-2 gap-4">
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-base font-semibold text-gray-500">Events Attended</div>
                                            <div class="text-lg font-semibold text-gray-900"><?= $accepted ?></div>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-base font-semibold text-gray-500">Events to Attend</div>
                                            <div class="text-lg font-semibold text-gray-900"><?= $pending ?></div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-6 flex justify-end space-x-4">
                                        <button onclick="window.location.href='profile.php?<?= base64_encode($applicunt_id) ?>'" class="px-4 hover:scale-105 transition-all duration-300 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            View Full Profile
                                        </button>
                                        <div class="applicunt_action">

                                            <?php if ($applicunt_status == 'Accepted') {
                                                echo '
                                             <button data-action="rejected" data-userid="' . $applicunt_id . '" class="px-4 py-2 hover:scale-105 transition-all duration-300 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Reject
                                            </button>
                                            ';
                                            } elseif ($applicunt_status == 'Rejected') {
                                                echo '
                                                 <button data-action="accepted" data-userid="' . $applicunt_id . '" class="px-4 py-2 hover:scale-105 transition-all duration-300 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Accept
                                               </button>
                                                ';
                                            } else { ?>
                                                <button data-action="rejected" data-userid="<?= $applicunt_id ?>" class="px-4 hover:scale-105 transition-all duration-300 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    Reject
                                                </button>
                                                <button data-action="accepted" data-userid="<?= $applicunt_id ?>" class="px-4 py-2  border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                    Accept
                                                </button>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php
                        if ($availabe == 0) {
                            echo "<h1 class=' text-2xl h-72 text-center mb-40'>No Applications Yet</h1> ";
                        }

                        ?>


                    </div>
                    <!-- Pagination -->
                    <!-- <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 rounded-lg mt-6">
                        <div class="flex flex-1 justify-between sm:hidden">
                            <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                            <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                        </div>
                        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">24</span> results
                                </p>
                            </div>
                            <div>
                                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                    <a href="#" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <a href="#" aria-current="page" class="relative z-10 inline-flex items-center bg-blue-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">1</a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">2</a>
                                    <a href="#" class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex">3</a>
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                                    <a href="#" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                        <span class="sr-only">Next</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div> -->
                </div>


            </div>
        </div>
        <!-- End Content -->

    </main>






    <!-- Footer -->
    <?php include('../layouts/footer.php'); ?>

    <!-- Home Page NavBar Sidebar Don't Touch -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../js/main.js"></script>

    <!-- <script>
        // Initialize Lucide icons
        lucide.createIcons();

        $(document).ready(function() {
            // Tab switching functionality
            $('.applicunt_action button').click(function() {
                // Remove active classes from all tabs
                //$('nav button').removeClass('border-blue-500 text-blue-600').addClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');

                // Add active classes to clicked tab
                //$(this).addClass('border-blue-500 text-blue-600').removeClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');
                let action = $(this).data("action");
                let user = $(this).data("userid");
                var eventID = <?= $event_id ?>;
                // location.reload();
                // $(this).attr('disabled', true);
                alert(action);
                alert(user);


                $.ajax({
                    url: "Backend/Application_status.php", // Backend PHP script
                    method: "POST",
                    data: {
                        action: action,
                        user_id: user,
                        event_id: eventID
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message); // Show success message
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
            });
            $('.filter').change(function() {
                let filter = $(this).val();
                var eventID = <?= $event_id ?>;
                alert(filter)
                $.ajax({
                    url: "Backend/Application_filter.php", // Backend PHP script
                    method: "POST",
                    data: {
                        filter: filter,
                        event_id: eventID
                    },
                    success: function(response) {
                        // alert("Review submitted successfully!");
                        //location.reload();
                        $(".application_list").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX Error: " + status + " " + error);
                        alert("AJAX Error: " + status + " " + error);
                    }
                });
            });

        });
    </script> -->
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        $(document).ready(function() {

            // Tab switching functionality using event delegation
            $(document).on('click', '.applicunt_action button', function() {
                let action = $(this).data("action");
                let user = $(this).data("userid");
                var eventID = <?= $event_id ?>;
                var volunteer_count = <?= $volunteer_needed ?>;
                var accepted_count = <?= $accepted_count ?>;
                if (action == "accepted") {
                    if (volunteer_count > accepted_count) {
                        //alert(action);
                        //alert(user);

                        $.ajax({
                            url: "Backend/Application_status.php", // Backend PHP script
                            method: "POST",
                            data: {
                                action: action,
                                user_id: user,
                                event_id: eventID
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    alert(response.message); // Show success message
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

                    } else {
                        alert("Can't Accep the application, Maximum Volunteer Limit Reached !!! ");
                    }

                } else {

                    $.ajax({
                        url: "Backend/Application_status.php", // Backend PHP script
                        method: "POST",
                        data: {
                            action: action,
                            user_id: user,
                            event_id: eventID
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                alert(response.message); // Show success message
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

            // Filter functionality using event delegation
            $(document).on('change', '.filter', function() {
                let filter = $(this).val();
                var eventID = <?= $event_id ?>;
                //alert(filter);

                $.ajax({
                    url: "Backend/Application_filter.php", // Backend PHP script
                    method: "POST",
                    data: {
                        filter: filter,
                        event_id: eventID
                    },
                    success: function(response) {
                        $(".application_list").html(response);
                        // Re-initialize Lucide icons after content update
                        lucide.createIcons();
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX Error: " + status + " " + error);
                        alert("AJAX Error: " + status + " " + error);
                    }
                });
            });
        });
    </script>
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
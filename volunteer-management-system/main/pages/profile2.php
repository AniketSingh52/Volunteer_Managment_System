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



if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id2 = base64_decode($_GET['id']);

    // echo "
    // <script>
    // alert('$event_id');
    // </script>
    // ";

    // SQL query to GET EVENT DETAILS
    $sql = "SELECT * FROM `user`
            WHERE user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id2);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {

        if ($row = $result->fetch_assoc()) {

            $user_name = $row['user_name'];
            $email = $row['email'];
            $contact = $row['contact'];
            $gender = $row['gender'];
            $occupation = $row['occupation'];
            $username2 = $row['name'];
            $address = $row['address'];
            $user_image = $row['profile_picture'];
            $user_type = $row['user_type'] == "V" ? "Volunteer" : "Organisation";
            $user_name_style = ($row['user_type'] == 'V') ? "bg-green-100 hover:bg-green-800/90 text-green-800 hover:text-white  duration-300 transition-all" : "bg-sky-100 hover:bg-sky-800/90 font-medium hover:text-white  duration-300 transition-all text-sky-800";

            $user_image = preg_replace('/^\.\.\//', '', $user_image);

            //Convert Date to Human Readable Format
            $dob_doe = date('jS M y', strtotime($row['DOB/DOE']));
            $dor = date('jS M y', strtotime($row['registration_date']));


            $query = "SELECT COUNT(*) AS ptotal FROM pictures WHERE user_id=? ";

            // Prepare and execute the statement
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id2); // "i" for integer
            $stmt->execute();
            $result = $stmt->get_result();

            // Initialize variables
            $total_post = 0;
            if ($row = $result->fetch_assoc()) {
                $total_post = $row['ptotal'];
            }


            if ($user_type == "Volunteer") {

                $query = "SELECT COUNT(*) AS total FROM events_application WHERE volunteer_id=? ";

                // Prepare and execute the statement
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $user_id2); // "i" for integer
                $stmt->execute();
                $result = $stmt->get_result();

                // Initialize variables
                $total_participation = 0;
                if ($row = $result->fetch_assoc()) {
                    $total_participation = $row['total'];
                }
            } else {
                $query = "SELECT COUNT(*) AS total FROM events WHERE organization_id=? ";

                // Prepare and execute the statement
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $user_id2); // "i" for integer
                $stmt->execute();
                $result = $stmt->get_result();

                // Initialize variables
                $total_events = 0;
                if ($row = $result->fetch_assoc()) {
                    $total_events = $row['total'];
                }
            }
        }
    }
} else {
    echo "<script>alert('Select an User.'); window.location.href='admin.php';</script>";
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

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <!-- Profile Header -->
                <!-- <div class="relative mb-8"> -->

                <!-- Cover Image -->
                <!-- <div class="h-48 w-full rounded-xl bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-600 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/10"></div>
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/20"></div>
                        <div class="absolute bottom-4 right-4 flex items-center space-x-2 text-white/80">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <span class="text-sm font-medium">Edit Cover</span>
                        </div>
                    </div> -->

                <!-- Profile Info -->
                <!-- <div class="absolute -bottom-10 left-8 flex items-end space-x-6">
                        <div class="relative group">
                            <img
                                src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&q=80&w=150"
                                alt="Profile Picture"
                                class="h-32 w-32 rounded-xl object-cover border-4 border-white shadow-lg group-hover:shadow-xl transition-all duration-300">
                            <button class="absolute bottom-2 right-2 p-2 bg-gray-900/90 rounded-lg hover:bg-gray-800 transition-colors group-hover:scale-105">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        <div class="pb-4 flex justify-between items-end flex-1">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-1">John Doe</h1>
                                <div class="flex items-center space-x-3">
                                    <p class="text-gray-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        @johndoe
                                    </p> -->
                <!-- <span class="text-gray-300">•</span>
                                    <p class="text-gray-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Mumbai, India
                                    </p> -->
                <!-- </div>
                            </div>
                            <div class="flex space-x-4 ml-10">
                                <button class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300 font-medium flex items-center space-x-2 hover:shadow-lg hover:-translate-y-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    <span>Edit Profile</span>
                                </button>
                                <button class="px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-300 font-medium flex items-center space-x-2 hover:shadow-lg hover:-translate-y-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div>
                    <div class="w-full roun bg-cover bg-no-repeat bg-center">
                        <img class="opacity-100 w-full h-56 object-cover rounded-2xl rounded-b" src="https://res.cloudinary.com/omaha-code/image/upload/ar_4:3,c_fill,dpr_1.0,e_art:quartz,g_auto,h_396,q_auto:best,t_Linkedin_official,w_1584/v1561576558/mountains-1412683_1280.png" alt="">
                    </div>
                    <div class="p-4">
                        <div class="relative flex w-full">
                            <!-- Avatar -->
                            <div class="flex flex-1">
                                <div style="margin-top: -6rem;">
                                    <div style="height:9rem; width:9rem;" class="md rounded-full relative avatar">
                                        <img style="height:9rem; width:9rem;" class="md rounded-full relative border-4 border-gray-200" src="<?= $user_image ?>" alt="<?= $user_name ?>">
                                        <div class="absolute"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Follow Button -->

                            <?php
                            if ($user_id2 == $user_id) {


                            ?>
                                <div class="flex flex-col text-right">
                                    <button onclick="window.location.href='Edit_profile.php?id='<?= base64_encode($user_id2) ?>" class="flex justify-center  max-h-max whitespace-nowrap focus:outline-none  focus:ring  rounded max-w-max border bg-transparent border-blue-500 text-blue-500 hover:border-blue-800 items-center hover:shadow-lg font-bold py-2 px-4  mr-0 ml-auto">
                                        Edit Profile
                                    </button>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Profile info -->
                        <div class="space-y-1 justify-center w-full mt-3 ml-3 ">
                            <!-- User basic-->
                            <div>
                                <h2 class="text-2xl leading-6 font-bold text-gray-700"><?php echo $username2; ?></h2>
                                <p class="text-base mt-1 leading-5 font-medium text-gray-600 font-mono">@<?= $user_name ?></p>
                            </div>
                            <!-- Description and others -->
                            <div class="mt-3">
                                <p class="text-gray-700 leading-relaxed font-normal mb-2">Hello There!!!<br>I am a Passionate <?= $user_type ?>. I Work to make this WORLD a better place. </p>
                                <div class="text-gray-600 flex">
                                    <span class="flex mr-2"><svg viewBox="0 0 24 24" class="h-6 w-6 paint-icon">
                                            <g>
                                                <path d="M11.96 14.945c-.067 0-.136-.01-.203-.027-1.13-.318-2.097-.986-2.795-1.932-.832-1.125-1.176-2.508-.968-3.893s.942-2.605 2.068-3.438l3.53-2.608c2.322-1.716 5.61-1.224 7.33 1.1.83 1.127 1.175 2.51.967 3.895s-.943 2.605-2.07 3.438l-1.48 1.094c-.333.246-.804.175-1.05-.158-.246-.334-.176-.804.158-1.05l1.48-1.095c.803-.592 1.327-1.463 1.476-2.45.148-.988-.098-1.975-.69-2.778-1.225-1.656-3.572-2.01-5.23-.784l-3.53 2.608c-.802.593-1.326 1.464-1.475 2.45-.15.99.097 1.975.69 2.778.498.675 1.187 1.15 1.992 1.377.4.114.633.528.52.928-.092.33-.394.547-.722.547z"></path>
                                                <path d="M7.27 22.054c-1.61 0-3.197-.735-4.225-2.125-.832-1.127-1.176-2.51-.968-3.894s.943-2.605 2.07-3.438l1.478-1.094c.334-.245.805-.175 1.05.158s.177.804-.157 1.05l-1.48 1.095c-.803.593-1.326 1.464-1.475 2.45-.148.99.097 1.975.69 2.778 1.225 1.657 3.57 2.01 5.23.785l3.528-2.608c1.658-1.225 2.01-3.57.785-5.23-.498-.674-1.187-1.15-1.992-1.376-.4-.113-.633-.527-.52-.927.112-.4.528-.63.926-.522 1.13.318 2.096.986 2.794 1.932 1.717 2.324 1.224 5.612-1.1 7.33l-3.53 2.608c-.933.693-2.023 1.026-3.105 1.026z"></path>
                                            </g>
                                        </svg> <a href="" target="#" class="leading-5 ml-1 text-base text-blue-400">www.volunteerManagement.com</a></span>
                                    <span class="flex mr-2"><svg viewBox="0 0 24 24" class="h-6 w-6 paint-icon">
                                            <g>
                                                <path d="M19.708 2H4.292C3.028 2 2 3.028 2 4.292v15.416C2 20.972 3.028 22 4.292 22h15.416C20.972 22 22 20.972 22 19.708V4.292C22 3.028 20.972 2 19.708 2zm.792 17.708c0 .437-.355.792-.792.792H4.292c-.437 0-.792-.355-.792-.792V6.418c0-.437.354-.79.79-.792h15.42c.436 0 .79.355.79.79V19.71z"></path>
                                                <circle cx="7.032" cy="8.75" r="1.285"></circle>
                                                <circle cx="7.032" cy="13.156" r="1.285"></circle>
                                                <circle cx="16.968" cy="8.75" r="1.285"></circle>
                                                <circle cx="16.968" cy="13.156" r="1.285"></circle>
                                                <circle cx="12" cy="8.75" r="1.285"></circle>
                                                <circle cx="12" cy="13.156" r="1.285"></circle>
                                                <circle cx="7.032" cy="17.486" r="1.285"></circle>
                                                <circle cx="12" cy="17.486" r="1.285"></circle>
                                            </g>
                                        </svg> <span class="leading-5 ml-1 text-base">Joined <?= $dor ?></span></span>
                                </div>
                            </div>
                            <div class="pt-3 flex justify-start  items-start w-full divide-x divide-gray-800 divide-solid">
                                <div class="text-center pr-3"><span class="font-bold text-gray-800 text-lg"> <?php echo ($user_type == "Volunteer") ? $total_participation : $total_events; ?></span><span class="text-gray-600 text-base font-medium"> <?php echo ($user_type == "Volunteer") ? "My Participation" : "My Events"; ?></span></div>
                                <div class="text-center px-3"><span class="font-bold text-gray-800 text-lg"> <?= $total_post ?> </span><span class="text-gray-600 text-base font-medium"> Post</span></div>
                            </div>
                        </div>
                    </div>
                    <hr class="border-gray-800">
                </div>

                <!-- Main Content -->
                <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - User Information -->
                    <div class="space-y-6">
                        <!-- Basic Information -->
                        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-semibold text-gray-900">Basic Information</h2>
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <div>
                                        <p class="text-base font-medium text-gray-500">Account Type</p>
                                        <p class="mt-2 flex items-center">
                                            <span class="inline-flex items-center  rounded-full text-lg py-3 px-2 font-medium bg-green-100 <?= $user_name_style ?>">
                                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <?= $user_type ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <div>
                                        <p class="text-base font-medium text-gray-500"><?php echo ($user_type == "Volunteer") ? "Date of Birth " : "Date Of Establishment"; ?></p>
                                        <p class="mt-1 font-medium text-gray-900 flex items-center">
                                            <svg class="w-6 h-6 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <?= $dob_doe ?>
                                        </p>
                                    </div>
                                </div>

                                <?php
                                switch ($gender) {
                                    case 'M':
                                        $gender_text = "MALE";
                                        break;
                                    case 'F':
                                        $scheduled = "FEMALE";
                                        break;
                                    case 'O':
                                        $completed = "OTHERS";
                                        break;
                                }
                                if ($gender != 'N') {


                                ?>
                                    <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                        <div>
                                            <p class="text-base font-medium text-gray-500">Gender</p>
                                            <p class="mt-1 font-medium text-gray-900 flex items-center">
                                                <svg class="w-6 h-6 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <?= $gender_text ?>
                                            </p>
                                        </div>
                                    </div>

                                <?php } ?>
                                <?php if ($user_type != "Volunteer") {
                                    $sql = "SELECT type_name FROM `organization_type` WHERE type_id=(SELECT type_id FROM `organization_belongs_type` WHERE user_id=?)";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $user_id2);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    $org_type_name = $row['type_name'];
                                } ?>
                                <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <div>
                                        <p class="text-base font-medium text-gray-500"><?php echo ($user_type == "Volunteer") ? "Occupation " : "Organization Type"; ?></p>
                                        <p class="mt-1 font-medium text-gray-900 flex items-center">
                                            <svg class="w-6 h-6 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <?php echo ($user_type == "Volunteer") ? $occupation : $org_type_name; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Member Since</p>
                                        <p class="mt-1 font-medium text-gray-900 flex items-center">
                                            <svg class="w-6 h-6 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <?= $dor ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-semibold text-gray-900">Contact Information</h2>
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="space-y-4">
                                <div class="p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <p class="text-base font-medium text-gray-500">Email</p>
                                    <p class="mt-1 font-medium text-gray-900 flex items-center">
                                        <svg class="w-6 h-6 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <?= $email ?>
                                    </p>
                                </div>
                                <div class="p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <p class="text-base font-medium text-gray-500">Address</p>
                                    <p class="mt-1 font-medium text-gray-900 flex items-center">
                                        <svg class="w-6 h-6 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <?= $address ?>
                                    </p>
                                </div>
                            </div>
                        </div>


                        <!-- Skills & Interests -->
                        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-semibold text-gray-900"><?php echo ($user_type == "Volunteer") ? "Skills & Interests" : "Areas Of Interests"; ?></h2>
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <?php
                            if ($user_type == "Volunteer") {




                            ?>
                                <!-- Skills -->
                                <div class="mb-6">
                                    <h3 class="text-base font-medium text-gray-500 mb-3 flex items-center">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        Skills
                                    </h3>
                                    <div class="flex flex-wrap gap-2 font-medium">


                                        <?php
                                        $sql = "SELECT skill_name FROM `skill` WHERE skill_id in (SELECT skill_id FROM `volunteer_skill` WHERE user_id=?)";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("i", $user_id2);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $index2 = 0;
                                        $styles2 = [
                                            "bg-sky-100 text-sky-800 hover:bg-sky-200 ",
                                            "bg-amber-100 text-amber-800 hover:bg-amber-200",
                                            "bg-lime-100 text-lime-800 hover:bg-lime-200",
                                            "bg-violet-100 text-violet-800 hover:bg-violet-200",
                                            "bg-rose-100 text-rose-800 hover:bg-rose-200",
                                            "bg-fuchsia-100 text-fuchsia-800 hover:bg-fuchsia-200 ",
                                            "bg-emerald-100 text-emerald-800 hover:bg-emerald-200 "
                                        ];

                                        if ($result->num_rows > 0) {

                                            while ($row = $result->fetch_assoc()) {
                                                $skill_name = $row['skill_name'];
                                                $style2 = $styles2[$index2 % 7];
                                                $index2++;
                                                echo '
                                                <span class=" ' . $style2 . ' hover:scale-105 inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium  transition-all duration-300 cursor-pointer">' . $skill_name . '</span>
                                                 ';
                                            }
                                        } else {
                                            echo '
                                            <span class=" inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-orange-100 text-orange-800 hover:bg-orange-200 transition-colors cursor-pointer"> No Skill</span>
                                               ';
                                        }

                                        ?>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>


                            <!-- Causes -->
                            <div>
                                <h3 class="text-base font-medium text-gray-500 mb-3 flex items-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    Causes
                                </h3>
                                <div class="flex flex-wrap gap-2 font-medium">

                                    <?php
                                    $sql = "SELECT name FROM `causes` WHERE cause_id in (SELECT cause_id FROM `user_workfor_causes` WHERE user_id=?)";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $user_id2);
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
                                                 <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium ' . $style . ' transition-all hover:scale-105 cursor-pointer">
                                        ' . $cause_name . '
                                    </span>
                                                ';
                                        }
                                    } else {
                                        echo '
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium hover:scale-105 transition-all duration-300 cursor-pointer bg-orange-100 text-orange-800"> No Tags</span>
                                                ';
                                    }
                                    ?>
                                    <!-- <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-pink-100 text-pink-800 hover:bg-pink-200 transition-colors cursor-pointer">
                                        Education
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 hover:bg-indigo-200 transition-colors cursor-pointer">
                                        Environment
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-orange-100 text-orange-800 hover:bg-orange-200 transition-colors cursor-pointer">
                                        Animal Welfare
                                    </span> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Events & Posts -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Tabs -->
                        <div class="bg-white rounded-xl shadow-sm">
                            <div class="border-b border-gray-200">
                                <nav class="flex -mb-px">
                                    <button data-status="events" class=" w-1/2 py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600 flex items-center justify-center space-x-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span><?php echo ($user_type == "Volunteer") ? "Event Participation " : "Events Posted "; ?></span>
                                    </button>
                                    <button data-status="posts" class="w-1/2 py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center justify-center space-x-2">
                                        <i class="bx bx-images mr-3 text-2xl"></i>
                                        <span>Posts</span>
                                    </button>
                                </nav>
                            </div>
                        </div>

                        <?php
                        if ($user_type != "Volunteer") {
                        ?>
                            <!-- Event List Posted by Organization  -->
                            <div id="dynamic_list1">
                                <!-- Events List -->
                                <div class="space-y-6">
                                    <!-- Event Card -->
                                    <?php

                                    $sql = "SELECT * FROM `events`
                                    WHERE organization_id = ?  
                                    ORDER BY `date_of_creation` DESC";

                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $user_id2);
                                    $stmt->execute();
                                    $result2 = $stmt->get_result();


                                    // Display results
                                    if ($result2->num_rows > 0) {
                                        while ($row = $result2->fetch_assoc()) {

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

                                            // Convert to DateTime object
                                            // $creation_date = new DateTime($date_of_creation);
                                            // $today = new DateTime();
                                            // $diff = $today->diff($creation_date)->days;

                                            // $days_ago = ($diff <= 10) ? "$diff days ago" : $date_of_creation;

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


                                            $sql = "SELECT * FROM `user` WHERE user_id=?";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param("i", $organization_id);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $row = $result->fetch_assoc();
                                            $organization_name = $row['name'];
                                            $organization_email = $row['email'];

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




                                            echo '
                                        <div
                                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                                            <div class="md:flex">
                                                <div class="md:w-1/3 hover:scale-105 duration-300 transition-all border-gray-700 border-e">
                                                    <img
                                                        class="h-48 w-full object-cover md:h-full"
                                                        src="' . $event_image . '"
                                                        alt="' . htmlspecialchars($event_name) . '" />
                                                </div>
                                                <div class="p-8 md:w-2/3 relative">
                                                    <div
                                                        class="text-sm absolute font-semibold top-0 right-0 ' . $status_style . '  rounded-sm px-4 py-2 text-white mt-3 mr-3  hover:text-white transition duration-500 ease-in-out">
                                                        ' . htmlspecialchars($status) . '
                                                    </div>
                                                    <div
                                                        class="uppercase  tracking-wide text-sm text-blue-600 font-semibold">
                                                        ' . htmlspecialchars($organization_name) . '
                                                        <span class=" ml-3 text-gray-700 border-2 border-gray-200 shadow-sm rounded-xl px-2 py-1 bg-gray-200">' . htmlspecialchars($days_ago) . '</span>
                                                    </div>

                                                    <h3 class="mt-1 text-2xl font-semibold text-gray-900">
                                                        ' . htmlspecialchars($event_name) . '
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
                                                        ' . htmlspecialchars($from_date) . ' • ' . htmlspecialchars($to_date) . '
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
                                                    ' . htmlspecialchars($from_time) . ' - ' . htmlspecialchars($to_time) . '
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
                                                        ' . htmlspecialchars($location) . '
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
                                                        Volunteer Needed: ' . htmlspecialchars($accepted_count) . '/
                                                        ' . htmlspecialchars($volunteer_needed) . '
                                                    </div>
                                                    <div class=" flex">
                                                        <div class="flex mt-2 flex-wrap items-center  font-bold text-base text-gray-600">
                                                            Tags:
                                                        </div>
                                                        <div class="mt-2 flex flex-wrap items-center justify-items-center px-3 font-semibold text-base text-gray-600">
                                        ';

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
                                                "bg-teal-100 text-teal-800 hover:bg-teal-200 "
                                            ];

                                            if ($result->num_rows > 0) {

                                                while ($row = $result->fetch_assoc()) {
                                                    $cause_name = $row['name'];
                                                    $style = $styles[$index % 4];
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


                                            echo '
                                            </div>
                                        </div>
                                        <div class=" flex mt-2">
                                            <div class="flex mt-2 flex-wrap items-center  font-bold text-base text-gray-600">
                                                Skills:
                                            </div>
                                            <div class="mt-2 flex flex-wrap items-center justify-items-center px-3 font-semibold text-base text-gray-600">
                                            ';

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
                                            ';
                                            }




                                            echo '
                   
                                                </div>
                                            </div>

                                            <p class="mt-4 text-gray-600 example leading-relaxed text-base">
                                                ' . $description .
                                                '
                                            </p>

                                        <div class="mt-6 flex space-x-4">
                                                <a href="event_detail.php?id=' . base64_encode($event_id) . '">
                                                    <button
                                                        class="bg-blue-600 w-[9rem] text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 hover:scale-105 duration-300 transition-all">
                                                        View More
                                                    </button>
                                                </a>

                                                ';
                                            if ($user_id == $organization_id) {
                                                echo '
                                                <a href="Event_Applications.php?id=' . base64_encode($event_id) . '">
                                                <button
                                                    class="bg-green-600  text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 hover:scale-105 duration-300 transition-all">
                                                    View Applicants
                                                </button>
                                            </a>
                                                ';
                                            } elseif ($type == "Organisation") {

                                                echo '
                                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=' . $organization_email . '&su=Inquiry about the Event&body=Hello, I am interested in your event and would like to know more."
                                            target="_blank"
                                            class="bg-green-600  text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 hover:scale-105 duration-300 transition-all">
                                                Contact Organizer
                                            </a>       
                                                ';
                                            } else {


                                                $sql2 = "SELECT * FROM `events_application` WHERE event_id='$event_id' AND volunteer_id='$user_id'";
                                                $checkResult2 = $conn->query($sql2);
                                                if ($checkResult2->num_rows > 0) {
                                                    echo '
               
                                                <button
                                                    class=" opacity-80 bg-emerald-400  basis-36 w-[9rem] text-white px-6 py-2 rounded-lg font-semibold">
                                                    <i class="bx bxs-bookmark-minus mr-4"></i>Applied
                                                </button>
                                            
                                            ';
                                                } else {

                                                    echo '
                                
                                        <button data-event="' . $event_id . '" data-volunteer_needed="' . $volunteer_needed - $accepted_count . '"
                                            class=" apply_button bg-green-600 basis-36 w-[9rem] text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 hover:scale-105 duration-300 transition-all">
                                            Apply
                                        </button>
                
                             ';
                                                }
                                            }
                                            echo '
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                                        }
                                    } else {
                                        echo "<p class='text-gray-500 text-xl text-center'>No events found.</p>";
                                    }



                                    ?>

                                    <!-- More event cards would go here -->
                                </div>



                                <!-- Post LIST -->
                            </div>

                        <?php
                        } else {
                        ?>
                            <!-- Event Participation For Volunteer-->
                            <div id="dynamic_list1">
                                <!-- Events List -->
                                <div class="space-y-6">
                                    <!-- Event Card -->
                                    <?php

                                    $sql = "SELECT e.*, ea.status as applicunt_status, ea.date as date_of_application
                                    FROM events e
                                    JOIN events_application ea ON e.event_id = ea.event_id
                                    WHERE ea.volunteer_id = ?  ORDER BY ea.date DESC
                                    ";

                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $user_id2);
                                    $stmt->execute();
                                    $result3 = $stmt->get_result();


                                    if ($result3->num_rows > 0) {

                                        $rows = $result3->fetch_all(MYSQLI_ASSOC);
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
                                                                class="px-4 py-2 border hover:scale-105 transition-all duration-300 border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                                View Details
                                                            </button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php
                                        }
                                    } else {

                                        echo "
                                        <h1 class=' text-2xl font-semibold'>No EVent Found</h1>
                                        ";
                                    }
                                    ?>


                                    <!-- More event cards would go here -->
                                </div>
                            </div>

                        <?php
                        }
                        ?>


                        <!-- Post List -->
                        <div id="dynamic_list2" class="hidden">
                            <!-- Post List -->
                            <div class="space-y-2">
                                <!-- postCard -->
                                <?php
                                $sql = "SELECT p.user_id,u.name,u.user_name,u.user_type, u.profile_picture, p.picture_url,p.caption,p.upload_date,p.likes, p.picture_id FROM `pictures` p JOIN user u ON p.user_id=u.user_id 
                                        WHERE p.user_id = ? ORDER BY p.upload_date DESC";

                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $user_id2);
                                $stmt->execute();
                                $result2 = $stmt->get_result();



                                ?>
                                <?php

                                if ($result2->num_rows > 0) {

                                    $rows = $result2->fetch_all(MYSQLI_ASSOC);

                                    foreach ($rows as $row) {
                                        $username = $row['name'];
                                        $picture_creator_id = $row['user_id'];
                                        $user_name = $row['user_name'];
                                        $user_profile = $row['profile_picture'];
                                        $picture_id = $row['picture_id'];
                                        $picture_url = $row['picture_url'];
                                        $picture_url = preg_replace('/^\.\.\//', '', $picture_url);
                                        $picture_caption = $row['caption'];
                                        $picture_date = $row['upload_date'];
                                        $picture_likes = $row['likes'];
                                        $user_profile = preg_replace('/^\.\.\//', '', $user_profile);
                                        $comment_type = ($row['user_type'] == 'V') ? "Volunteer" : "Organisation";
                                        $comment_style = ($row['user_type'] == 'V') ? "bg-indigo-100 text-indigo-800" : "bg-green-100 text-green-800";

                                        $creation_date = new DateTime($picture_date);
                                        $today = new DateTime();
                                        $diff = $today->diff($creation_date);

                                        if (
                                            $diff->days == 0
                                        ) {
                                            $days_ago = "Today at: " . date("h:i A", strtotime($picture_date));
                                        } else {
                                            $days_ago = ($diff->days <= 10) ? "{$diff->days} days ago" : date('jS M y', strtotime($picture_date));
                                        }

                                ?>

                                        <!-- Can be Commented  animation-->

                                        <div
                                            class="mx-auto flex justify-center items-center filter blur-2xl animate-pulse duration-500 transition w-full">
                                            <div class="mt-2 mr-10 flex relative">
                                                <div
                                                    class="p-44 rounded-full bg-gradient-to-r to-indigo-700 from-pink-900 absolute top-20 right-0"></div>
                                                <div
                                                    class="p-44 rounded-full bg-gradient-to-r to-pink-700 from-indigo-900 absolute md:flex hidden"></div>
                                            </div>
                                            <!-- Right Side -->
                                            <div class="flex flex-col absolute top-8 right-10 space-y-4">
                                                <div
                                                    class="p-5 rounded-full bg-gradient-to-r to-pink-700 via-red-500 from-indigo-900 absolute right-16 top-10"></div>
                                            </div>
                                            <div class="flex flex-col absolute bottom-8 right-10 space-y-4">
                                                <div
                                                    class="p-10 rounded-full bg-gradient-to-r to-pink-700 from-indigo-900 absolute right-16 bottom-10"></div>
                                            </div>
                                            <!--  Left side -->
                                            <div
                                                class="flex flex-col space-y-2 filter animate-pulse duration-500">
                                                <div
                                                    class="p-10 bg-gradient-to-r to-indigo-700 from-blue-900 absolute top-20 left-20"></div>
                                                <div
                                                    class="p-10 bg-gradient-to-r to-indigo-700 from-blue-900 absolute bottom-20 right-20"></div>
                                            </div>
                                        </div>
                                        <!-- Can be Commented  end-->






                                        <!-- 1st Post  -->
                                        <div
                                            class="mx-auto flex justify-center max-w-4xl md:mb-8  bg-white rounded-lg items-center relative md:p-0 p-8"
                                            x-data="{
                                                    comment : false,
                                                }">
                                            <div class="h-full relative">
                                                <div class="py-2 px-2">
                                                    <div class="flex justify-between items-center py-2">
                                                        <div class="relative mt-1 flex">

                                                            <div class="mr-2 p-1">
                                                                <img
                                                                    src="<?= $user_profile ?>"
                                                                    alt="<?= $username ?>"
                                                                    class="w-10 h-10 rounded-full object-cover" />
                                                            </div>
                                                            <a onclick="window.location.href='view_post.php?id=<?= base64_encode($picture_id) ?>'">
                                                                <div class="ml-3 flex justify-start flex-col items-start">
                                                                    <p class="text-lg font-bold "><?= $username ?> <span class=" ml-2  text-sm <?= $comment_style ?> rounded-xl px-2 py-1"><?= $comment_type ?></span></p>
                                                                    <p class="text-gray-600 text-sm font-mono">@<?= $user_name ?></p>
                                                                </div>
                                                            </a>

                                                        </div>

                                                        <?php
                                                        if ($picture_creator_id == $user_id) {


                                                        ?>
                                                            <div class="flex space-x-2 mr-3 .action">
                                                                <button class="p-2 text-gray-400 hover:text-blue-600" onclick="window.location.href='edit_post.php?id=<?= base64_encode($picture_id) ?>'">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                                    </svg>
                                                                </button>
                                                                <button class="delete-post p-2 text-gray-400 hover:text-red-500" data-postid="<?= $picture_id ?>">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </div>

                                                        <?php
                                                        } else {
                                                            echo
                                                            '
                                                                <button
                                                                type="button" 
                                                                class="relative p-2 focus:outline-none border-none hover:bg-gray-100  rounded-full">
                                                                <svg
                                                                    class="w-5 h-5 text-gray-700 hover:text-pink-500"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    viewBox="0 0 24 24"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                                </svg>
                                                            </button>
                                                                ';
                                                        }

                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="relative w-full h-full">
                                                    <img
                                                        src="<?= $picture_url ?>"
                                                        alt="<?= $username ?>"
                                                        class="rounded-lg w-full h-full object-cover" />
                                                </div>
                                                <div class="">
                                                    <!-- Comment -->
                                                    <div
                                                        class="overflow-y-scroll w-full absolute inset-0 bg-white transform transition duration-200"
                                                        x-show="comment"
                                                        x-transition:enter="transition ease-out duration-200"
                                                        x-transition:enter-start="opacity-0 transform scale-90"
                                                        x-transition:enter-end="opacity-100 transform scale-100"
                                                        x-transition:leave="transition ease-in duration-100"
                                                        x-transition:leave-start="opacity-100 transform scale-100"
                                                        x-transition:leave-end="opacity-0 transform scale-90">
                                                        <div
                                                            class="flex justify-start items-center py-2 px-4 border-b"
                                                            @click="comment = !comment">
                                                            <svg
                                                                class="w-8 h-8 text-gray-700"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                viewBox="0 0 24 24"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="1.5"
                                                                    d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                                            </svg>
                                                            <div
                                                                class="text-xl w-full text-center p-4 font-semibold justify-between">
                                                                Comments
                                                            </div>
                                                        </div>

                                                        <div class="p-2 mb-10" id="comment_list_<?= $picture_id ?>">

                                                            <?php
                                                            // Calculate the average rating of the event
                                                            $sql = "SELECT COUNT(*) AS Total FROM `comments` WHERE picture_id=?";
                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->bind_param("i", $picture_id);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            $row = $result->fetch_assoc();
                                                            $comments_total = $row['Total'];




                                                            // // Fetch reviews from the database based on date_time order
                                                            $sql = "SELECT c.text,c.date_time,c.comment_id,u.user_id, u.name, u.profile_picture,
                                                            u.user_name,u.user_type FROM comments c JOIN user u ON c.user_id = u.user_id WHERE c.picture_id = ? ORDER BY `date_time` DESC";

                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->bind_param("i", $picture_id);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();

                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $comment_id = $row['comment_id'];
                                                                    $comment_text = $row['text'];
                                                                    $comment_date = $row['date_time'];
                                                                    $comment_user_id = $row['user_id'];
                                                                    $comment_name = $row['name'];
                                                                    $comment_user_name = $row['user_name'];
                                                                    $comment_user_profile = $row['profile_picture'];
                                                                    $comment_user_profile = preg_replace('/^\.\.\//', '', $comment_user_profile);
                                                                    $comment_user_style = ($row['user_type'] == 'O') ? "bg-indigo-100 " : "";
                                                                    $comment_creation_date = new DateTime($comment_date);
                                                                    $comment_today = new DateTime();
                                                                    $comment_diff = $comment_today->diff($comment_creation_date);
                                                                    if (
                                                                        $comment_diff->days == 0
                                                                    ) {
                                                                        $comment_days_ago = "Today at: " . date("h:i A", strtotime($comment_date));
                                                                    } else {
                                                                        $comment_days_ago = ($comment_diff->days <= 10) ? "{$comment_diff->days} days ago" : date('jS M y', strtotime($comment_date));
                                                                    }


                                                            ?>


                                                                    <!-- 1nd Comment -->
                                                                    <div
                                                                        class="flex justify-start <?= $comment_user_style ?> flex-col space-y-3 items-start px-2 border-b border-gray-300 rounded-sm">
                                                                        <div class="relative w-full mt-1 mb-3 pt-2 flex">
                                                                            <div class="mr-2">
                                                                                <img
                                                                                    src="<?= $comment_user_profile ?>"
                                                                                    alt="<?= $comment_name ?>"

                                                                                    class="w-12 h-12 rounded-full object-cover" />
                                                                            </div>
                                                                            <div class="ml-2 w-full">
                                                                                <p class="text-gray-600 md:text-lg text-xs w-full">
                                                                                    <!-- Username User -->
                                                                                    <span class=" text-gray-900 mr-2 font-mono">@<?= $comment_user_name ?></span>
                                                                                    <!-- Username Comment -->
                                                                                    <?= $comment_text ?>
                                                                                </p>
                                                                                <div class="time mt-1 text-gray-400 text-xs">
                                                                                    <p><?= $comment_days_ago ?></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                            <?php

                                                                }
                                                            } else {
                                                                echo "<h1 class='text-xl mt-10 text-center font-serif font-medium'>No Comments Available</h1>";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <!-- System Like and tools Feed -->
                                                    <div class="flex justify-between items-start p-2 py-">
                                                        <div class="flex space-x-2 items-center">
                                                            <button type="button" class=" heart2 focus:outline-none Like" data-pictureid=<?= $picture_id ?>>
                                                                <svg
                                                                    class="w-8 h-8 heart hover:fill-red-500 hover:text-red-500 text-gray-600"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    viewBox="0 0 24 24"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        stroke-width="1.6"
                                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                                </svg>
                                                            </button>
                                                            <button
                                                                type="button"
                                                                class="focus:outline-none Comment"
                                                                @click="comment = !comment">
                                                                <svg
                                                                    class="w-8 h-8 text-gray-600"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    viewBox="0 0 24 24"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        stroke-width="1.6"
                                                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                                </svg>
                                                            </button>
                                                            <button data-pictureid=<?= base64_encode($picture_id) ?> type="button" class=" whatsappShare focus:outline-none save">
                                                                <svg
                                                                    class="w-7 h-7 mb-1 ml-1 text-gray-600 z-10"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    viewBox="0 0 24 24"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        stroke-width="1.6"
                                                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="flex space-x-2 items-center">
                                                            <button type="button" class="focus:outline-none Like">
                                                                <svg
                                                                    class="w-8 h-8 text-gray-600"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    viewBox="0 0 24 24"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        stroke-width="1.6"
                                                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Post Details -->
                                                    <div class="p-2 ml-2 mr-2 flex flex-col space-y-3">
                                                        <div class="w-full">
                                                            <p class="font-bold text-lg text-gray-700" id="likes_<?= $picture_id ?>"><?= $picture_likes ?> likes</p>
                                                        </div>
                                                        <div class="text-base">
                                                            <?= $picture_caption ?>
                                                        </div>
                                                        <button onclick="window.location.href='view_post.php?id=<?= base64_encode($picture_id) ?>'">
                                                            <div id="comment_count_<?= $picture_id ?>" class="text-gray-500 leading-loose text-base font-semibold">
                                                                View all <?= $comments_total ?> comments
                                                            </div>
                                                        </button>
                                                        <div class="w-full">
                                                            <p class="text-base font-medium text-gray-400"><?= $days_ago ?></p>
                                                        </div>
                                                    </div>

                                                    <!-- Comment Input Field ans send button -->
                                                    <!-- End System Like and tools Feed  -->
                                                    <div class="z-50 hidden">
                                                        <form class="comment-form" data-post-id="<?= $picture_id ?>">
                                                            <div
                                                                class="flex justify-between border-t items-center w-full"
                                                                :class="comment ? 'absolute bottom-0' : '' ">
                                                                <div class="w-full">
                                                                    <input
                                                                        type="text"
                                                                        name="comment"
                                                                        id="comment"
                                                                        placeholder="Add A Comment..."
                                                                        class="comment-input w-full text-sm py-4 px-3 border-none outline-none rounded-none focus:border-none" />
                                                                </div>
                                                                <div class="w-20">
                                                                    <button
                                                                        class=" comment-submit border-none border-white text-sm px-4 bg-white py-4 text-indigo-600 focus:outline-none">
                                                                        <i class="bx bx-send text-3xl"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End 1st Post -->

                                <?php
                                    }
                                } else {
                                    echo '
                                    <h1 class=" text-3xl font-medium text-center mt-10">No Post Available</h1>
                                    ';
                                }
                                ?>

                                <!-- More post cards would go here -->
                            </div>
                        </div>



                    </div>
                </div>


            </div>




        </div>
        <!-- End Content -->

    </main>


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

    <!-- Nav Js AND EVENT APPLY -->
    <script>
        $(document).ready(function() {
            // Tab switching functionality with smooth transitions
            $('nav button').click(function() {
                // Remove active classes from all tabs
                $('nav button').removeClass('border-blue-500 text-blue-600').addClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');

                // Add active classes to clicked tab
                $(this).addClass('border-blue-500 text-blue-600').removeClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');
                let Type = $(this).data("status");
                // alert(Type);
                if (Type == "events") {
                    $("#dynamic_list1").removeClass("hidden");
                    $("#dynamic_list2").addClass("hidden");
                } else {
                    $("#dynamic_list1").addClass("hidden");
                    $("#dynamic_list2").removeClass("hidden");
                }
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


            $(".whatsappShare").click(function() {
                // let imgUrl = window.location.href; // Gets the current event page URL
                let picture_Id = $(this).data("pictureid"); // Replace with dynamic PHP variable
                // alert(picture_Id);
                // let whatsappUrl = `https://api.whatsapp.com/send?text=Check%20out%20this%20event!%20${encodeURIComponent(imgUrl)}`;
                // window.open(whatsappUrl, "_blank");

                let baseUrl = window.location.origin + "/volunteer-management-system/main/pages/view_post.php?id=" + picture_Id; // Encode ID in base64
                let whatsappUrl = `https://api.whatsapp.com/send?text=Check%20out%20This%20AmazingPost!%20${encodeURIComponent(baseUrl)}`;

                window.open(whatsappUrl, "_blank");


            });

            $(".heart").click(function() {
                //  alert('hello');
                $(".heart").removeClass("selected fill-red-500 text-red-500").addClass("text-gray-600");
                $(this).prevAll().addBack().addClass(" selected  fill-red-500 text-red-500").removeClass("text-gray-600");

            });

            $(".heart2").click(function() {
                //  alert('hello');
                let post = $(this).data("pictureid");
                //alert(post);
                let comment_likes = ("#likes_" + post);

                $.ajax({
                    url: "Backend/add_likes_comment.php", // Backend script to handle the comment
                    type: "POST",
                    data: {
                        post_id: post
                    },
                    dataType: "json", // Expect JSON response
                    success: function(response) {
                        if (response.status === 'success') {
                            // alert(response.message); // Show success message
                            // form.find(".comment-input").val(""); // Clear input field


                            $(comment_likes).html(`${response.like} likes`);
                            //location.reload(); // Reload the page after deletion
                        } else {
                            alert(response.message); // Show error message
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX Error: " + status + " " + error);
                        console.log("Server Response: " + xhr.responseText);
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
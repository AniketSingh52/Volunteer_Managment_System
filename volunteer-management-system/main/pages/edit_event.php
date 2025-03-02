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


if ($type == "Volunteer") {
    echo "<script>alert('You are not authorized to view this page.'); window.location.href='admin.php';</script>";
    exit;
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
            $from_date = date('Y-m-d', strtotime($row['from_date']));
            $to_date = date('Y-m-d', strtotime($row['to_date']));

            $from_time = $row['from_time'];
            $to_time = $row['to_time'];


            //Convert 24 Hour format to 12 Hour format
            // $from_time = date("h:i A", strtotime($from_time));
            // $to_time = date("h:i A", strtotime($to_time));

            $max_application = $row['maximum_application'];

            $description = $row['description'];
            $location = $row['location'];
            $volunteer_needed = $row['volunteers_needed'];

            $organization_id = $row['organization_id'];

            //to allow only the original organizer to edit
            $org_id =  $organization_id;

            if ($org_id != $user_id) {
                echo "<script>alert('You are not authorized to view this page.'); window.location.href='admin.php';</script>";
                exit;
            }


            $event_image = $row['poster'];
            $poster_path = $event_image;
            $event_image = preg_replace('/^\.\.\//', '', $event_image);
            $date_of_creation = date('Y-m-d', strtotime($row['date_of_creation']));
            $status = $row['status'];


            //Fetch Organizator Details using Organization ID
            $sql = "SELECT * FROM `user` WHERE user_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $organization_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $organization_name = $row['name'];
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Volunteer Management</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap");

        .transition-transform {
            transition-property: transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .multiselect-dropdown {
            height: 60px;
        }

        .placeholder {
            margin-left: 10px;
            text-align: center;
            justify-content: center;
            margin-top: 12px;
            color: #afafaf !important;
            font-weight: 600;

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

            <!-- Hero Section -->
            <div class="relative isolate overflow-hidden bg-gradient-to-b from-indigo-100/20">
                <div class="mx-auto max-w-7xl px-6 pt-2 pb-6 sm:pb-10 lg:flex lg:px-8 ">
                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl lg:flex-shrink-0 ">
                        <h1 class="mt-10 text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                            Edit Event
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600">
                            change the details of the event as per your needs.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="mx-auto max-w-7xl px-6 pb-24 lg:px-8">
                <form id="yourFormID" method="POST" enctype="multipart/form-data" action="edit_event.php" class="space-y-12">
                    <!-- Event Poster Section -->
                    <div class="bg-white rounded-2xl shadow-sm p-8 space-y-6">
                        <div class="border-b border-gray-200 pb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Event Poster</h2>
                            <p class="mt-1 text-sm text-gray-500">This will be the main image displayed for your event.</p>
                        </div>

                        <div class="flex justify-center">
                            <div class="relative group">
                                <label for="volunteer-profile-photo" class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-2 cursor-pointer">
                                    <i class="fas fa-camera text-white"></i>
                                </label>
                                <div class=" h-[200px] w-[300px] md:h-[400px] md:w-[600px] bg-gray-100 border-2 border-dashed border-gray-300 rounded-2xl overflow-hidden group-hover:border-indigo-500 transition-colors duration-300">
                                    <img id="preview-image" src="<?= $event_image ?>" class="profile-image w-full h-full object-cover">
                                    <div class="flex flex-col items-center justify-center h-full" id="upload-prompt">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-12h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 mt-4">
                                            <label for="volunteer-profile-photo" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                                <span>Upload a file</span>
                                                <input name="poster" type="file" id="volunteer-profile-photo" class="sr-only profile-input" accept="image/*">
                                                <input type="hidden" name="event_poster" value="<?= $poster_path ?>">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="bg-white rounded-2xl shadow-sm p-8 space-y-8">
                        <div class="border-b border-gray-200 pb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Basic Information</h2>
                            <p class="mt-1 text-sm text-gray-500">Provide the essential details about your event.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                            <!-- Organizer -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Organizer</label>
                                <input
                                    name="organizer"
                                    type="text"
                                    readonly
                                    value="<?= $organization_name ?>"
                                    class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div>

                            <!-- Creation Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date of Creation</label>
                                <input
                                    name="date_of_creation"
                                    type="date"
                                    value="<?= $date_of_creation ?>"
                                    readonly
                                    class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div>

                            <!-- Event Title -->
                            <!-- <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Event Title <span class="text-red-500">*</span>
                                </label>
                                <input type="hidden" name="event_id" value="<?= $event_id ?>">
                                <input
                                    value="<?= $event_name ?>"
                                    name="title"
                                    type="text"
                                    required
                                    placeholder="Enter a descriptive title for your event"
                                    class="mt-2 block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div> -->
                        </div>

                        <div class="flex gap-x-6 gap-y-8 ">

                            <!-- Event Title -->
                            <div class=" w-2/3">
                                <label class="block text-sm font-medium text-gray-700">
                                    Event Title <span class="text-red-500">*</span>
                                </label>
                                <input type="hidden" name="event_id" value="<?= $event_id ?>">
                                <input
                                    value="<?= $event_name ?>"
                                    name="title"
                                    type="text"
                                    required
                                    placeholder="Enter a descriptive title for your event"
                                    class="mt-2 block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div>
                            <!-- Status -->
                            <div class=" w-1/3">
                                <label class="block text-sm font-semibold  text-green-600">
                                    Status <span class="text-red-500">*</span>
                                </label>

                                <select name="status" required class="mt-2 block transition-all duration-300 w-full rounded-lg font-semibold bg-emerald-100/30 border-gray-300 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                                    <option value="Ongoing" <?php if ($status == "Ongoing") echo "Selected"; ?>>Ongoing</option>
                                    <option value="Scheduled" <?php if ($status == "Scheduled") echo "Selected"; ?>>Scheduled</option>
                                    <option value="Completed" <?php if ($status == "Completed") echo "Selected"; ?>>Completed</option>
                                    <option value="Cancelled" <?php if ($status == "Cancelled") echo "Selected"; ?>>Cancelled</option>

                                </select>

                            </div>
                        </div>
                    </div>

                    <!-- Date and Time -->
                    <div class="bg-white rounded-2xl shadow-sm p-8 space-y-8">
                        <div class="border-b border-gray-200 pb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Date and Time</h2>
                            <p class="mt-1 text-sm text-gray-500">Set when your event will take place.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                            <!-- From Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    From Date <span class="text-red-500">*</span>
                                </label>
                                <input
                                    value="<?= $from_date ?>"
                                    name="from_date"
                                    id="from_date"
                                    type="date"
                                    required

                                    class="mt-2 block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div>

                            <!-- To Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    To Date <span class="text-red-500">*</span>
                                </label>
                                <input
                                    value="<?= $to_date ?>"
                                    name="to_date"
                                    id="to_date"
                                    type="date"
                                    required
                                    readonly
                                    class="mt-2 block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div>

                            <!-- From Time -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    From Time <span class="text-red-500">*</span>
                                </label>
                                <input
                                    value="<?= $from_time ?>"
                                    name="from_time"
                                    id="from_time"
                                    type="time"
                                    required
                                    class="mt-2 block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div>

                            <!-- To Time -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    To Time <span class="text-red-500">*</span>
                                </label>
                                <input
                                    value="<?= $to_time ?>"
                                    name="to_time"
                                    id="to_time"
                                    type="time"
                                    required
                                    class="mt-2 block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div>
                        </div>

                        <!-- Calculated Fields -->
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-3 pt-6 border-t border-gray-200">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Number of Days</label>
                                <input
                                    id="no_of_days"
                                    type="text"
                                    readonly
                                    placeholder="Calculated automatically"
                                    class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-3 px-4 text-gray-900 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total Time</label>
                                <input
                                    name="total_time"
                                    id="total_time"
                                    type="text"
                                    readonly
                                    placeholder="Calculated automatically"
                                    class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 py-3 px-4 text-gray-900 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Maximum Applications
                                    <span class="text-sm font-normal text-gray-500">(Optional)</span>
                                </label>
                                <input
                                    name="max_application"
                                    type="number"
                                    value="<?= $max_application ?>"
                                    min="1"
                                    class="mt-2 block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Location and Volunteers -->
                    <div class="bg-white rounded-2xl shadow-sm p-8 space-y-8">
                        <div class="border-b border-gray-200 pb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Location and Participation</h2>
                            <p class="mt-1 text-sm text-gray-500">Specify where the event will take place and how many volunteers you need.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Location <span class="text-red-500">*</span>
                                </label>
                                <input
                                    value="<?= $location ?>"
                                    name="location"
                                    type="text"
                                    required
                                    placeholder="Enter the event location"
                                    class="mt-2 block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Volunteers Needed <span class="text-red-500">*</span>
                                </label>
                                <input
                                    value="<?= $volunteer_needed ?>"
                                    name="volunteer_need"
                                    type="number"
                                    required
                                    min="1"
                                    placeholder="Number of volunteers needed"
                                    class="mt-2 block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Causes and Skills -->
                    <div class="bg-white rounded-2xl shadow-sm p-8 space-y-8">
                        <div class="border-b border-gray-200 pb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Causes and Skills</h2>
                            <p class="mt-1 text-sm text-gray-500">Select relevant causes and required skills for your event.</p>
                        </div>

                        <div class="space-y-8">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-4">
                                    Causes <span class="text-sm font-normal text-gray-500">(Tags)</span>
                                </label>

                                <?php

                                $selected_causes = []; // Replace with your query logic. For example:
                                $query_selected = "SELECT cause_id FROM event_has_causes WHERE event_id = ?";
                                $stmt = $conn->prepare($query_selected);
                                $stmt->bind_param("i", $event_id);
                                $stmt->execute();
                                $result_selected = $stmt->get_result();
                                while ($row = $result_selected->fetch_assoc()) {
                                    $selected_causes[] = $row['cause_id'];
                                }
                                ?>


                                <select
                                    name="cause[]"
                                    multiple
                                    required
                                    multiselect-search="true"
                                    multiselect-select-all="true"
                                    multiselect-max-items="5"
                                    multiselect-hide-x="false"
                                    class="block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600">
                                    <?php
                                    $query = "SELECT * FROM causes";
                                    $result = $conn->query($query);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            // Check if the current cause_id is in the selected_causes array
                                            $selected = in_array($row['cause_id'], $selected_causes) ? 'selected' : '';
                                            echo '<option value="' . $row['cause_id'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No Cause Available</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-4">
                                    Required Skills <span class="text-sm font-normal text-gray-500">(At least one)</span>
                                </label>


                                <?php

                                $selected_skills = []; // Replace with your query logic. For example:
                                $query_selected = "SELECT skill_id FROM event_req_skill WHERE event_id = ?";
                                $stmt = $conn->prepare($query_selected);
                                $stmt->bind_param("i", $event_id);
                                $stmt->execute();
                                $result_selected = $stmt->get_result();
                                while ($row = $result_selected->fetch_assoc()) {
                                    $selected_skills[] = $row['skill_id'];
                                }
                                ?>

                                <select
                                    name="skill[]"
                                    multiple
                                    required
                                    multiselect-search="true"
                                    multiselect-select-all="true"
                                    multiselect-max-items="5"
                                    multiselect-hide-x="false"
                                    class="block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600">
                                    <?php
                                    $query = "SELECT * FROM skill";
                                    $result = $conn->query($query);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            // Check if the current cause_id is in the selected_causes array
                                            $selected = in_array($row['skill_id'], $selected_skills) ? 'selected' : '';
                                            echo '<option value="' . $row['skill_id'] . '" ' . $selected . ' >' . $row['skill_name'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No Skill Available</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-white rounded-2xl shadow-sm p-8 space-y-8">
                        <div class="border-b border-gray-200 pb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Event Description</h2>
                            <p class="mt-1 text-sm text-gray-500">Provide detailed information about your event.</p>
                        </div>

                        <div>
                            <label class="sr-only">Description</label>
                            <textarea
                                name="Description"

                                required
                                rows="6"
                                placeholder="Describe your event in detail..."
                                class="block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 sm:text-sm"><?= htmlspecialchars($description) ?></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center">
                        <button
                            type="submit"
                            name="submit"
                            class="inline-flex justify-center rounded-lg bg-indigo-600 px-12 py-4 text-lg font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all duration-200 transform hover:-translate-y-0.5">
                            Edit Event
                        </button>
                    </div>
                </form>
            </div>
        </div>

        </div>
        <!-- End Content -->





    </main>




    <!-- Footer -->
    <?php include('../layouts/footer.php'); ?>




    <script src="../../js/multiselect-dropdown.js">
    </script>






    <!-- Js for Form Hide and show and Profile Photo Change on File select -->
    <script>
        function calculateDays() {
            const fromDate = document.getElementById("from_date").value;
            const toDate = document.getElementById("to_date").value;

            if (fromDate && toDate) {
                const from = new Date(fromDate);
                const to = new Date(toDate);
                const timeDiff = to - from;
                const daysDiff = timeDiff / (1000 * 60 * 60 * 24) + 1; // Adding 1 to include the start date

                document.getElementById("no_of_days").value = daysDiff > 0 ? daysDiff : 0;
            } else {
                document.getElementById("no_of_days").value = "";
            }
        }

        function setMinToDate() {
            const fromDate = document.getElementById("from_date").value;
            const toDate = document.getElementById("to_date");

            if (fromDate) {
                toDate.min = fromDate;
                toDate.disabled = false; // Enable the "to_date" field
            } else {
                toDate.value = ""; // Clear the "to_date" field
                toDate.disabled = true; // Disable the "to_date" field
            }

            calculateDays();
        }

        function calculateTotalTime() {
            const fromDate = document.getElementById("from_date").value;
            const toDate = document.getElementById("to_date").value;
            const fromTime = document.getElementById("from_time").value;
            const toTime = document.getElementById("to_time").value;
            const totalTimeInput = document.getElementById("total_time");

            // Clear the field if any value is missing
            if (!fromDate || !toDate || !fromTime || !toTime) {
                totalTimeInput.value = "";
                return;
            }

            // Calculate total days
            const startDate = new Date(fromDate);
            const endDate = new Date(toDate);
            const totalDays = Math.round((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1; // Ensure correct day count

            // Calculate total time per day
            const [fromHours, fromMinutes] = fromTime.split(":").map(Number);
            const [toHours, toMinutes] = toTime.split(":").map(Number);

            let totalMinutes = (toHours * 60 + toMinutes) - (fromHours * 60 + fromMinutes);

            if (totalMinutes < 0) {
                totalTimeInput.value = ""; // Reset if invalid time range
                alert("Invalid Time: 'To Time' must be greater than 'From Time'");
                return;
            }

            // Multiply by total days
            const totalVolunteeringMinutes = totalMinutes * totalDays;
            let hours = Math.floor(totalVolunteeringMinutes / 60);
            let minutes = totalVolunteeringMinutes % 60;

            // Format time in HH:mm (valid input format)
            hours = hours.toString().padStart(2, '0'); // Ensure 2-digit format
            minutes = minutes.toString().padStart(2, '0');

            totalTimeInput.value = `${hours}:${minutes}`; // Store in HH:mm format
        }

        calculateDays();
        calculateTotalTime();


        $(document).ready(function() {
            // Image preview

            var poster_change = false;

            $('#volunteer-profile-photo').change(function(e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-image').attr('src', e.target.result);
                        $('#upload-prompt').addClass('hidden');
                    }
                    reader.readAsDataURL(e.target.files[0]);
                    poster_change = true;
                }
            });

            // Enable to_date when from_date is selected
            $('#from_date').change(function() {
                $('#to_date').prop('readonly', false).attr('min', $(this).val());
            });

            // Calculate number of days and total time
            function calculateDays() {
                const fromDate = $('#from_date').val();
                const toDate = $('#to_date').val();
                if (fromDate && toDate) {
                    const diff = Math.floor((new Date(toDate) - new Date(fromDate)) / (1000 * 60 * 60 * 24)) + 1;
                    $('#no_of_days').val(diff + ' day' + (diff > 1 ? 's' : ''));
                }
            }

            $("#yourFormID").submit(function(e) {

                // Check if the listener has already been added to prevent duplication
                const form = document.getElementById("yourFormID");
                e.preventDefault(); // Prevent default form submission

                //var formData = $(this).serialize(); // Serialize form data

                let formData = new FormData(form);

                // // Log form data to console
                // console.log("Form data:");
                // for (let [key, value] of formData.entries()) {
                //     console.log(`${key}: ${value}`);
                // }

                if (poster_change) {
                    // Log form data to console
                    console.log("Form data:");
                    for (let [key, value] of formData.entries()) {
                        console.log(`${key}: ${value}`);
                    }

                    //   Send AJAX request
                    $.ajax({
                        url: "Backend/edit_event.php", // Update with your correct path to dl.php
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false, // Prevent jQuery from processing data
                        contentType: false, // Let browser set the correct content type
                        dataType: 'json', // Expect a JSON response
                        success: function(response) {
                            if (response.status === 'success') {
                                alert(response.message); // Show success message
                                //form.submit();
                                window.location.href = 'my_events.php';
                                //form.reset(); // Reset the form
                                //loadContent('dl');
                            } else {
                                alert(response.message); // Show error message if any
                                // loadContent('dl');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error: " + status + " " + error);
                            alert("AJAX Error: " + status + " " + error);
                        }
                    });

                } else {

                    formData.delete("poster");
                    // Log form data to console
                    console.log("Form data:");
                    for (let [key, value] of formData.entries()) {
                        console.log(`${key}: ${value}`);
                    }
                    //   Send AJAX request
                    $.ajax({
                        url: "Backend/edit_event.php", // Update with your correct path to dl.php
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false, // Prevent jQuery from processing data
                        contentType: false, // Let browser set the correct content type
                        dataType: 'json', // Expect a JSON response
                        success: function(response) {
                            if (response.status === 'success') {
                                alert(response.message); // Show success message
                                //form.submit();
                                window.location.href = 'my_events.php';
                               // form.reset(); // Reset the form
                                //loadContent('dl');
                            } else {
                                alert(response.message); // Show error message if any
                                // loadContent('dl');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error: " + status + " " + error);
                            console.log("Server Response: " + xhr.responseText); // Logs the actual server response
                        }
                    });

                }


            });







            // $(".profile-input").change(function(e) {
            //     var file = e.target.files[0];
            //     var reader = new FileReader();
            //     reader.onload = function(event) {
            //         var img = $(e.target).closest('.relative').find('.profile-image');
            //         var icon = $(e.target).closest('.relative').find('.upload-prompt');
            //         img.attr('src', event.target.result);
            //         img.show();
            //         icon.hide();
            //     }
            //     reader.readAsDataURL(file);
            // });

            $("#from_date").change(function() {
                $(this).attr("min", "<?= date('Y-m-d') ?>"); // Ensure min date is always set
                setMinToDate()
                calculateTotalTime();
            });
            // $("#from_date").focus(function() {
            //     $(this).attr("min", "<?= date('Y-m-d') ?>"); // Ensure min date is always set
            //     setMinToDate()
            //     calculateTotalTime();
            // });
            $("#to_date").change(function() {

                calculateDays()
                calculateTotalTime();
            });
            $("#from_time").change(function() {
                calculateTotalTime();
            });
            $("#to_time").change(function() {
                calculateTotalTime();
            });

        });
    </script>
    <script src="https://unpkg.com/@popperjs/core@2">
    </script>
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
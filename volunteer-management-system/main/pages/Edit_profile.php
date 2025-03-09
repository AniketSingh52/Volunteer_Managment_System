<?php include("../../config/connect.php"); ?>

<?php
session_start();
ob_clean(); // Cle // Return JSON response
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');
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

    if ($user_id2 != $user_id) {
        echo "<script>alert('You are not authorized.'); window.location.href='admin.php';</script>";
    }

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
            $name2 = $row['name'];
            $address = $row['address'];
            $user_image = $row['profile_picture'];
            $poster_path = $user_image;
            $user_type = $row['user_type'] == "V" ? "Volunteer" : "Organisation";
            $user_name_style = ($row['user_type'] == 'V') ? "bg-green-100 hover:bg-green-800/90 text-green-800 hover:text-white  duration-300 transition-all" : "bg-sky-100 hover:bg-sky-800/90 font-medium hover:text-white  duration-300 transition-all text-sky-800";

            $user_image = preg_replace('/^\.\.\//', '', $user_image);

            //Convert Date to Human Readable Format
            $dob_doe = date('Y-m-d', strtotime($row['DOB/DOE']));
            $dor = date('Y-m-d', strtotime($row['registration_date']));


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
                <form id="yourFormID" method="POST" enctype="multipart/form-data" action="Edit_profile.php" class="space-y-8">
                    <!-- Cover & Profile Photo Section -->
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                        <!-- Cover Photo -->
                        <div class="relative h-48">
                            <img
                                id="cover-preview"
                                src="https://res.cloudinary.com/omaha-code/image/upload/ar_4:3,c_fill,dpr_1.0,e_art:quartz,g_auto,h_396,q_auto:best,t_Linkedin_official,w_1584/v1561576558/mountains-1412683_1280.png"
                                alt="Cover Photo"
                                class="w-full h-full object-cover">
                            <!-- <label class="absolute bottom-4 right-4 bg-black/50 hover:bg-black/70 text-white px-4 py-2 rounded-lg cursor-pointer flex items-center space-x-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Change Cover</span>
                                <input type="file" id="cover-input" class="hidden" accept="image/*">
                            </label> -->
                        </div>

                        <!-- Profile Section -->
                        <div class="px-8 pb-8">
                            <div class="relative flex w-full">
                                <!-- Profile Photo -->
                                <div class="flex flex-1">
                                    <div class="relative" style="margin-top: -4rem;">
                                        <div class="relative group">
                                            <img
                                                id="profile-preview"
                                                src="<?= $user_image ?>"
                                                alt="Profile Picture"
                                                class="h-32 w-32 rounded-full object-cover border-4 border-white shadow-lg">
                                            <label class="absolute bottom-2 right-2 bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg cursor-pointer transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <input name="poster" type="file" id="profile-input" class="hidden" accept="image/*">
                                                <input type="hidden" name="user_poster" value="<?= $poster_path ?>">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Basic Info Fields -->
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input
                                        type="text"
                                        name="fullName"
                                        value="<?= $name2 ?>"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <input type="hidden" name="user_id" value="<?= $user_id2 ?>">
                                </div>
                                <div>
                                    <label class="block text-sm  font-medium text-gray-700 mb-2">Username</label>
                                    <input
                                        disabled
                                        type="text"
                                        name="username"
                                        value="@<?= $user_name ?>"
                                        class="w-full font-mono px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Address/Location</label>
                                    <textarea
                                        name="address"
                                        rows="3"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?= $address ?></textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="bg-white rounded-2xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Personal Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth / Date of Establishment</label>
                                <input
                                    type="date"
                                    name="dob"
                                    value="<?= $dob_doe ?>"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>



                            <?php
                            if ($user_type != "Volunteer") {
                                $sql = "SELECT type_id FROM `organization_belongs_type` WHERE user_id=?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $user_id2);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $type_id = $row['type_id'];

                            ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Organization Type</label>
                                    <select
                                        name="organ_type"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <?php

                                        $sql2 = "SELECT * FROM organization_type";
                                        $result3 = $conn->query($sql2);

                                        if ($result3->num_rows > 0) {
                                            while ($row = $result3->fetch_assoc()) { // Loop through all rows
                                                echo "<option value='" . $row['type_id'] . "' " . (($type_id == $row['type_id']) ? "selected" : "") . ">" . $row['type_name'] . "</option>";
                                            }
                                        }


                                        ?>
                                    </select>
                                </div>

                            <?php
                            } else {

                            ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                    <input
                                        disabled
                                        type="input"
                                        name="gender"
                                        value="<?= $gender_text ?>"
                                        class="w-full px-4 bg-gray-100 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            <?php
                            }
                            ?>


                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date Of Joining</label>
                                <input
                                    disabled
                                    type="date"
                                    name="doj"
                                    value="<?= $dor ?>"
                                    class="w-full px-4  bg-gray-100 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Account Type</label>
                                <input type="hidden" name="type_user" value="<?= $user_type ?>">
                                <select
                                    disabled
                                    name="accountType"
                                    class="w-full px-4 py-2  bg-gray-100 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="volunteer" <?= (($user_type == "Volunteer") ? "selected" : "") ?>>Volunteer</option>
                                    <option value="organization" <?= (($user_type != "Volunteer") ? "selected" : "") ?>>Organization</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white rounded-2xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input
                                    disabled
                                    type="email"
                                    name="email"
                                    value="<?= $email ?>"
                                    class="w-full bg-gray-100 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input
                                    type="tel"
                                    name="phone"
                                    value="<?= $contact ?>"
                                    placeholder="+91 (555) 000-0000"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>


                        </div>
                    </div>



                    <!-- Skills & Interests -->
                    <div class="bg-white rounded-2xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Preferences and Interests</h2>
                        <div class="space-y-6">

                            <?php
                            if ($user_type == "Volunteer") {

                                $selected_skills = []; // Replace with your query logic. For example:
                                $query_selected = "SELECT skill_id FROM volunteer_skill WHERE user_id = ?";
                                $stmt = $conn->prepare($query_selected);
                                $stmt->bind_param("i", $user_id2);
                                $stmt->execute();
                                $result_selected = $stmt->get_result();
                                while ($row = $result_selected->fetch_assoc()) {
                                    $selected_skills[] = $row['skill_id'];
                                }

                            ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Skills</label>
                                    <select
                                        name="skill[]"
                                        multiple
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <?php
                                        $query = "SELECT * FROM skill";
                                        $result = $conn->query($query);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                // Check if the current cause_id is in the selected_causes array
                                                $selected = in_array($row['skill_id'], $selected_skills) ? 'selected' : '';
                                                echo '<option value="' . $row['skill_id'] . '" ' . $selected . '>' . $row['skill_name'] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">No Cause Available</option>';
                                        }
                                        ?>
                                    </select>

                                </div>


                            <?php
                            }
                            $selected_causes = []; // Replace with your query logic. For example:
                            $query_selected = "SELECT cause_id FROM user_workfor_causes WHERE user_id = ?";
                            $stmt = $conn->prepare($query_selected);
                            $stmt->bind_param("i", $user_id2);
                            $stmt->execute();
                            $result_selected = $stmt->get_result();
                            while ($row = $result_selected->fetch_assoc()) {
                                $selected_causes[] = $row['cause_id'];
                            }
                            ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Causes</label>
                                <select
                                    name="causes[]"
                                    multiple
                                    required
                                    multiselect-search="true"
                                    multiselect-select-all="true"
                                    multiselect-max-items="5"
                                    multiselect-hide-x="false"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4">
                        <button
                            type="button"
                            onclick="window.location.href='profile2.php'"
                            class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <script>
                $(document).ready(function() {
                    // Profile Image Preview
                    var poster_change = false;
                    $('#profile-input').change(function(e) {
                        if (e.target.files && e.target.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                $('#profile-preview').attr('src', e.target.result);
                            }
                            reader.readAsDataURL(e.target.files[0]);
                        }
                        poster_change = true;
                    });

                    // Cover Image Preview
                    $('#cover-input').change(function(e) {
                        if (e.target.files && e.target.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                $('#cover-preview').attr('src', e.target.result);
                            }
                            reader.readAsDataURL(e.target.files[0]);
                        }
                    });

                    // Form Submission
                    $('#yourFormID').submit(function(e) {

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
                                url: "Backend/edit_profile.php", // Update with your correct path to dl.php
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
                                        window.location.href = 'profile2.php';
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
                                url: "Backend/edit_profile.php", // Update with your correct path to dl.php
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
                                        // window.location.href = 'profile2.php';
                                        history.back();
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
    <script src="../../js/multiselect-dropdown.js"></script>

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
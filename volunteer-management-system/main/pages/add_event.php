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

                <div class="relative isolate flex flex-col overflow-hidden py-2 h-48 mx-auto w-full items-center justify-center">
                    <!-- Background Image -->
                    <img src="https://d1dbgh6ga9ets8.cloudfront.net/wp-content/uploads/2024/05/papercut-volunteers-group-raising-hand-up-with-love-heart-vector_1017-48257.jpg"
                        alt="Background Image"
                        class="absolute inset-0 h-full w-full object-cover brightness-75 -z-10" />

                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-800/60 via-gray-900/20 -z-10"></div>

                    <!-- White Ring Effect -->
                    <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-white/10 -z-10"></div>

                    <!-- Text Container (Ensure it's above everything) -->
                    <div class="relative text-center z-20">
                        <h1 class="md:text-7xl text-5xl font-bold tracking-tight text-white sm:text-6xl text-center px-[20px] drop-shadow-lg">
                            Event Creation
                        </h1>
                    </div>
                </div>

                <!--Casual Leave Form-->

                <div class="mx-auto w-full px-12 py-6 rounded-lg bg-white">
                    <!-- <div class=" text-center align-middle text-2xl font-semibold m-5 dark:text-black text-black">Event Creation</div> -->

                    <form id="yourFormID" method="POST" enctype="multipart/form-data" action="add_event.php">

                        <div class="-mx-3 grid md:grid-cols-2">

                            <!--Event Photo-->
                            <div class="row-span-3 ">
                                <label for="volunteer-profile-photo" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Event Poster <span class=" font-semibold text-red-600 text-2xl">*</span>
                                </label>

                                <div class="flex mt-2 mb-2 justify-center w-full px-3 ">
                                    <div class="relative">
                                        <div class=" h-64 w-72  bg-gray-200 border-gray-500  border-2  shadow-md flex items-center justify-center overflow-hidden">
                                            <i class="fas fa-user text-4xl text-gray-400 profile-icon"></i>
                                            <img class="profile-image w-full h-full object-cover" style="display: none;" alt="Profile Image">
                                        </div>
                                        <label for="volunteer-profile-photo" class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-2 cursor-pointer">
                                            <i class="fas fa-camera text-white"></i>
                                            <input name="poster" required type="file" id="volunteer-profile-photo" class="hidden profile-input" accept="image/*">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!--Organizer-->
                            <div class="w-full px-3 ">
                                <div class="mb-5">
                                    <label for="organizer" class="mb-3 block text-base font-medium text-[#07074D]">
                                        Organizer
                                    </label>
                                    <input name="organizer" type="text" id="date_of_letter" readonly placeholder="Organizer" value="<?php echo $name; ?>"
                                        class=" disabled:opacity-40 disabled:border-gray-400 w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />


                                </div>
                            </div>
                            <!--DATE of Creation-->
                            <div class="w-full px-3 ">
                                <div class="mb-5">
                                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                                        Date Of Creation
                                    </label>
                                    <input

                                        name="date_of_creation"
                                        type="date"
                                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                        value="<?php echo date('Y-m-d'); ?>"
                                        readonly />
                                </div>

                            </div>

                            <!--Title Of THe Event-->
                            <div class="w-full px-3 ">
                                <div class="mb-5">
                                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                                        Title Of The Event<span class=" font-semibold text-red-600 text-2xl">*</span>
                                    </label>
                                    <input
                                        required
                                        name="title"
                                        type="text"
                                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                        placeholder="Title Of The Event" />
                                </div>

                            </div>
                        </div>


                        <div class="-mx-3 flex flex-wrap">

                            <!-- From DATE -->
                            <div class="w-full px-3 md:w-1/2">
                                <div class="mb-5">
                                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                                        From-Date <span class="font-semibold text-red-600 text-2xl">*</span>
                                    </label>
                                    <input name="from_date" id="from_date" required type="date"
                                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                        min="<?php echo date('Y-m-d'); ?>" />
                                </div>
                            </div>

                            <!-- To DATE -->
                            <div class="w-full px-3 md:w-1/2">
                                <div class="mb-5">
                                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                                        To-Date <span class="font-semibold text-red-600 text-2xl">*</span>
                                    </label>
                                    <input disabled name="to_date" id="to_date" required type="date"
                                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                </div>
                            </div>
                        </div>



                        <div class="-mx-3 flex flex-wrap">
                            <!-- From Time -->
                            <div class="w-full px-3 md:w-1/2">
                                <div class="mb-5">
                                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                                        From-Time <span class="font-semibold text-red-600 text-2xl">*</span>
                                    </label>
                                    <input name="from_time" id="from_time" required type="time"
                                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                </div>
                            </div>

                            <!-- To Time -->
                            <div class="w-full px-3 md:w-1/2">
                                <div class="mb-5">
                                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                                        To-time <span class="font-semibold text-red-600 text-2xl">*</span>
                                    </label>
                                    <input name="to_time" id="to_time" required type="time"
                                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                </div>
                            </div>
                        </div>


                        <!-- Total Days, Total Time , max Applications -->
                        <div class="-mx-3 flex flex-wrap">
                            <!-- Total No Of Days -->
                            <div class="w-full px-3 md:w-1/3">
                                <div class="mb-5">
                                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                                        No. Of Volunteer Days
                                    </label>
                                    <input placeholder="Total Days" type="text" id="no_of_days" disabled
                                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                </div>

                            </div>

                            <!-- Total Time -->
                            <div class="w-full px-3 md:w-1/3">
                                <div class="mb-5">
                                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                                        Total Volunteering Time
                                    </label>
                                    <input placeholder="Total Time " name="total_time" id="total_time" type="text" disabled
                                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                </div>
                            </div>
                            <!-- Maximum Applicants -->
                            <div class="w-full px-3 md:w-1/3">
                                <div class="mb-5">
                                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                                        Maxiumum Applicantion<span class="font-semibold text-gray-600 text-sm ml-1">(Optional)</span>
                                    </label>
                                    <input name="max_application" id="max_application" required type="number" value="50"
                                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                </div>
                            </div>
                        </div>

                        <div class="-mx-3 flex flex-wrap">
                            <!-- Location -->
                            <div class="w-full px-3 md:w-1/2">
                                <div class="mb-5">
                                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                                        Location <span class="font-semibold text-red-600 text-2xl">*</span>
                                    </label>
                                    <input name="location" id="location" required type="text" placeholder="Kelkar clg, Mulund"
                                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                </div>
                            </div>

                            <!-- Volunteer Needed -->
                            <div class="w-full px-3 md:w-1/2">
                                <div class="mb-5">
                                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                                        Volunteer Needed<span class="font-semibold text-red-600 text-2xl">*</span>
                                    </label>
                                    <input placeholder="No. Of Volunteer Needed" name="volunteer_need" id="volunteer_need" required type="number"
                                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                </div>
                            </div>
                        </div>


                        <!--Description-->
                        <div class="mb-5">
                            <label class="mb-3 block text-base font-medium text-[#07074D]">
                                Description <span class=" font-semibold text-red-600 text-2xl">*</span>
                            </label>
                            <textarea required name="Description" required placeholder="About The Event" id="Description"
                                class="w-full  rounded-md border border-[#e0e0e0] bg-white py-6 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"></textarea>
                        </div>




                        <div class=" text-center rounded-lg">
                            <input type="submit" value="Create" name="submit"
                                class="hover:shadow-form w-1/3 rounded-md bg-[#1f7d37] py-3 px-8 text-center text-base font-semibold tracking-widest text-white outline-none hover:bg-teal-800" />
                        </div>

                    </form>
                </div>


            </div>

        </div>
        <!-- End Content -->





    </main>




    <!-- Footer -->
    <?php include('../layouts/footer.php'); ?>



    <script>
        $(document).ready(function() {
            $("#yourFormID").submit(function(e) {

                // Check if the listener has already been added to prevent duplication
                const form = document.getElementById("yourFormID");
                e.preventDefault(); // Prevent default form submission

                //var formData = $(this).serialize(); // Serialize form data

                let formData = new FormData(form);

                // Log form data to console
                console.log("Form data:");
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }
                //   Send AJAX request
                $.ajax({
                    url: "Backend/add_event.php", // Update with your correct path to dl.php
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
                            form.reset();// Reset the form
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
            });
        });
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


        $(document).ready(function() {

            $(".profile-input").change(function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();
                reader.onload = function(event) {
                    var img = $(e.target).closest('.relative').find('.profile-image');
                    var icon = $(e.target).closest('.relative').find('.profile-icon');
                    img.attr('src', event.target.result);
                    img.show();
                    icon.hide();
                }
                reader.readAsDataURL(file);
            });

            $("#from_date").change(function() {

                setMinToDate()
                calculateTotalTime();
            });
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
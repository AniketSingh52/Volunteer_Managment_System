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

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <!-- Event Header -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-12">
                    <div class="relative h-[500px]">
                        <img
                            src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=2000"
                            alt="Community Garden Clean-up"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-12 text-white max-w-3xl">
                            <div class="flex items-center space-x-6 mb-6">
                                <img
                                    src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&q=80&w=150"
                                    alt="Organizer"
                                    class="w-20 h-20 rounded-full border-4 border-white object-cover shadow-xl">
                                <div>
                                    <h3 class="text-xl font-semibold mb-1">Green Earth Initiative</h3>
                                    <p class="text-base opacity-90">Environmental Organization</p>
                                </div>
                            </div>
                            <h1 class="text-5xl font-bold mb-4 leading-tight">Community Garden Clean-up</h1>
                            <div class="flex items-center space-x-4">
                                <span class="bg-green-500/90 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-semibold shadow-lg">Ongoing</span>
                                <span class="bg-white/20 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-medium">10 days remaining</span>
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
                                        <p class="text-gray-700 font-semibold">March 20, 2024 </p>
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
                                        <p class="text-gray-700 font-semibold">09:00 AM - 02:00 PM</p>
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
                                        <p class="text-gray-700 font-semibold">Central Community Garden</p>
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
                                        <p class="text-green-500 font-semibold">0/10 Spots</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-10">
                                <div>
                                    <h3 class="text-xl font-bold mb-4 text-gray-900">About This Event</h3>
                                    <p class="text-gray-600 leading-relaxed text-lg">
                                        Join us in maintaining our community garden. Help plant new vegetables and maintain existing beds.
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex esse autem accusamus iste dolore amet
                                        sint magni ad, quas et, ratione doloribus modi nam unde tempore officiis ea. Quod, quae?
                                    </p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-bold mb-4 text-gray-900">Tags</h3>
                                    <div class="flex flex-wrap gap-3">
                                        <span class="bg-amber-100 text-amber-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-amber-200 cursor-pointer">Animal Rescue</span>
                                        <span class="bg-violet-100 text-violet-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-violet-200 cursor-pointer">Social Awareness</span>
                                        <span class="bg-rose-100 text-rose-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-rose-200 cursor-pointer">Clean-Up Drives</span>
                                        <span class="bg-emerald-100 text-emerald-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-emerald-200 cursor-pointer">Education Tour</span>
                                        <span class="bg-fuchsia-100 text-fuchsia-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-fuchsia-200 cursor-pointer">Donation Collection</span>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-xl font-bold mb-4 text-gray-900">Required Skills</h3>
                                    <div class="flex flex-wrap gap-3">
                                        <span class="bg-lime-100 text-lime-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-lime-200 cursor-pointer">Communication</span>
                                        <span class="bg-sky-100 text-sky-800 rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 hover:bg-sky-200 cursor-pointer">Management</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Section -->
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex items-center justify-between mb-8">
                                <h2 class="text-3xl font-bold">Reviews</h2>
                                <div class="flex items-center space-x-2">
                                    <span class="text-3xl font-bold text-gray-900">4.8</span>
                                    <div>
                                        <div class="flex text-yellow-400 text-sm">★★★★★</div>
                                        <span class="text-sm text-gray-500">128 reviews</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Add Review -->
                            <div class="mb-10 border-b pb-10">
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
                            </div>

                            <!-- Review List -->
                            <div class="space-y-8">
                                <!-- Review 1 -->
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

                                <!-- Review 2 -->
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
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-8">
                        <!-- Action Card -->
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex flex-col space-y-4">
                                <button
                                    class="w-full bg-green-600 text-white px-8 py-4 rounded-xl hover:bg-green-700 
                       transition-all duration-200 font-bold text-lg hover:shadow-lg transform hover:-translate-y-0.5">
                                    Apply Now
                                </button>
                                <button
                                    class="w-full bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 
                       transition-all duration-200 font-bold text-lg hover:shadow-lg transform hover:-translate-y-0.5">
                                    Contact Organizer
                                </button>
                            </div>
                        </div>

                        <!-- Organization Card -->
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <h3 class="text-2xl font-bold mb-6">About the Organizer</h3>
                            <div class="flex items-center space-x-4 mb-6">
                                <img
                                    src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&q=80&w=150"
                                    alt="Organizer"
                                    class="w-20 h-20 rounded-full object-cover border-4 border-gray-100 shadow-md">
                                <div>
                                    <h4 class="text-lg font-bold">Green Earth Initiative</h4>
                                    <p class="text-gray-600">Environmental Organization</p>
                                </div>
                            </div>
                            <p class="text-gray-600 text-lg leading-relaxed mb-6">
                                Green Earth Initiative is dedicated to environmental conservation and community engagement.
                                We organize various events to promote sustainable living and environmental awareness.
                            </p>
                            <!-- <div class="flex items-center space-x-4 p-4 rounded-xl bg-gray-50 mb-1">
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 font-medium">Date Of establishment</p>
                                    <p class="text-gray-700 font-semibold">March 20, 2024 </p>
                                </div>
                            </div>

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
                                    <p class="text-sm text-gray-500 font-medium">Location</p>
                                    <p class="text-gray-700 font-semibold">Central Community Garden</p>
                                </div>
                            </div> -->


                            <button
                                class="w-full border-2 border-gray-200 text-gray-700 px-8 py-3 rounded-xl 
                     hover:bg-gray-50 transition-all duration-200 font-semibold text-lg
                     hover:border-gray-300 hover:shadow-md">
                                View Profile
                            </button>
                        </div>

                        <!-- Share Card -->
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <h3 class="text-2xl font-bold mb-6">Share Event</h3>
                            <div class="flex flex-col gap-4 max-w-md mx-auto">
                                <button class="flex items-center justify-center gap-2 bg-[#1877F2] text-white px-4 py-3 rounded-xl hover:bg-[#1864D9] transition-all duration-200 font-semibold hover:shadow-lg transform hover:-translate-y-0.5">
                                    <i class='bx bxl-facebook mr-3 text-2xl'></i>Facebook
                                </button>
                                <button class="flex items-center justify-center gap-2 bg-[#1DA1F2] text-white px-4 py-3 rounded-xl hover:bg-[#1A8CD8] transition-all duration-200 font-semibold hover:shadow-lg transform hover:-translate-y-0.5">
                                    <i class='bx bxl-twitter mr-3 text-2xl'></i> Twitter
                                </button>
                                <button class="flex items-center justify-center gap-2 bg-[#25D366] text-white px-4 py-3 rounded-xl hover:bg-[#22BF5B] transition-all duration-200 font-semibold hover:shadow-lg transform hover:-translate-y-0.5">
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
    <script>
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
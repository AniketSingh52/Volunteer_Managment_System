<?php include("../../config/connect.php"); ?>
<?php
session_start();
$user_id = $_SESSION['user_id'];
date_default_timezone_set("Asia/Kolkata");
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

        /* Style scrollbar track */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Style scrollbar thumb */
        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 4px;
            /* display: none; */
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
            <div class="max-w-7xl mx-auto px-4 py-3">

                <div class=" h-[82svh] flex">
                    <!-- Sidebar - User List -->
                    <div class="w-96 bg-white border-r border-gray-200 flex flex-col">
                        <!-- Header -->
                        <div class="p-4 border-b border-gray-200">
                            <a onclick="window.location.href='profile2.php?id=<?= base64_encode($user_id) ?>'">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <img
                                            src="<?= $profile ?>"
                                            alt="Your Profile"
                                            class="w-10 h-10 rounded-full object-cover">
                                        <h2 class="text-xl font-semibold text-gray-800">Chats</h2>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                        <!-- <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button> -->
                                    </div>
                                </div>
                            </a>

                            <!-- Search -->
                            <div class="relative">
                                <input
                                    type="search"
                                    placeholder="Search or start new chat"
                                    class="w-full pl-10 pr-4 py-2 bg-white border-0 outline-none rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <svg class="w-5 h-5 text-gray-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Chat List -->
                        <div class="flex-1 chat_list overflow-y-auto">
                            <!-- Active Chat -->
                            <!-- <div class="p-4 hover:bg-gray-50 cursor-pointer border-l-4 border-blue-500 bg-blue-50">
                                <div class="flex justify-between items-start">
                                    <div class="flex space-x-3">
                                        <div class="relative">
                                            <img
                                                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150"
                                                alt="Jane Smith"
                                                class="w-12 h-12 rounded-full object-cover">
                                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">Jane Smith</h3>
                                            <p class="text-sm text-gray-600 line-clamp-1">Thanks for organizing the event!</p>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <span>12:30 PM</span>
                                        <div class="mt-1 bg-blue-500 text-white rounded-full px-2 py-1 text-center">2</div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- Other Chats -->
                            <!-- <div class="p-4 hover:bg-gray-50 cursor-pointer">
                                <div class="flex justify-between items-start">
                                    <div class="flex space-x-3">
                                        <div class="relative">
                                            <img
                                                src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?auto=format&fit=crop&q=80&w=150"
                                                alt="Mike Johnson"
                                                class="w-12 h-12 rounded-full object-cover">
                                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-gray-300 rounded-full border-2 border-white"></div>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">Mike Johnson</h3>
                                            <p class="text-sm text-gray-600 line-clamp-1">I'll be there at the community garden tomorrow</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500">Yesterday</span>
                                </div>
                            </div> -->





                        </div>
                    </div>

                    <!-- Main Chat Area -->
                    <div class="flex-1 flex flex-col bg-[#f0f2f5]">
                        <!-- Chat Header -->
                        <div class=" chat_header bg-white border-b border-gray-200 px-6 py-4">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-4">
                                    <img
                                        src="https://static.vecteezy.com/system/resources/thumbnails/009/292/244/small/default-avatar-icon-of-social-media-user-vector.jpg"
                                        alt="Default"
                                        class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <h3 class="font-semibold text-gray-500 opacity-35">Username</h3>
                                        <p class="text-sm text-gray-500/30">Select a user</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <!-- <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                    <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                    </button> -->
                                    <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Messages Area -->
                        <!--   <div class=" message_area flex-1 overflow-y-auto p-6 space-y-6" style="background-image: url('https://web.whatsapp.com/img/bg-chat-tile-dark_a4be512e7195b6b733d9110b408f075d.png');">
 -->
                        <div class=" message_area flex-1 overflow-y-auto p-6 space-y-6 bg-gradient-to-br from-purple-200 to-blue-200 py-6 px-4s">

                            <p class=" text-center justify-items-center text-gray-500 opacity-50 font-serif text-2xl"> Select a User</p>
                            <!-- Received Message -->
                            <!-- <div class="flex items-end space-x-2">
                                <img
                                    src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150"
                                    alt="Jane Smith"
                                    class="w-8 h-8 rounded-full object-cover">
                                <div class="max-w-md">
                                    <div class="bg-white rounded-lg p-4 shadow-md">
                                        <p class="text-gray-800">Hi! Thanks for organizing the community garden event. It was really great!</p>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">12:25 PM</span>
                                </div>
                            </div> -->

                            <!-- Sent Message -->
                            <!-- <div class="flex items-end justify-end space-x-2">
                                <div class="max-w-md">
                                    <div class="bg-green-100 rounded-lg p-4 shadow-md">
                                        <p class="text-gray-800">You're welcome! I'm glad you enjoyed it. We're planning another one next month.</p>
                                    </div>
                                    <div class="flex items-center justify-end space-x-1 mt-1">
                                        <span class="text-xs text-gray-500">12:28 PM</span>
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div> -->

                            <!-- Received Message with Image -->
                            <!-- <div class="flex items-end space-x-2">
                                <img
                                    src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150"
                                    alt="Jane Smith"
                                    class="w-8 h-8 rounded-full object-cover">
                                <div class="max-w-md">
                                    <div class="bg-white rounded-lg p-2 shadow-sm">
                                        <img
                                            src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=500"
                                            alt="Garden Event"
                                            class="rounded-lg w-64 h-48 object-cover">
                                        <p class="text-gray-800 mt-2 px-2 pb-2">Look at these beautiful flowers we planted!</p>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">12:30 PM</span>
                                </div>
                            </div> -->
                        </div>

                        <!-- Message Input -->
                        <div class="bg-white px-6 py-1 border-t border-gray-200">
                            <div class="flex items-center space-x-4">

                                <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>

                                <div class="flex-1">
                                    <form class="chat_form">
                                        <input disabled
                                            id="chat_message"
                                            type="text"
                                            placeholder="Type a message"
                                            class="w-full px-4 py-2 bg-white border-1 border-gray-300  outline-1 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-300 ">
                                </div>
                                <button disabled type="submit" id="chat_button" data-id="0"
                                    class=" comment-submit border-none border-white text-sm px-4 bg-white py-4 text-indigo-600 focus:outline-none">
                                    <i class="bx bx-send text-3xl"></i>
                                </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Content -->

    </main>




    <!-- Footer -->
    <footer
        class=" hidden bg-white border-t border-gray-200 w-full md:w-[calc(100%-288px)] md:ml-72 transition-all footer">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <!-- Top Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Get in Touch -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Please feel free to get in touch with us
                    </h3>
                </div>

                <!-- Location -->
                <div>
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <svg
                                class="h-6 w-6 text-primary"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">
                                Our Location
                            </h4>
                            <p class="text-gray-600">
                                601 Lotus, 6th Floor, AND Forever City, Mumbai
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div>
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <svg
                                class="h-6 w-6 text-primary"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">
                                Our Contacts
                            </h4>
                            <p class="text-gray-600 mb-1">VolunteerManagement.com</p>
                            <p class="text-gray-600">walfra52777@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="border-t border-gray-200 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <!-- Logo and Copyright -->
                    <div class="flex items-center space-x-4 mb-4 md:mb-0">
                        <svg
                            class="h-8 w-8 text-primary"
                            viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                        </svg>
                        <span class="text-xl font-bold text-gray-900">VolunteerHub</span>
                    </div>

                    <div class="text-gray-500">
                        © 2025 VolunteerHub | All Rights Reserved
                    </div>

                    <!-- Social Links -->
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a
                            href="#"
                            class="text-gray-400 hover:text-blue-600 transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                            </svg>
                        </a>
                        <a
                            href="#"
                            class="text-gray-400 hover:text-slate-600 transition-colors">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a
                            href="#"
                            class="text-gray-400 hover:text-pink-600 transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a
                            href="#"
                            class="text-gray-400 hover:text-blue-700 transition-colors">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Footer -->
    <?php
    // include('../layouts/footer.php'); 
    ?>



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

    <script>
        $(document).ready(function() {


            function scrollToBottom() {
                $(".message_area").scrollTop($(".message_area")[0].scrollHeight);
            }

            // function get_chats() {
            //     let user_message_id = $("#chat_button").data("id");
            //     let current_id = <?= $user_id ?>;
            //     // alert(user_message_id);
            //     // alert(current_id);
            //     $.ajax({
            //         url: "Backend/get_messages.php", // Backend PHP script
            //         method: "POST",
            //         data: {
            //             user_id: user_message_id,
            //             current_id: current_id
            //         },
            //         success: function(response) {
            //             $(".message_area").html(response); // Show results
            //             // scrollToBottom();
            //         },
            //         error: function(xhr, status, error) {
            //             console.log("AJAX Error: " + status + " " + error);
            //             alert("AJAX Error: " + status + " " + error);
            //         }
            //     });
            // }


            let isUserScrolling = false;

            $(".message_area").on("scroll", function() {
                let messageArea = $(this);
                let scrollTop = messageArea.scrollTop();

                // If user is not near the bottom, set flag to true
                if (scrollTop + messageArea.innerHeight() < messageArea[0].scrollHeight - 50) {
                    isUserScrolling = true;
                } else {
                    isUserScrolling = false;
                }
            });

            function get_chats() {
                let user_message_id = $("#chat_button").data("id");
                let current_id = <?= $user_id ?>;

                $.ajax({
                    url: "Backend/get_talks.php", // Backend PHP script
                    method: "POST",
                    data: {
                        user_id: user_message_id,
                        current_id: current_id
                    },
                    success: function(response) {
                        let messageArea = $(".message_area");

                        // Preserve scroll position before updating content
                        let prevScrollHeight = messageArea[0].scrollHeight;
                        let prevScrollTop = messageArea.scrollTop();

                        $(".message_area").html(response); // Show results

                        if (!isUserScrolling) {
                            scrollToBottom(); // Only scroll if user is not manually scrolling
                        } else {
                            // Restore previous scroll position
                            let newScrollHeight = messageArea[0].scrollHeight;
                            messageArea.scrollTop(prevScrollTop + (newScrollHeight - prevScrollHeight));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX Error: " + status + " " + error);
                        alert("AJAX Error: " + status + " " + error);
                    }
                });
            }



            function initialize() {
                // alert('he');
                fetch(`Backend/talk_list.php`)
                    .then(response => response.text())
                    .then(data => {
                        // document.getElementById('chat_list').innerHTML = data;
                        $(".chat_list").html(data);
                    })
                    .catch(error => console.error('Error loading content:', error));

            }

            function chat_load() {
                let user_message_id = $("#chat_button").data("id");
                if (user_message_id == 0) {
                    // alert("select a user!!.");
                    return;
                } else {
                    // alert(user_message_id);
                    get_chats();
                }
            }

            initialize();




            setInterval(() => {
                initialize();
            }, 2000);

            setInterval(() => {
                chat_load();
            }, 2000);








            $(document).on('click', '.messag_profile', function(e) {

                let user_message_id = $(this).data("id");
                let current_id = <?= $user_id ?>;
                let button = $(this);

                e.preventDefault();

                $('#chat_button').attr('disabled', false);
                $('#chat_message').attr('disabled', false);
                $('#chat_message').val("");
                // alert(user_message_id);

                $.ajax({
                    url: "Backend/talk_header.php", // Backend PHP script
                    method: "POST",
                    data: {
                        user_id: user_message_id,
                        current_id: current_id
                    },
                    success: function(response) {
                        $(".chat_header").html(response); // Show results
                        //  $("#events-list").html(""); // Clear results if input is empty
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX Error: " + status + " " + error);
                        alert("AJAX Error: " + status + " " + error);
                    }
                });

                $.ajax({
                    url: "Backend/get_talks.php", // Backend PHP script
                    method: "POST",
                    data: {
                        user_id: user_message_id,
                        current_id: current_id
                    },
                    success: function(response) {
                        $("#chat_button").data("id", user_message_id); // Correct way

                        setTimeout(function() {
                            $(".message_area").html(response); // Show results
                            scrollToBottom();
                            $("#chat_message").focus();
                        }, 1000); // 1-second delay
                        //  $("#events-list").html(""); // Clear results if input is empty
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX Error: " + status + " " + error);
                        alert("AJAX Error: " + status + " " + error);
                    }
                });



            });



            $(document).on('submit', '.chat_form', function(e) {
                e.preventDefault();
                let chat_message = $("#chat_message").val();
                let user_message_id = $("#chat_button").data("id");
                let userId = <?= $user_id ?>;

                // alert(chat_message);
                // alert(userId);
                // alert(user_message_id);

                if (chat_message.trim() == "") {
                    alert("Empty message can't be sent!!.");
                    return;
                }


                $.ajax({
                    url: "Backend/sent_talk.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        from_id: userId,
                        to_id: user_message_id,
                        message: chat_message
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // alert("Message SEND successfully!");
                            $("#chat_message").val("");
                            console.log(response.message);

                        } else {
                            alert(response.message); // Show error message
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


</body>

</html>



<script>
    // SELECT u.user_id, u.name, u.user_name, u.profile_picture, m.text AS latest_message, m.date_time AS latest_message_time FROM user u LEFT JOIN(--Get the latest message exchanged between user_id = 12 and each user SELECT m1.*FROM messages m1 INNER JOIN(SELECT CASE WHEN from_id = 12 THEN to_id ELSE from_id END AS user_id, MAX(date_time) AS latest_time FROM messages WHERE from_id = 12 OR to_id = 12 GROUP BY user_id) m2 ON((m1.from_id = 12 AND m1.to_id = m2.user_id) OR(m1.to_id = 12 AND m1.from_id = m2.user_id)) AND m1.date_time = m2.latest_time) m ON u.user_id = m.from_id OR u.user_id = m.to_id WHERE u.user_id != 12 ORDER BY COALESCE(m.date_time, '0000-00-00 00:00:00') DESC;
</script>
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


    $sql = "SELECT p.user_id,u.name,u.user_name, u.profile_picture, p.picture_url,p.caption,p.upload_date,p.likes FROM `pictures` p JOIN user u ON p.user_id=u.user_id 
            WHERE p.user_id = ? ORDER BY p.upload_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result2 = $stmt->get_result();

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
            <div class="max-w-7xl mx-auto px-4 py-3">
                <div
                    class="mb-1 mx-auto space-y-2 text-center max-w-7xl bg-white py-4 rounded-xl">
                    <h2 class="text-4xl font-bold text-gray-800">My Posts</h2>
                    <p class="lg:mx-auto lg:w-6/12 text-gray-600 dark:text-gray-500">
                        Manage Your Posts
                    </p>
                </div>

                <div class=" space-y-4">

                <?php

                if ($result2->num_rows > 0) {

                    $rows = $result2->fetch_all(MYSQLI_ASSOC);

                    foreach ($rows as $row) {
                        $username = $row['name'];
                        $user_name= $row['user_name'];
                        $user_profile= $row['profile_picture'];
                        $picture_url=$row['picture_url'];
                        $picture_url = preg_replace('/^\.\.\//', '', $picture_url);
                        $picture_caption=$row['caption'];
                        $picture_date=$row['upload_date'];
                        $picture_likes=$row['likes'];
                        $user_profile = preg_replace('/^\.\.\//', '', $user_profile);

                        $creation_date = new DateTime($picture_date);
                        $today = new DateTime();
                        $diff = $today->diff($creation_date);

                        if (
                            $diff->days == 0
                        ) {
                            $days_ago = "Today";
                        } else {
                            $days_ago = ($diff->days <= 10) ? "{$diff->days} days ago" : date('jS M y', strtotime($picture_date));
                        }
                    
                ?>

                <!-- 1st Post  -->
                <div
                    class="mx-auto flex justify-center max-w-4xl md:mb-8 mt-4 bg-white rounded-lg items-center relative md:p-0 p-8"
                    x-data="{
        comment : false,
    }">
                    <div class="h-full relative">
                        <div class="py-2 px-2">
                            <div class="flex justify-between items-center py-2">
                                <div class="relative mt-1 flex">
                                    <div class="mr-2 p-1">
                                        <img
                                            src="<?= $user_profile?>"
                                            alt="<?= $username?>"
                                            class="w-10 h-10 rounded-full object-cover" />
                                    </div>
                                    <div class="ml-3 flex justify-start flex-col items-start">
                                        <p class="text-lg font-bold "><?= $username?></p>
                                        <p class="text-gray-600 text-sm font-mono">@<?= $user_name?></p>
                                    </div>
                                    <!-- <span class="text-xs mx-2">•</span>
                       <button class="text-indigo-500 text-sm capitalize flex justify-start items-start">follow</button> -->
                                </div>
                                <button
                                    type="button"
                                    class="relative p-2 focus:outline-none border-none bg-gray-100 rounded-full">
                                    <svg
                                        class="w-5 h-5 text-gray-700"
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
                            </div>
                        </div>
                        <div class="relative w-full h-full">
                            <img
                                src="<?= $picture_url?>"
                                alt="<?= $username?>"
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
                                <div class="p-2 mb-10">
                                    <!-- System Comment -->
                                    <div
                                        class="flex justify-start flex-col space-y-3 items-start px-2 border-b border-gray-100">

                                        <!-- 1st Comment -->
                                        <div class="relative mt-1 mb-3 pt-2 flex w-full">
                                            <div class="mr-2">
                                                <img
                                                    src="https://avatars.githubusercontent.com/u/68494287?v=4"
                                                    alt="saman sayyar"
                                                    class="w-12 h-12 rounded-full object-cover" />
                                            </div>
                                            <div class="ml-2 w-full" x-data="{ replies : false }">
                                                <p class="text-gray-600 md:text-lg text-xs w-full">
                                                    <!-- Username User -->
                                                    <span class="font-normal text-gray-900">samansayyar</span>
                                                    <!-- Username User -->
                                                    You Can see?
                                                </p>
                                                <div class="flex space-x-4 w-full">
                                                    <div class="time mt-1 text-gray-400 text-xs">
                                                        <p>2d</p>
                                                    </div>
                                                    <button
                                                        type="button"
                                                        class="focus:outline-none time mt-1 text-gray-400 text-sm">
                                                        <p>replay</p>
                                                    </button>
                                                </div>
                                                <button
                                                    type="button"
                                                    @click="replies = !replies"
                                                    class="focus:outline-none mt-3 flex justify-center items-center">
                                                    <p
                                                        class="text-sm text-center text-indigo-500 flex space-x-2">
                                                        <span>____ View replies (1)</span>
                                                        <svg
                                                            class="w-3 h-4"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                    </p>
                                                </button>
                                                <div
                                                    x-show="replies"
                                                    x-transition=""
                                                    class="flex justify-start flex-col space-y-3 items-start px-2 border-b border-gray-100"
                                                    style="display: none">
                                                    <div class="relative mt-1 mb-3 pt-2 flex w-full">
                                                        <div class="mr-2">
                                                            <img
                                                                src="https://avatars.githubusercontent.com/u/68494287?v=4"
                                                                alt="saman sayyar"
                                                                class="w-8 h-8 rounded-full object-cover" />
                                                        </div>
                                                        <div
                                                            class="ml-2 w-full"
                                                            x-data="{ replies : true }">
                                                            <p
                                                                class="text-gray-600 md:text-sm text-xs w-full">
                                                                <!-- Username User -->
                                                                <span class="font-normal text-gray-900">samansayyar</span>
                                                                <!-- Username User -->
                                                                You Can see?
                                                            </p>
                                                            <div class="flex space-x-4">
                                                                <div
                                                                    class="time mt-1 text-gray-400 text-xs">
                                                                    <p>2d</p>
                                                                </div>
                                                                <button
                                                                    type="button"
                                                                    class="focus:outline-none time mt-1 text-gray-400 text-xs">
                                                                    <p>replay</p>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 2nd Comment -->
                                    <div
                                        class="flex justify-start flex-col space-y-3 items-start px-2 border-b border-gray-300 rounded-sm">
                                        <div class="relative w-full mt-1 mb-3 pt-2 flex">
                                            <div class="mr-2">
                                                <img
                                                    src="https://avatars.githubusercontent.com/u/68494287?v=4"
                                                    alt="saman sayyar"
                                                    class="w-12 h-12 rounded-full object-cover" />
                                            </div>
                                            <div class="ml-2 w-full">
                                                <p class="text-gray-600 md:text-lg text-xs w-full">
                                                    <!-- Username User -->
                                                    <span class="font-normal text-gray-900">samansayyar</span>
                                                    <!-- Username User -->
                                                    You Can see?
                                                </p>
                                                <div class="time mt-1 text-gray-400 text-xs">
                                                    <p>2d</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- System Like and tools Feed -->
                            <div class="flex justify-between items-start p-2 py-">
                                <div class="flex space-x-2 items-center">
                                    <button type="button" class="focus:outline-none Like">
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
                                    <button type="button" class="focus:outline-none save">
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
                                    <p class="font-bold text-lg text-gray-700"><?= $picture_likes?> likes</p>
                                </div>
                                <div class="text-base">
                                    <?= $picture_caption?>
                                </div>

                                <div class="text-gray-500 leading-loose text-base font-semibold">
                                    View all 877 comments
                                </div>

                                <div class="w-full">
                                    <p class="text-sm font-normal text-gray-400"><?= $days_ago?></p>
                                </div>
                            </div>

                            <!-- Comment Input Field ans send button -->
                            <!-- End System Like and tools Feed  -->
                            <div class="z-50">
                                <form>
                                    <div
                                        class="flex justify-between border-t items-center w-full"
                                        :class="comment ? 'absolute bottom-0' : '' ">
                                        <div class="w-full">
                                            <input
                                                type="text"
                                                name="comment"
                                                id="comment"
                                                placeholder="Add A Comment..."
                                                class="w-full text-sm py-4 px-3 border-none outline-none rounded-none focus:border-none" />
                                        </div>
                                        <div class="w-20">
                                            <button
                                                class="border-none border-white text-sm px-4 bg-white py-4 text-indigo-600 focus:outline-none">
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
                    echo '
                    <h1 class=" text-3xl font-medium">No zvailable</h1>
                    ';

                }else{
                    echo '
                    <h1 class=" text-3xl font-medium">No Post Available</h1>
                    ';
                }
                ?>

                </div>
            </div>
        </div>
        <!-- End Content -->

    </main>

    <script>
        $(document).ready(function() {


            $(".heart").click(function() {
                //  alert('hello');
                $(".heart").removeClass("selected fill-red-500 text-red-500").addClass("text-gray-600");
                $(this).prevAll().addBack().addClass(" selected  fill-red-500 text-red-500").removeClass("text-gray-600");

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
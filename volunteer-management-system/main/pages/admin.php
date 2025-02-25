<?php include("../../config/connect.php"); ?>

<?php
session_start();

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

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <link rel="preconnect" href="https://fonts.bunny.net" />
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
  <!--sidenav -->
  <div
    class="fixed left-0 top-0 w-72 h-full bg-[#f8f4f3] p-4 z-50 sidebar-menu transition-transform">
    <!-- <a href="#" class="flex items-center justify-items-center text-center pb-4 border-b border-b-gray-800 bg-black">
             <div class="inline-block p-2 rounded-full mb-4 bg-red-600">
                <div class="h-10 w-10 rounded-full shadow-md flex items-center justify-center overflow-hidden">
                    <img src="../assets/Screenshot 2025-02-05 215045.svg" class="profile-image2 object-cover" alt="Profile Image">
                </div>
            </div>
             <div class="font-bold text-2xl">Volunteer<span class="bg-[#42eda3] text-white px-2 ml-1 rounded-md">HUB</span></div>
           
        </a> -->
    <!-- Volunteer Logo -->
    <a
      href="#"
      class="flex items-center justify-items-center text-center border-b border-b-gray-800 w-full p-2">
      <div class="inline-block p-1 rounded-full bg-red-400">
        <div
          class="h-10 w-10 rounded-full shadow-md flex items-center justify-center overflow-hidden">
          <img
            src="../assets/Screenshot 2025-02-05 215045.svg"
            class="profile-image2 object-cover"
            alt="Profile Image" />
        </div>
      </div>
      <div class="font-bold text-2xl w-full">
        Volunteer<span class="bg-[#1dab6d] text-white px-2 ml-1 rounded-md">HUB</span>
      </div>
    </a>
    <ul class="mt-4">
      <!-- <span class="text-gray-400 font-bold">Home</span> -->
      <li class="mb-1 group">
        <a
          href="admin.php"
          class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
          <i class="ri-home-2-line mr-3 text-lg"></i>
          <span class="text-sm">Home</span>
        </a>
      </li>

      <!--Drop Doen list Template  -->
      <!-- <li class="mb-1 group">
                <a href="" class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 sidebar-dropdown-toggle">
                    <i class='bx bx-user mr-3 text-lg'></i>                
                    <span class="text-sm">Users</span>
                    <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                    <li class="mb-4">
                        <a href="" class="text-gray-900 text-sm flex items-center hover:text-[#f84525]  before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">All</a>
                    </li> 
                    <li class="mb-4">
                        <a href="" class="text-gray-900 text-sm flex items-center hover:text-[#f84525] before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Roles</a>
                    </li> 
                </ul>
            </li> -->

      <li class="mb-1 group">
        <a
          href="gallery.php"
          class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
          <i class="bx bx-list-ul mr-3 text-lg"></i>
          <span class="text-sm">Explore Post</span>
        </a>
      </li>

      <!-- Events Section Sidebar -->
      <span class="text-gray-400 font-bold">Events</span>
      <!-- For Dropdown in sidebar -->
      <!-- <li class="mb-1 group">
                <a href="" class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 sidebar-dropdown-toggle">
                    <i class='bx bxl-blogger mr-3 text-lg' ></i>                 
                    <span class="text-sm">Post</span>
                    <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
                </a>
                <ul class=" max-h-20 overflow-auto pl-7 mt-2 hidden group-[.selected]:block">
                    <li class="mb-4">
                        <a href="" class="text-gray-900 text-sm flex items-center hover:text-[#f84525]  before:w-2 before:h-2 before:rounded-full before:bg-blue-700 before:mr-3">All</a>
                    </li>
                    <li class="mb-4">
                        <a href="" class="text-gray-900 text-sm flex items-center hover:text-[#f84525] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">All</a>
                    </li>
                    <li class="mb-4">
                        <a href="" class="text-gray-900 text-sm flex items-center hover:text-[#f84525]  before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">All</a>
                    </li>
                    <li class="mb-4">
                        <a href="" class="text-gray-900 text-sm flex items-center hover:text-[#f84525] before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">All</a>
                    </li> 
                    <li class="mb-4">
                        <a href="" class="text-gray-900 text-sm flex items-center hover:text-[#f84525] before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Categories</a>
                    </li> 
                </ul>
            </li> -->
      <li class="mb-1 group">
        <a
          href="search_event.php"
          class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
          <i class="bx bx-search mr-3 text-lg"></i>
          <span class="text-sm">Search</span>
        </a>
      </li>
      <li class="mb-1 group">

        <a
          href="add_event.php"
          class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
          <i class="bx bxs-plus-circle mr-3 text-lg"></i>
          <span class="text-sm">Add Event</span>
        </a>
      </li>
      <li class="mb-1 group">
        <a
          href=""
          class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
          <i class="bx bx-book-bookmark mr-3 text-lg"></i>
          <span class="text-sm">My Applications</span>
        </a>
      </li>

      <!-- PERSONAL SECTION SIDEBAR -->
      <span class="text-gray-400 font-bold">PERSONAL</span>
      <li class="mb-1 mt-2 group">
        <a
          href=""
          class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 sidebar-dropdown-toggle">
          <i class="bx bx-chat mr-3 text-lg"></i>
          <span class="text-sm">Chats</span>
          <i
            class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
        </a>
        <ul
          class="max-h-30 overflow-auto pl-7 mt-2 hidden group-[.selected]:block">
          <li class="mb-4">
            <a
              href=""
              class="text-gray-900 text-base flex items-center hover:text-[#f84525] before:w-2 before:h-2 before:rounded-full before:bg-blue-700 before:mr-3">Abhishek</a>
          </li>
          <li class="mb-4">
            <a
              href=""
              class="text-gray-900 text-base flex items-center hover:text-[#f84525] before:w-2 before:h-2 before:rounded-full before:bg-blue-700 before:mr-3">Nitin</a>
          </li>
          <li class="mb-4">
            <a
              href=""
              class="text-gray-900 text-base flex items-center hover:text-[#f84525] before:w-2 before:h-2 before:rounded-full before:bg-blue-700 before:mr-3">Aryan</a>
          </li>
          <li class="mb-4">
            <a
              href=""
              class="text-gray-900 text-base flex items-center hover:text-[#f84525] before:w-2 before:h-2 before:rounded-full before:bg-blue-700 before:mr-3">Omkar</a>
          </li>
          <li class="mb-4">
            <a
              href=""
              class="text-gray-900 text-base flex items-center hover:text-[#f84525] before:w-2 before:h-2 before:rounded-full before:bg-blue-700 before:mr-3">Vipul</a>
          </li>
        </ul>
      </li>
      <!--             
            <li class="mb-1 group">
                <a href="" class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                    <i class='bx bx-chat mr-3 text-lg' ></i>                
                    <span class="text-sm">Chats</span>
                    <span class=" md:block px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-red-600 bg-red-200 rounded-full">5</span>
                </a>
            </li> -->
      <li class="mb-1 group">
        <a
          href=""
          class="flex font-semibold items-center py-2 px-4 text-gray-900 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
          <i class="bx bxs-plus-circle mr-3 text-lg"></i>
          <span class="text-sm">Add Post</span>
          <span
            class="md:block px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-green-600 bg-green-200 rounded-full">2 New</span>
        </a>
      </li>
    </ul>
  </div>
  <div
    class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
  <!-- end sidenav -->

  <main
    class="w-full md:w-[calc(100%-288px)] md:ml-72 bg-gray-200 min-h-screen transition-all main">
    <!-- navbar -->
    <div
      class="py-2 px-6 bg-[#f8f4f3] flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30">
      <button
        type="button"
        class="text-lg text-gray-900 font-semibold sidebar-toggle">
        <i class="ri-menu-line"></i>
      </button>

      <ul class="ml-auto flex items-center">
        <li class="mr-1 dropdown">
          <button
            type="button"
            class="dropdown-toggle text-gray-400 mr-4 w-8 h-8 rounded flex items-center justify-center hover:text-gray-600">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              class="hover:bg-gray-100 rounded-full"
              viewBox="0 0 24 24">
              <path
                d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"></path>
            </svg>
          </button>
          <div
            class="dropdown-menu shadow-md shadow-black/5 z-30 hidden max-w-xs w-full bg-white rounded-md border border-gray-100">
            <form action="" class="p-4 border-b border-b-gray-100">
              <div class="relative w-full">
                <input
                  type="text"
                  class="py-2 pr-4 pl-10 bg-gray-50 w-full outline-none border border-gray-100 rounded-md text-sm focus:border-blue-500"
                  placeholder="Search..." />
                <i
                  class="ri-search-line absolute top-1/2 left-4 -translate-y-1/2 text-gray-900"></i>
              </div>
            </form>
          </div>
        </li>
        <li class="dropdown">
          <button
            type="button"
            class="dropdown-toggle text-gray-400 mr-4 w-8 h-8 rounded flex items-center justify-center hover:text-gray-600">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              class="hover:bg-gray-100 rounded-full"
              viewBox="0 0 24 24">
              <path
                d="M19 13.586V10c0-3.217-2.185-5.927-5.145-6.742C13.562 2.52 12.846 2 12 2s-1.562.52-1.855 1.258C7.185 4.074 5 6.783 5 10v3.586l-1.707 1.707A.996.996 0 0 0 3 16v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2a.996.996 0 0 0-.293-.707L19 13.586zM19 17H5v-.586l1.707-1.707A.996.996 0 0 0 7 14v-4c0-2.757 2.243-5 5-5s5 2.243 5 5v4c0 .266.105.52.293.707L19 16.414V17zm-7 5a2.98 2.98 0 0 0 2.818-2H9.182A2.98 2.98 0 0 0 12 22z"></path>
            </svg>
          </button>
          <div
            class="dropdown-menu shadow-md shadow-black/5 z-30 hidden max-w-xs w-full bg-white rounded-md border border-gray-100">
            <div
              class="flex items-center px-4 pt-4 border-b border-b-gray-100 notification-tab">
              <button
                type="button"
                data-tab="notification"
                data-tab-page="notifications"
                class="text-gray-400 font-medium text-[13px] hover:text-gray-600 border-b-2 border-b-transparent mr-4 pb-1 active">
                Notifications
              </button>
              <button
                type="button"
                data-tab="notification"
                data-tab-page="messages"
                class="text-gray-400 font-medium text-[13px] hover:text-gray-600 border-b-2 border-b-transparent mr-4 pb-1">
                Messages
              </button>
            </div>
            <div class="my-2">
              <ul
                class="max-h-64 overflow-y-auto"
                data-tab-for="notification"
                data-page="notifications">
                <li>
                  <a
                    href="#"
                    class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                    <img
                      src="https://placehold.co/32x32"
                      alt=""
                      class="w-8 h-8 rounded block object-cover align-middle" />
                    <div class="ml-2">
                      <div
                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                        New order
                      </div>
                      <div class="text-[11px] text-gray-400">from a user</div>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                    <img
                      src="https://placehold.co/32x32"
                      alt=""
                      class="w-8 h-8 rounded block object-cover align-middle" />
                    <div class="ml-2">
                      <div
                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                        New order
                      </div>
                      <div class="text-[11px] text-gray-400">from a user</div>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                    <img
                      src="https://placehold.co/32x32"
                      alt=""
                      class="w-8 h-8 rounded block object-cover align-middle" />
                    <div class="ml-2">
                      <div
                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                        New order
                      </div>
                      <div class="text-[11px] text-gray-400">from a user</div>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                    <img
                      src="https://placehold.co/32x32"
                      alt=""
                      class="w-8 h-8 rounded block object-cover align-middle" />
                    <div class="ml-2">
                      <div
                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                        New order
                      </div>
                      <div class="text-[11px] text-gray-400">from a user</div>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                    <img
                      src="https://placehold.co/32x32"
                      alt=""
                      class="w-8 h-8 rounded block object-cover align-middle" />
                    <div class="ml-2">
                      <div
                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                        New order
                      </div>
                      <div class="text-[11px] text-gray-400">from a user</div>
                    </div>
                  </a>
                </li>
              </ul>
              <ul
                class="max-h-64 overflow-y-auto hidden"
                data-tab-for="notification"
                data-page="messages">
                <li>
                  <a
                    href="#"
                    class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                    <img
                      src="https://placehold.co/32x32"
                      alt=""
                      class="w-8 h-8 rounded block object-cover align-middle" />
                    <div class="ml-2">
                      <div
                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                        John Doe
                      </div>
                      <div class="text-[11px] text-gray-400">
                        Hello there!
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                    <img
                      src="https://placehold.co/32x32"
                      alt=""
                      class="w-8 h-8 rounded block object-cover align-middle" />
                    <div class="ml-2">
                      <div
                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                        John Doe
                      </div>
                      <div class="text-[11px] text-gray-400">
                        Hello there!
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                    <img
                      src="https://placehold.co/32x32"
                      alt=""
                      class="w-8 h-8 rounded block object-cover align-middle" />
                    <div class="ml-2">
                      <div
                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                        John Doe
                      </div>
                      <div class="text-[11px] text-gray-400">
                        Hello there!
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                    <img
                      src="https://placehold.co/32x32"
                      alt=""
                      class="w-8 h-8 rounded block object-cover align-middle" />
                    <div class="ml-2">
                      <div
                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                        John Doe
                      </div>
                      <div class="text-[11px] text-gray-400">
                        Hello there!
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                    <img
                      src="https://placehold.co/32x32"
                      alt=""
                      class="w-8 h-8 rounded block object-cover align-middle" />
                    <div class="ml-2">
                      <div
                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                        John Doe
                      </div>
                      <div class="text-[11px] text-gray-400">
                        Hello there!
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <button id="fullscreen-button">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            class="hover:bg-gray-100 rounded-full"
            viewBox="0 0 24 24">
            <path
              d="M5 5h5V3H3v7h2zm5 14H5v-5H3v7h7zm11-5h-2v5h-5v2h7zm-2-4h2V3h-7v2h5z"></path>
          </svg>
        </button>
        <script>
          const fullscreenButton =
            document.getElementById("fullscreen-button");

          fullscreenButton.addEventListener("click", toggleFullscreen);

          function toggleFullscreen() {
            if (document.fullscreenElement) {
              // If already in fullscreen, exit fullscreen
              document.exitFullscreen();
            } else {
              // If not in fullscreen, request fullscreen
              document.documentElement.requestFullscreen();
            }
          }
        </script>
        <!--   src="https://laravelui.spruko.com/tailwind/ynex/build/assets/images/faces/9.jpg" -->
        <li class="dropdown ml-3">
          <button type="button" class="dropdown-toggle flex items-center">
            <div class="flex-shrink-0 w-10 h-10 relative">
              <div
                class="p-1 bg-white rounded-full focus:outline-none focus:ring">
                <img
                  class="w-8 h-8 rounded-full"
                  src="<?php echo $profile ?>"
                  alt="" />
                <div
                  class="top-0 left-7 absolute w-3 h-3 bg-lime-400 border-2 border-white rounded-full animate-ping"></div>
                <div
                  class="top-0 left-7 absolute w-3 h-3 bg-lime-500 border-2 border-white rounded-full"></div>
              </div>
            </div>
            <div class="p-2 md:block text-left">
              <h2 class="text-sm font-semibold text-gray-800">
                <?php echo $name ?>
              </h2>
              <p class="text-xs text-gray-500"><?php echo $type ?></p>
            </div>
          </button>
          <ul
            class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[240px]">
            <li>
              <a
                href="profile2.php"
                class="flex items-center text-sm py-1.5 px-4 text-gray-600 hover:text-[#f84525] hover:bg-gray-50"><i class="bx bx-user pr-2"></i> Profile</a>
            </li>
            <li>
              <a
                href="#"
                class="flex items-center text-sm py-1.5 px-4 text-gray-600 hover:text-[#f84525] hover:bg-gray-50"><i class="bx bx-cog pr-2"></i>Settings</a>
            </li>
            <li>
              <a
                href="#"
                class="flex items-center text-sm py-1.5 px-4 text-gray-600 hover:text-[#f84525] hover:bg-gray-50"><i class="bx bx-log-out pr-2"></i>Logout
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- end navbar -->

    <!-- Content -->
    <div class="p-4">
      <!--Latest Event SECTION-->
      <section class="p-2 justify-items-center">
        <div class="xl:container text-gray-600">
          <div
            class="mb-1 mx-auto space-y-2 text-center bg-white rounded-md p-6 shadow-md shadow-black/5 max-w-7xl">
            <h2 class="text-4xl font-bold text-gray-800">Latest Events</h2>
            <!-- <p class="lg:mx-auto lg:w-6/12 text-gray-600 dark:text-gray-300">
                            Empowering Youth for Social Change and Community Development
                        </p> -->
          </div>
          <div class="mx-auto">
            <!-- <div class="order-last md:order-1 md:text-left lg:text-left text-center mx-auto p-10 col-span-2" data-aos="fade-right">
                            <p class="text-justify">
                                In India, the idea of involving students in the task of national
                                service dates back to the times of Mahatma Gandhi, the father of the
                                nation. The central theme which he tried to impress upon his student
                                audience time and again, was that they should always keep before them,
                                their social responsibility. <br />The University Grants Commission
                                headed by
                                <span class="bg-yellow-200">Dr. Radhakrishnan</span> recommended
                                introduction of national service in the academic institutions on a
                                voluntary basis with a view to developing healthy contacts between the
                                students and teachers on the one hand and establishing a constructive
                                linkage between the campus and the community on the other hand.
                            </p>
                        </div>
                        <div class="md:order-2 mx-auto" data-aos="fade-left">
                            <image alt="NextUI hero Image with delay" class="rounded md:max-h-[200px] lg:max-h-[300px] max-h-60" src="https://www.pngkey.com/png/full/247-2479287_nss-logo-national-service-scheme-logo-png.png" />
                        </div> -->
            <div class="max-w-7xl mx-auto px-2 py-3">
              <!-- Carousel Section -->
              <div
                class="relative h-[500px] overflow-hidden rounded-xl mb-10 group shadow-lg">
                <div id="carousel" class="h-full">
                  <!-- Static Carousel Items -->
                  <div class="carousel-item relative h-full hidden">
                    <div
                      class="absolute top-0 -right-10 bg-red-600 px-6 py-3 text-white mt-3 mr-5 font-semibold rotate-45 tracking-widest text-base hover:bg-white hover:text-indigo-600 transition duration-500 ease-in-out rounded-sm shadow-lg">
                      Latest
                    </div>
                    <img
                      src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=800"
                      alt="Community Garden Clean-up"
                      class="w-full h-full object-cover" />
                    <div
                      class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-8">
                      <h2 class="text-4xl font-bold text-white mb-4">
                        Community Garden Clean-up
                      </h2>

                      <button
                        onclick="window.location.href='/events/1'"
                        class="inline-flex justify-center rounded-lg bg-indigo-600 px-6 py-2 text-lg font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all duration-200 transform hover:-translate-y-0.5">
                        View Details
                      </button>
                    </div>
                  </div>

                  <div class="carousel-item relative h-full hidden">
                    <div
                      class="absolute top-0 -right-10 bg-red-600 px-6 py-3 text-white mt-3 mr-5 font-semibold rotate-45 tracking-widest text-base hover:bg-white hover:text-indigo-600 transition duration-500 ease-in-out rounded-sm shadow-lg">
                      Latest
                    </div>
                    <img
                      src="https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&fit=crop&q=80&w=800"
                      alt="Youth Mentorship Program"
                      class="w-full h-full object-cover" />
                    <div
                      class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-8">
                      <h2 class="text-4xl font-bold text-white mb-4">
                        Youth Mentorship Program
                      </h2>
                      <button
                        onclick="window.location.href='/events/1'"
                        class="inline-flex justify-center rounded-lg bg-indigo-600 px-6 py-2 text-lg font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all duration-200 transform hover:-translate-y-0.5">
                        View Details
                      </button>
                    </div>
                  </div>

                  <div class="carousel-item relative h-full hidden">
                      <div
                      class="absolute top-0 -right-10 bg-red-600 px-6 py-3 text-white mt-3 mr-5 font-semibold rotate-45 tracking-widest text-base hover:bg-white hover:text-indigo-600 transition duration-500 ease-in-out rounded-sm shadow-lg">
                      Latest
                    </div>
                    <img
                      src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&fit=crop&q=80&w=800"
                      alt="Food Bank Distribution"
                      class="w-full h-full object-cover" />
                    <div
                      class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-8">
                      <h2 class="text-4xl font-bold text-white mb-4">
                        Food Bank Distribution
                      </h2>
                      <button
                        onclick="window.location.href='/events/1'"
                        class="inline-flex justify-center rounded-lg bg-indigo-600 px-6 py-2 text-lg font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all duration-200 transform hover:-translate-y-0.5">
                        View Details
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Carousel Controls -->
                <button
                  id="prevSlide"
                  class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:text-blue-700 hover:bg-white p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 19l-7-7 7-7" />
                  </svg>
                </button>
                <button
                  id="nextSlide"
                  class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:text-blue-700 hover:bg-white p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7" />
                  </svg>
                </button>
              </div>

              <!-- Events Section -->
              <h2 class="text-3xl font-bold text-gray-900 mb-8">
                Available Opportunities
              </h2>
              <div id="events-list" class="space-y-6">
                <div
                  class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                  <div class="md:flex">
                    <div class="md:w-1/3">
                      <img
                        class="h-48 w-full object-cover md:h-full"
                        src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&amp;fit=crop&amp;q=80&amp;w=800"
                        alt="Community Garden Clean-up" />
                    </div>
                    <div class="p-8 md:w-2/3 relative">
                      <div
                        class="text-sm absolute top-0 right-0 bg-green-500 rounded-sm px-4 py-2 text-white mt-3 mr-3 hover:bg-green-800 hover:text-white transition duration-500 ease-in-out">
                        Ongoing
                      </div>
                      <div
                        class="uppercase  tracking-wide text-sm text-blue-600 font-semibold">
                        Green Earth Initiative
                        <span class=" ml-3 bg-gray-100 rounded-xl px-2 py-1 text-gray-700">10 days</span>
                      </div>

                      <h3 class="mt-1 text-2xl font-semibold text-gray-900">
                        Community Garden Clean-up
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
                        2024-03-20 - 2024-03-20
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
                        09:00 - 14:00
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
                        Central Community Garden
                      </div>

                      <p class="mt-4 text-gray-600">
                        Join us in maintaining our community garden. Help
                        plant new vegetables and maintain existing beds.
                      </p>

                      <div class="mt-6 flex space-x-4">
                        <button
                          onclick="window.location.href='/events/1'"
                          class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                          View More
                        </button>
                        <button
                          onclick="window.location.href='/events/1/apply'"
                          class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                          Apply
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <div
                  class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                  <div class="md:flex">
                    <div class="md:w-1/3">
                      <img
                        class="h-48 w-full object-cover md:h-full"
                        src="https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&amp;fit=crop&amp;q=80&amp;w=800"
                        alt="Youth Mentorship Program" />
                    </div>
                    <div class="p-8 md:w-2/3 relative">
                      <div
                        class="text-sm absolute top-0 right-0 bg-sky-600 rounded-sm px-4 py-2 text-white mt-3 mr-3 hover:bg-sky-800 hover:text-white transition duration-500 ease-in-out">
                        Scheduled
                      </div>
                      <div
                        class="uppercase tracking-wide text-sm text-blue-600 font-semibold">
                        Youth Forward
                        <span class=" ml-3 bg-gray-100 rounded-xl px-2 py-1 text-gray-700">10 days</span>
                      </div>
                      <h3 class="mt-1 text-2xl font-semibold text-gray-900">
                        Youth Mentorship Program
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
                        2024-03-25 - 2024-06-25
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
                        16:00 - 18:00
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
                        City Youth Center
                      </div>

                      <p class="mt-4 text-gray-600">
                        Make a difference in a young person's life through our
                        mentorship program.
                      </p>

                      <div class="mt-6 flex space-x-4">
                        <button
                          onclick="window.location.href='/events/2'"
                          class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                          View More
                        </button>
                        <button
                          onclick="window.location.href='/events/2/apply'"
                          class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                          Apply
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <div
                  class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                  <div class="md:flex">
                    <div class="md:w-1/3">
                      <img
                        class="h-48 w-full object-cover md:h-full"
                        src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&amp;fit=crop&amp;q=80&amp;w=800"
                        alt="Food Bank Distribution" />
                    </div>
                    <div class="p-8 md:w-2/3 relative">
                      <div
                        class="text-sm absolute top-0 right-0 bg-red-500 rounded-sm px-4 py-2 text-white mt-3 mr-3 hover:bg-red-800 hover:text-white transition duration-500 ease-in-out">
                        Cancelled
                      </div>
                      <div
                        class="uppercase tracking-wide text-sm text-blue-600 font-semibold">
                        Food for All
                        <span class=" ml-3 bg-gray-100 rounded-xl px-2 py-1 text-gray-700">10 days</span>
                      </div>
                      <h3 class="mt-1 text-2xl font-semibold text-gray-900">
                        Food Bank Distribution
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
                        2024-03-22 - 2024-03-22
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
                        08:00 - 12:00
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
                        Community Food Bank
                      </div>

                      <p class="mt-4 text-gray-600">
                        Help sort and distribute food to families in need at
                        our local food bank.
                      </p>

                      <div class="mt-6 flex space-x-4">
                        <button
                          onclick="window.location.href='/events/3'"
                          class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                          View More
                        </button>
                        <button
                          onclick="window.location.href='/events/3/apply'"
                          class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                          Apply
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <script type="module" src="../../js/main.js"></script>
          </div>
        </div>
      </section>

      <!--  Stats-->
      <div class="stats-section  py-2 px-4 max-w-7xl mx-auto">
        <div
          class="stats-grid z-20 w-full rounded-xl bg-[#7f98bb] mx-auto grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 items-center justify-between md:px-10 gap-x-10 py-10 px-5 lg:px-10 gap-y-5">
          <div
            class="col-span-1 md:col-span-3 lg:col-span-1 flex flex-col items-center justify-center gap-y-1">
            <h2
              class="text-3xl md:text-4xl text-white dark:text-gray-200 font-bold">
              Your Impact
            </h2>
            <svg
              class="w-12 h-12 text-red-600"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z"></path>
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z"></path>
            </svg>
          </div>
          <div
            class="col-span-1 md:col-span-1 lg:col-span-1 flex flex-col items-center justify-center gap-y-3">
            <h2
              class="text-3xl lg:text-5xl text-white dark:text-green-200 font-bold">
              10+
            </h2>
            <p
              class="text-center text-sm md:text-base text-white dark:text-gray-200">
              Volunteered
            </p>
            <svg
              class="w-8 h-8 text-teal-800"
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
          </div>
          <div
            class="col-span-1 md:col-span-1 lg:col-span-1 flex flex-col items-center justify-center gap-y-3">
            <h2
              class="text-3xl lg:text-5xl text-white dark:text-cyan-300 font-bold">
              20
            </h2>
            <p
              class="text-center text-sm md:text-base text-white dark:text-gray-200">
              Pending Volunteering
            </p>
            <svg
              class="w-8 h-8 text-sky-700"
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
          </div>

          <div
            class="col-span-1 md:col-span-1 lg:col-span-1 flex flex-col items-center justify-center gap-y-3">
            <h2
              class="text-3xl lg:text-5xl text-white dark:text-gray-200 font-bold">
              3500+
            </h2>
            <p
              class="text-center text-sm md:text-base text-white dark:text-gray-200">
              Volunteer Score
            </p>
            <svg
              class="w-8 h-8 fill-red-500 text-red-500"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
            </svg>
          </div>
        </div>
      </div>
      <!-- Stats End  -->


      <!-- Comments and post Start -->
      <div class="max-w-7xl mx-auto px-4 mt-6 mb-10">
        <!-- Heading -->
        <div
          class="mb-1 mx-auto space-y-2 text-center bg-white rounded-md p-6 shadow-md shadow-black/5 max-w-7xl">
          <h2 class="text-4xl font-bold text-gray-800">Recent Posts</h2>
          <p class="lg:mx-auto lg:w-6/12 text-gray-600 dark:text-gray-500">
            Post & Comments
          </p>
        </div>

        <!-- Comments and post -->
        <div id="post_comments" class="space-y-3">

          <!-- 1st Post Background Pulse animation -->
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
              class="flex flex-col space-y-4 filter animate-pulse duration-500">
              <div
                class="p-10 bg-gradient-to-r to-indigo-700 from-blue-900 absolute top-20 left-20"></div>
              <div
                class="p-10 bg-gradient-to-r to-indigo-700 from-blue-900 absolute bottom-20 right-20"></div>
            </div>
          </div>


          <!-- 1st Post  -->
          <div
            class="mx-auto flex justify-center max-w-4xl md:mb-8 mt-9 bg-white rounded-lg items-center relative md:p-0 p-8"
            x-data="{
        comment : false,
    }">
            <div class="h-full relative">
              <div class="py-2 px-2">
                <div class="flex justify-between items-center py-2">
                  <div class="relative mt-1 flex">
                    <div class="mr-2 p-1">
                      <img
                        src="https://avatars.githubusercontent.com/u/68494287?v=4"
                        alt="saman sayyar"
                        class="w-10 h-10 rounded-full object-cover" />
                    </div>
                    <div class="ml-3 flex justify-start flex-col items-start">
                      <p class="text-lg font-bold ">samansayyar</p>
                      <p class="text-gray-600 text-sm ">samansayyar</p>
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
                  src="https://wallpaperaccess.com/full/345330.jpg"
                  alt="saman"
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
                        class="w-8 h-8 hover:fill-red-500 hover:text-red-500 text-gray-600"
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
                    <p class="font-bold text-lg text-gray-700">234 likes</p>
                  </div>
                  <div class="text-base">
                    <span class="text-gray-600 leading-relaxed text-base">gnfi</span> Lorem ipsum dolor
                    sit amet consectetur adipisicing elit. Porro impedit
                    nesciunt nihil architecto, omnis voluptatem quos
                    repellendus, quis ab id esse vero cum magnam itaque quod,
                    similique tempora recusandae ea..
                  </div>

                  <div class="text-gray-500 leading-loose text-base font-semibold">
                    View all 877 comments
                  </div>

                  <div class="w-full">
                    <p class="text-sm font-normal text-gray-400">10 hours ago</p>
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
                          class="w-full text-sm py-4 px-3 rounded-none focus:outline-none" />
                      </div>
                      <div class="w-20">
                        <button
                          class="border-none text-sm px-4 bg-white py-4 text-indigo-600 focus:outline-none">
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




          <!-- 1st Post Background Pulse animation -->
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
              class="flex flex-col space-y-4 filter animate-pulse duration-500">
              <div
                class="p-10 bg-gradient-to-r to-indigo-700 from-blue-900 absolute top-20 left-20"></div>
              <div
                class="p-10 bg-gradient-to-r to-indigo-700 from-blue-900 absolute bottom-20 right-20"></div>
            </div>
          </div>


          <!-- 1st Post  -->
          <div
            class="mx-auto flex justify-center max-w-4xl md:mb-8 mt-9 bg-white rounded-lg items-center relative md:p-0 p-8"
            x-data="{
        comment : false,
    }">
            <div class="h-full relative">
              <div class="py-2 px-2">
                <div class="flex justify-between items-center py-2">
                  <div class="relative mt-1 flex">
                    <div class="mr-2 p-1">
                      <img
                        src="https://avatars.githubusercontent.com/u/68494287?v=4"
                        alt="saman sayyar"
                        class="w-10 h-10 rounded-full object-cover" />
                    </div>
                    <div class="ml-3 flex justify-start flex-col items-start">
                      <p class="text-lg font-bold ">samansayyar</p>
                      <p class="text-gray-600 text-sm ">samansayyar</p>
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
                  src="https://wallpaperaccess.com/full/345330.jpg"
                  alt="saman"
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
                        class="w-8 h-8 hover:fill-red-500 hover:text-red-500 text-gray-600"
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
                    <p class="font-bold text-lg text-gray-700">234 likes</p>
                  </div>
                  <div class="text-base">
                    <span class="text-gray-600 leading-relaxed text-base">gnfi</span> Lorem ipsum dolor
                    sit amet consectetur adipisicing elit. Porro impedit
                    nesciunt nihil architecto, omnis voluptatem quos
                    repellendus, quis ab id esse vero cum magnam itaque quod,
                    similique tempora recusandae ea..
                  </div>

                  <div class="text-gray-500 leading-loose text-base font-semibold">
                    View all 877 comments
                  </div>

                  <div class="w-full">
                    <p class="text-sm font-normal text-gray-400">10 hours ago</p>
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
                          class="w-full text-sm py-4 px-3 rounded-none focus:outline-none" />
                      </div>
                      <div class="w-20">
                        <button
                          class="border-none text-sm px-4 bg-white py-4 text-indigo-600 focus:outline-none">
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

          <!-- 1st Post Background Pulse animation -->
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
              class="flex flex-col space-y-4 filter animate-pulse duration-500">
              <div
                class="p-10 bg-gradient-to-r to-indigo-700 from-blue-900 absolute top-20 left-20"></div>
              <div
                class="p-10 bg-gradient-to-r to-indigo-700 from-blue-900 absolute bottom-20 right-20"></div>
            </div>
          </div>


          <!-- 1st Post  -->
          <div
            class="mx-auto flex justify-center max-w-4xl md:mb-8 mt-9 bg-white rounded-lg items-center relative md:p-0 p-8"
            x-data="{
        comment : false,
    }">
            <div class="h-full relative">
              <div class="py-2 px-2">
                <div class="flex justify-between items-center py-2">
                  <div class="relative mt-1 flex">
                    <div class="mr-2 p-1">
                      <img
                        src="https://avatars.githubusercontent.com/u/68494287?v=4"
                        alt="saman sayyar"
                        class="w-10 h-10 rounded-full object-cover" />
                    </div>
                    <div class="ml-3 flex justify-start flex-col items-start">
                      <p class="text-lg font-bold ">samansayyar</p>
                      <p class="text-gray-600 text-sm ">samansayyar</p>
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
                  src="https://wallpaperaccess.com/full/345330.jpg"
                  alt="saman"
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
                        class="w-8 h-8 hover:fill-red-500 hover:text-red-500 text-gray-600"
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
                    <p class="font-bold text-lg text-gray-700">234 likes</p>
                  </div>
                  <div class="text-base">
                    <span class="text-gray-600 leading-relaxed text-base">gnfi</span> Lorem ipsum dolor
                    sit amet consectetur adipisicing elit. Porro impedit
                    nesciunt nihil architecto, omnis voluptatem quos
                    repellendus, quis ab id esse vero cum magnam itaque quod,
                    similique tempora recusandae ea..
                  </div>

                  <div class="text-gray-500 leading-loose text-base font-semibold">
                    View all 877 comments
                  </div>

                  <div class="w-full">
                    <p class="text-sm font-normal text-gray-400">10 hours ago</p>
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
                          class="w-full text-sm py-4 px-3 rounded-none focus:outline-none" />
                      </div>
                      <div class="w-20">
                        <button
                          class="border-none text-sm px-4 bg-white py-4 text-indigo-600 focus:outline-none">
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

        </div>


        <!-- Trial Modified -->



      </div>
    </div>
    <!-- End Content -->
  </main>

  <!-- Footer -->
  <footer
    class="bg-white border-t border-gray-200 w-full md:w-[calc(100%-288px)] md:ml-72 transition-all footer">
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

  <!-- Home Page NavBar Sidebar Don't Touch -->
  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    // end: Tab

    // // start: Chart
    // new Chart(document.getElementById('order-chart'), {
    //     type: 'line',
    //     data: {
    //         labels: generateNDays(7),
    //         datasets: [
    //             {
    //                 label: 'Active',
    //                 data: generateRandomData(7),
    //                 borderWidth: 1,
    //                 fill: true,
    //                 pointBackgroundColor: 'rgb(59, 130, 246)',
    //                 borderColor: 'rgb(59, 130, 246)',
    //                 backgroundColor: 'rgb(59 130 246 / .05)',
    //                 tension: .2
    //             },
    //             {
    //                 label: 'Completed',
    //                 data: generateRandomData(7),
    //                 borderWidth: 1,
    //                 fill: true,
    //                 pointBackgroundColor: 'rgb(16, 185, 129)',
    //                 borderColor: 'rgb(16, 185, 129)',
    //                 backgroundColor: 'rgb(16 185 129 / .05)',
    //                 tension: .2
    //             },
    //             {
    //                 label: 'Canceled',
    //                 data: generateRandomData(7),
    //                 borderWidth: 1,
    //                 fill: true,
    //                 pointBackgroundColor: 'rgb(244, 63, 94)',
    //                 borderColor: 'rgb(244, 63, 94)',
    //                 backgroundColor: 'rgb(244 63 94 / .05)',
    //                 tension: .2
    //             },
    //         ]
    //     },
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     }
    // });

    // function generateNDays(n) {
    //     const data = []
    //     for(let i=0; i<n; i++) {
    //         const date = new Date()
    //         date.setDate(date.getDate()-i)
    //         data.push(date.toLocaleString('en-US', {
    //             month: 'short',
    //             day: 'numeric'
    //         }))
    //     }
    //     return data
    // }
    // function generateRandomData(n) {
    //     const data = []
    //     for(let i=0; i<n; i++) {
    //         data.push(Math.round(Math.random() * 10))
    //     }
    //     return data
    // }
    // // end: Chart
  </script>
</body>

</html>



<script>
  //   <div
  //             class="mx-auto flex justify-center items-center filter blur-2xl animate-pulse duration-500 transition w-full"
  //           >
  //             <div class="mr-10 flex relative">
  //               <div
  //                 class="p-44 rounded-full bg-gradient-to-r to-indigo-700 from-pink-900 absolute top-20 right-0"
  //               ></div>
  //               <div
  //                 class="p-44 rounded-full bg-gradient-to-r to-pink-700 from-indigo-900 absolute md:flex hidden"
  //               ></div>
  //             </div>
  //             <!-- Right Side -->
  //             <div class="flex flex-col absolute top-8 right-10 space-y-4">
  //               <div
  //                 class="p-5 rounded-full bg-gradient-to-r to-pink-700 via-red-500 from-indigo-900 absolute right-16 top-10"
  //               ></div>
  //             </div>
  //             <div class="flex flex-col absolute bottom-8 right-10 space-y-4">
  //               <div
  //                 class="p-10 rounded-full bg-gradient-to-r to-pink-700 from-indigo-900 absolute right-16 bottom-10"
  //               ></div>
  //             </div>
  //             <!--  Left side -->
  //             <div
  //               class="flex flex-col space-y-4 filter animate-pulse duration-500"
  //             >
  //               <div
  //                 class="p-10 bg-gradient-to-r to-indigo-700 from-blue-900 absolute top-20 left-20"
  //               ></div>
  //               <div
  //                 class="p-10 bg-gradient-to-r to-indigo-700 from-blue-900 absolute bottom-20 right-20"
  //               ></div>
  //             </div>
  //           </div>
  //         </div>

  //         <div
  //           class="mx-auto flex justify-center max-w-4xl md:mb-8 mt-4 bg-white rounded-lg items-center relative md:p-0 p-8"
  //           x-data="{
  //         comment : false,
  //     }"
  //         >
  //           <div class="h-full relative">
  //             <div class="py-2 px-2">
  //               <div class="flex justify-between items-center py-2">
  //                 <div class="relative mt-1 flex">
  //                   <div class="mr-2">
  //                     <img
  //                       src="https://avatars.githubusercontent.com/u/68494287?v=4"
  //                       alt="saman sayyar"
  //                       class="w-10 h-10 rounded-full object-cover"
  //                     />
  //                   </div>
  //                   <div class="ml-3 flex justify-start flex-col items-start">
  //                     <p class="text-gray-900 text-sm">samansayyar</p>
  //                     <p class="text-gray-600 text-xs">samansayyar</p>
  //                   </div>
  //                   <!-- <span class="text-xs mx-2">•</span>
  //                        <button class="text-indigo-500 text-sm capitalize flex justify-start items-start">follow</button> -->
  //                 </div>
  //                 <button
  //                   type="button"
  //                   class="relative p-2 focus:outline-none border-none bg-gray-100 rounded-full"
  //                 >
  //                   <svg
  //                     class="w-5 h-5 text-gray-700"
  //                     fill="none"
  //                     stroke="currentColor"
  //                     viewBox="0 0 24 24"
  //                     xmlns="http://www.w3.org/2000/svg"
  //                   >
  //                     <path
  //                       stroke-linecap="round"
  //                       stroke-linejoin="round"
  //                       stroke-width="2"
  //                       d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"
  //                     ></path>
  //                   </svg>
  //                 </button>
  //               </div>
  //             </div>
  //             <div class="relative w-full h-full">
  //               <img
  //                 src="https://wallpaperaccess.com/full/345330.jpg"
  //                 alt="saman"
  //                 class="rounded-lg w-full h-full object-cover"
  //               />
  //             </div>
  //             <div class="">
  //               <!-- Comment -->
  //               <div
  //                 class="overflow-y-scroll w-full absolute inset-0 bg-white transform transition duration-200"
  //                 x-show="comment"
  //                 x-transition:enter="transition ease-out duration-200"
  //                 x-transition:enter-start="opacity-0 transform scale-90"
  //                 x-transition:enter-end="opacity-100 transform scale-100"
  //                 x-transition:leave="transition ease-in duration-100"
  //                 x-transition:leave-start="opacity-100 transform scale-100"
  //                 x-transition:leave-end="opacity-0 transform scale-90"
  //               >
  //                 <div
  //                   class="flex justify-start items-center py-2 px-4 border-b"
  //                   @click="comment = !comment"
  //                 >
  //                   <svg
  //                     class="w-8 h-8 text-gray-700"
  //                     fill="none"
  //                     stroke="currentColor"
  //                     viewBox="0 0 24 24"
  //                     xmlns="http://www.w3.org/2000/svg"
  //                   >
  //                     <path
  //                       stroke-linecap="round"
  //                       stroke-linejoin="round"
  //                       stroke-width="1.5"
  //                       d="M7 16l-4-4m0 0l4-4m-4 4h18"
  //                     ></path>
  //                   </svg>
  //                   <div
  //                     class="text-xl w-full text-center p-4 font-semibold justify-between"
  //                   >
  //                     Comments
  //                   </div>
  //                 </div>
  //                 <div class="p-2 mb-10">
  //                   <!-- System Comment -->
  //                   <div
  //                     class="flex justify-start flex-col space-y-3 items-start px-2 border-b border-gray-100"
  //                   >
  //                     <div class="relative mt-1 mb-3 pt-2 flex w-full">
  //                       <div class="mr-2">
  //                         <img
  //                           src="https://avatars.githubusercontent.com/u/68494287?v=4"
  //                           alt="saman sayyar"
  //                           class="w-12 h-12 rounded-full object-cover"
  //                         />
  //                       </div>
  //                       <div class="ml-2 w-full" x-data="{ replies : false }">
  //                         <p class="text-gray-600 md:text-lg text-xs w-full">
  //                           <!-- Username User -->
  //                           <span class="font-normal text-gray-900"
  //                             >samansayyar</span
  //                           >
  //                           <!-- Username User -->
  //                           You Can see?
  //                         </p>
  //                         <div class="flex space-x-4 w-full">
  //                           <div class="time mt-1 text-gray-400 text-xs">
  //                             <p>2d</p>
  //                           </div>
  //                           <button
  //                             type="button"
  //                             class="focus:outline-none time mt-1 text-gray-400 text-sm"
  //                           >
  //                             <p>replay</p>
  //                           </button>
  //                         </div>
  //                         <button
  //                           type="button"
  //                           @click="replies = !replies"
  //                           class="focus:outline-none mt-3 flex justify-center items-center"
  //                         >
  //                           <p
  //                             class="text-sm text-center text-indigo-500 flex space-x-2"
  //                           >
  //                             <span>____ View replies (1)</span>
  //                             <svg
  //                               class="w-3 h-4"
  //                               fill="none"
  //                               stroke="currentColor"
  //                               viewBox="0 0 24 24"
  //                               xmlns="http://www.w3.org/2000/svg"
  //                             >
  //                               <path
  //                                 stroke-linecap="round"
  //                                 stroke-linejoin="round"
  //                                 stroke-width="2"
  //                                 d="M19 9l-7 7-7-7"
  //                               ></path>
  //                             </svg>
  //                           </p>
  //                         </button>
  //                         <div
  //                           x-show="replies"
  //                           x-transition=""
  //                           class="flex justify-start flex-col space-y-3 items-start px-2 border-b border-gray-100"
  //                           style="display: none"
  //                         >
  //                           <div class="relative mt-1 mb-3 pt-2 flex w-full">
  //                             <div class="mr-2">
  //                               <img
  //                                 src="https://avatars.githubusercontent.com/u/68494287?v=4"
  //                                 alt="saman sayyar"
  //                                 class="w-8 h-8 rounded-full object-cover"
  //                               />
  //                             </div>
  //                             <div
  //                               class="ml-2 w-full"
  //                               x-data="{ replies : true }"
  //                             >
  //                               <p
  //                                 class="text-gray-600 md:text-sm text-xs w-full"
  //                               >
  //                                 <!-- Username User -->
  //                                 <span class="font-normal text-gray-900"
  //                                   >samansayyar</span
  //                                 >
  //                                 <!-- Username User -->
  //                                 You Can see?
  //                               </p>
  //                               <div class="flex space-x-4">
  //                                 <div class="time mt-1 text-gray-400 text-xs">
  //                                   <p>2d</p>
  //                                 </div>
  //                                 <button
  //                                   type="button"
  //                                   class="focus:outline-none time mt-1 text-gray-400 text-xs"
  //                                 >
  //                                   <p>replay</p>
  //                                 </button>
  //                               </div>
  //                             </div>
  //                           </div>
  //                         </div>
  //                       </div>
  //                     </div>
  //                   </div>

  //                   <div
  //                     class="flex justify-start flex-col space-y-3 items-start px-2 border-b border-gray-300 rounded-sm"
  //                   >
  //                     <div class="relative w-full mt-1 mb-3 pt-2 flex">
  //                       <div class="mr-2">
  //                         <img
  //                           src="https://avatars.githubusercontent.com/u/68494287?v=4"
  //                           alt="saman sayyar"
  //                           class="w-12 h-12 rounded-full object-cover"
  //                         />
  //                       </div>
  //                       <div class="ml-2 w-full">
  //                         <p class="text-gray-600 md:text-lg text-xs w-full">
  //                           <!-- Username User -->
  //                           <span class="font-normal text-gray-900"
  //                             >samansayyar</span
  //                           >
  //                           <!-- Username User -->
  //                           You Can see?
  //                         </p>
  //                         <div class="time mt-1 text-gray-400 text-xs">
  //                           <p>2d</p>
  //                         </div>
  //                       </div>
  //                     </div>
  //                   </div>
  //                 </div>
  //               </div>

  //               <!-- System Like and tools Feed -->
  //               <div class="flex justify-between items-start p-2 py-">
  //                 <div class="flex space-x-2 items-center">
  //                   <button type="button" class="focus:outline-none Like">
  //                     <svg
  //                       class="w-8 h-8 hover:fill-red-500 hover:text-red-500 text-gray-600"
  //                       fill="none"
  //                       stroke="currentColor"
  //                       viewBox="0 0 24 24"
  //                       xmlns="http://www.w3.org/2000/svg"
  //                     >
  //                       <path
  //                         stroke-linecap="round"
  //                         stroke-linejoin="round"
  //                         stroke-width="1.6"
  //                         d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
  //                       ></path>
  //                     </svg>
  //                   </button>
  //                   <button
  //                     type="button"
  //                     class="focus:outline-none Comment"
  //                     @click="comment = !comment"
  //                   >
  //                     <svg
  //                       class="w-8 h-8 text-gray-600"
  //                       fill="none"
  //                       stroke="currentColor"
  //                       viewBox="0 0 24 24"
  //                       xmlns="http://www.w3.org/2000/svg"
  //                     >
  //                       <path
  //                         stroke-linecap="round"
  //                         stroke-linejoin="round"
  //                         stroke-width="1.6"
  //                         d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
  //                       ></path>
  //                     </svg>
  //                   </button>
  //                   <button type="button" class="focus:outline-none save">
  //                     <svg
  //                       class="w-7 h-7 mb-1 ml-1 text-gray-600 z-10"
  //                       fill="none"
  //                       stroke="currentColor"
  //                       viewBox="0 0 24 24"
  //                       xmlns="http://www.w3.org/2000/svg"
  //                     >
  //                       <path
  //                         stroke-linecap="round"
  //                         stroke-linejoin="round"
  //                         stroke-width="1.6"
  //                         d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
  //                       ></path>
  //                     </svg>
  //                   </button>
  //                 </div>
  //                 <div class="flex space-x-2 items-center">
  //                   <button type="button" class="focus:outline-none Like">
  //                     <svg
  //                       class="w-8 h-8 text-gray-600"
  //                       fill="none"
  //                       stroke="currentColor"
  //                       viewBox="0 0 24 24"
  //                       xmlns="http://www.w3.org/2000/svg"
  //                     >
  //                       <path
  //                         stroke-linecap="round"
  //                         stroke-linejoin="round"
  //                         stroke-width="1.6"
  //                         d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"
  //                       ></path>
  //                     </svg>
  //                   </button>
  //                 </div>
  //               </div>
  //               <div class="p-2 ml-2 mr-2 flex flex-col space-y-3">
  //                 <div class="w-full">
  //                   <p class="font-bold text-sm text-gray-700">234 likes</p>
  //                 </div>
  //                 <div class="text-sm">
  //                   <span class="font-semibold">gnfi</span> Lorem ipsum dolor sit
  //                   amet consectetur adipisicing elit. Porro impedit nesciunt
  //                   nihil architecto, omnis voluptatem quos repellendus, quis ab
  //                   id esse vero cum magnam itaque quod, similique tempora
  //                   recusandae ea..
  //                 </div>

  //                 <div class="text-gray-500 text-sm">View all 877 comments</div>

  //                 <div class="w-full">
  //                   <p class="text-xs text-gray-400">10 hours ago</p>
  //                 </div>
  //               </div>
  //               <!-- End System Like and tools Feed -->
  //               <div class="z-50">
  //                 <form>
  //                   <div
  //                     class="flex justify-between border-t items-center w-full"
  //                     :class="comment ? 'absolute bottom-0' : '' "
  //                   >
  //                     <div class="w-full">
  //                       <input
  //                         type="text"
  //                         name="comment"
  //                         id="comment"
  //                         placeholder="Add A Comment..."
  //                         class="w-full text-sm py-4 px-3 rounded-none focus:outline-none"
  //                       />
  //                     </div>
  //                     <div class="w-20">
  //                       <button
  //                         class="border-none text-sm px-4 bg-white py-4 text-indigo-600 focus:outline-none"
  //                       >
  //                         <i class="bx bx-send text-3xl"></i>
  //                       </button>
  //                     </div>
  //                   </div>
  //                 </form>
  //               </div>
  //             </div>
  //           </div>
  //         </div>
</script>
  <?php include("../../../config/connect.php"); ?>

  <?php

    $user_id = $_SESSION['user_id'];

    if (!$user_id) {
        echo "<script>alert('User not logged in.'); window.location.href='../login_in.php';</script>";
        exit;
    } else {
        //echo "<script>alert('$user_id');</script>";
    }

    // $ADMIN_ID=1;
    $sql = "SELECT * FROM administration WHERE admin_id = '1'";                                        //to be changed
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        $name = $row['name'];
        $type = $row['role'] == "super" ? "Super Admin" : "Admin";
        $profile = $row['profile_picture']; //Original String
        $profile = preg_replace('/^\.\.\//', '', $profile); // Remove "../" from the start
        //echo "<script>alert('$profile');</script>";  

    }

    ?>

  <!--sidenav -->
  <div
      class="fixed left-0 top-0 w-72 h-full bg-gray-800 p-4 z-50 sidebar-menu transition-transform">
      <!-- <a href="#" class="flex items-center justify-items-center text-center pb-4 border-b border-b-gray-800 bg-black">
             <div class="inline-block p-2 rounded-full mb-4 bg-red-600">
                <div class="h-10 w-10 rounded-full shadow-md flex items-center justify-center overflow-hidden">
                    <img src="../assets/Screenshot 2025-02-05 215045.svg" class="profile-image2 object-cover" alt="Profile Image">
                </div>
            </div>
             <div class="font-bold text-2xl">Volunteer<span class="bg-[#42eda3] text-white px-2 ml-1 rounded-md">HUB</span></div>
           
        </a> -->
      <!-- Volunteer Logo -->
      <div

          class="flex items-center justify-items-center text-center text-white bg-gray-800 rounded-lg border-b border-b-white w-full p-2">
          <div class="inline-block p-1 rounded-full bg-red-400">
              <div
                  class="h-10 w-10 rounded-full shadow-md flex items-center justify-center overflow-hidden">
                  <img
                      src="../../assets/Screenshot 2025-02-05 215045.svg"
                      class="profile-image2 object-cover"
                      alt="Profile Image" />
              </div>
          </div>
          <div class="font-bold text-2xl w-full">
              Admin Dashboard</span>
          </div>
      </div>
      <ul class="mt-4">
          <!-- <span class="text-gray-400 font-bold">Home</span> -->
          <li class="mb-1 group">
              <a
                  href="admin_control_panel.php"
                  class="flex font-semibold items-center py-2 px-4 text-white hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                  <i class="ri-home-2-line mr-3 text-lg"></i>
                  <span class="text-sm">Dashboard</span>
              </a>
          </li>


          <!-- <li class="mb-1 group">
              <a
                  href="#"
                  class="flex font-semibold items-center py-2 px-4 text-white hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                  <i class="bx bx-list-ul mr-3 text-lg"></i>
                  <span class="text-sm">Explore Post</span>
              </a>
          </li> -->
          <!-- <li class="mb-1 group">
              <a
                  href="#"
                  class="flex font-semibold items-center py-2 px-4 text-white hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                  <svg class="w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                  </svg>
                  <span class="text-sm">User</span>
              </a>
          </li> -->
      </ul>
      <ul class=" mt-4">
          <!-- Events Section Sidebar -->
          <span class="text-gray-400 font-bold mb-10">Manage</span>

          <li class="mb-1 mt-2 group">
              <a
                  href="user_management.php"
                  class="flex font-semibold items-center py-2 px-4 text-white hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                  <svg class="w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                  </svg>
                  <span class="text-sm">User</span>
              </a>
          </li>
          <li class="mb-1 group">
              <a
                  href="#"
                  class="flex font-semibold items-center py-2 px-4 text-white hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                  <svg class="w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>

                  <span class="text-sm">Events</span>
              </a>
          </li>
          <li class="mb-1 group">
              <a
                  href="#"
                  class="flex font-semibold items-center py-2 px-4 text-white hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                  <svg class="w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                  </svg>

                  <span class="text-sm">Posts</span>
              </a>
          </li>

      </ul>
      <ul class=" mt-4">


          <!-- PERSONAL SECTION SIDEBAR -->
          <span class="text-gray-400 font-bold">Admin Management</span>
          <li class="mb-1 mt-1 group">
              <a
                  href="#"
                  class="flex font-semibold items-center py-2 px-4 text-white hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                  <i class='bx bx-plus-circle text-gray-400 mr-3 text-xl'></i>
                  <span class="  text-sm">Add Admin</span>
              </a>
          </li>
          <li class="mb-1 mt-1 group">
              <a
                  href="#"
                  class="flex font-semibold items-center py-2 px-4 text-white hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                  <i class='bx bxs-cog text-gray-400 mr-3 text-xl'></i>

                  <span class="text-sm">Edit Roles</span>
              </a>
          </li>
          <li class="mb-1 group">
              <a
                  href="../pages/manage_post.php"
                  class="flex font-semibold items-center py-2 px-4 text-white hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                  <i class='bx bx-command text-gray-400 mr-3 text-xl'></i>
                  <span class="text-sm ">Manage Admin</span>

              </a>
          </li>
      </ul>
  </div>
  <div
      class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
  <!-- end sidenav -->
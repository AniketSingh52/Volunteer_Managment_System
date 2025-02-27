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

  <!-- Sidebar -->
  <?php include('../layouts/sidebar.php'); ?>

  <main
    class="w-full md:w-[calc(100%-288px)] md:ml-72 bg-gray-200 min-h-screen transition-all main">
    <!-- navbar -->
    <?php include('../layouts/navbar.php'); ?>
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

            <div class="max-w-7xl mx-auto px-2 py-3">

              <?php
              $sql = "SELECT * FROM `events` ORDER BY `date_of_creation` DESC LIMIT 3";
              $result2 = $conn->query($sql);

              // Check if there are events
              if ($result2->num_rows > 0) {
                $rows = $result2->fetch_all(MYSQLI_ASSOC);
              ?>
                <!-- Single Carousel Wrapper -->
                <div class="relative h-[500px] overflow-hidden rounded-xl mb-10 group shadow-lg">
                  <div id="carousel" class="h-full">
                    <?php foreach ($rows as $row) {
                      $event_name = $row['event_name'];
                      $event_id = $row['event_id'];
                      $event_image = preg_replace('/^\.\.\//', '', $row['poster']);
                    ?>
                      <!-- Carousel Item -->
                      <div class="carousel-item relative h-full hidden">
                        <div class="absolute top-0 -right-10 bg-red-600 px-6 py-3 text-white mt-3 mr-5 font-semibold rotate-45 tracking-widest text-base hover:bg-white hover:text-indigo-600 transition duration-500 ease-in-out rounded-sm shadow-lg">
                          Latest
                        </div>
                        <img src="<?= $event_image ?>" alt="<?= $event_name ?>" class="w-full h-full object-cover" />
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-8">
                          <h2 class="text-4xl font-bold text-white mb-4"><?= $event_name ?></h2>
                          <button onclick="window.location.href='event_detail.php?id=<?= base64_encode($event_id) ?>'"
                            class="inline-flex justify-center rounded-lg bg-indigo-600 px-6 py-2 text-lg font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all duration-200 transform hover:-translate-y-0.5">
                            View Details
                          </button>
                        </div>
                      </div>
                    <?php } ?>
                  </div>

                  <!-- Carousel Controls -->
                  <button id="prevSlide" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:text-blue-700 hover:bg-white p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                  </button>
                  <button id="nextSlide" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:text-blue-700 hover:bg-white p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </button>
                </div>

              <?php
              } else {
                echo "<h1 class='text-3xl font-bold text-center mt-10'>No Events Available At the Moment</h1>";
              }
              ?>


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
  <?php include('../layouts/footer.php'); ?>

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
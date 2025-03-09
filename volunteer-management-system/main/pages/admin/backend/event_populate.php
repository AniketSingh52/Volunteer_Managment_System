<?php
include("../../../../config/connect.php"); // Database connection
session_start();

error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');
date_default_timezone_set("Asia/Kolkata");
$admin_id = $_SESSION['admin_id'];
$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['type'])) {
                    $type= $_POST['type'];


             
                            // SQL query to search in event_name and organiser columns
                            $sql = "SELECT * FROM `events` where status='$type' 
                            ORDER BY `date_of_creation` DESC";
                
                  

                    $checkResult = $conn->query($sql);

                    // Display results
                    if ($checkResult->num_rows > 0) {
                        while ($row = $checkResult->fetch_assoc()) {

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
                            // $event_image = preg_replace('/^\.\.\//', '', $event_image);
                            $date_of_creation = $row['date_of_creation'];
                            $status = $row['status'];
                            $flag = false;

                            //'Ongoing','Scheduled','Completed','Cancelled'
                            if ($status == "Ongoing") {
                                $status_style = " bg-green-500 hover:bg-green-800 ";
                            } elseif ($status == "Scheduled") {
                                $status_style = " bg-sky-500 hover:bg-sky-800 ";
                            } elseif ($status == "Completed") {
                                $status_style = " bg-indigo-500 hover:bg-indigo-800 ";
                            } else {
                                $status_style = " bg-red-500 hover:bg-red-800 ";
                                $flag = true;
                            }



                $sql = "SELECT * FROM `admin_manage_event` WHERE event_id=? ORDER by date Desc limit 1";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $event_id); // "i" for integer
                $stmt->execute();
                $result2 = $stmt->get_result();
                $user_status = "Active";
                $user_status_style = " bg-green-400 text-white ";
                if ($result2->num_rows > 0) {

                    $row = $result2->fetch_assoc();
                    // echo $row['action'];
                    $user_status = ($row['action'] == "Suspend") ? "Deactive" : "Active";
                    $user_status_style = ($row['action'] == "Suspend") ? " bg-red-500 text-white " : " bg-green-400 text-white ";
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
        <div class="md:w-1/3 relative group hover:scale-105 duration-300 transition-all">
                                        <img
                class="h-48 w-full object-cover md:h-full"
                src="' . $event_image . '"
                alt="' . htmlspecialchars($event_name) . '" />
                                        <div class="absolute top-4 left-4">
                                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-base font-medium  '. $user_status_style.' duration-300 transition-all  text-white shadow-lg">
                                               '.$user_status.'                                  </span>
                                        </div>
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
                    <span class=" ml-2 mt-1 bg-orange-100 text-orange-800 hover:bg-orange-200  rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300  cursor-pointer"> No Skill</span>
                    ';
                            }




                            echo '
                   
                </div>
            </div>

            <p class="mt-4 text-gray-600 example leading-relaxed text-base">
                ' . $description .
                    '
            </p>

          <div class="mt-6 flex space-x-4 action_list">
                <a href="event_detail.php?id=' . base64_encode($event_id) . '">
                    <button data-userid="' . $event_id . '" data-action="IGNORE"
                        class=" bg-gray-100 border-2 text-gray-700 w-[9rem]  px-6 py-2 rounded-lg font-semibold hover:bg-gray-200 hover:scale-105 duration-300 transition-all">
                        View More
                    </button>
                </a>

                ';

                if($user_status == "Active"){
                    echo '
                  
                    <button data-userid="'.$event_id. '" data-action="Suspend"
                        class=" bg-red-500 text-white px-6 py-2 rounded-lg w-[9rem]  font-semibold  hover:scale-105 duration-300 transition-all">
                        Deactive
                    </button>
         
                    ';
                }else{
                            echo '
                  
                    <button data-userid="' . $event_id . '" data-action="unsuspend"
                        class=" bg-green-500 text-white px-6 py-2 rounded-lg w-[9rem]  font-semibold  hover:scale-105 duration-300 transition-all">
                       Active 
                    </button>
      
                    ';
            }    


                            echo '
            </div>
        </div>
    </div>
</div>';
                        }
                    } else {
                        echo "<p class='text-gray-500 text-xl'>No events found.</p>";
                    }

                    
      
    }
} 

<?php
include("../../../config/connect.php"); // Database connection

// header('Content-Type: application/json');
ob_clean(); // Clean output buffer to avoid unexpected output
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');
// $_SERVER['REQUEST_METHOD'] = 'POST';
// $_POST['event_id']=10;
// $_POST['filter']= 'rejected';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['event_id']) && !empty($_POST['filter'])) {

        $event_id = $conn->real_escape_string($_POST['event_id']); // Prevent SQL injection
        $filter = $_POST['filter']; // Prevent SQL injection

        if($filter=="all"){
            $sql = "SELECT u.*, ea.status as applicunt_status, ea.date as date_of_application
                    FROM user u
                    JOIN events_application ea ON u.user_id = ea.volunteer_id
                    WHERE ea.event_id = ? ORDER BY ea.date ASC
                    ";
        }else{
        // Fetch application data from the database based on event_id
        $sql = "SELECT u.*, ea.status as applicunt_status, ea.date as date_of_application
                    FROM user u
                    JOIN events_application ea ON u.user_id = ea.volunteer_id
                    WHERE ea.event_id = ? AND ea.status='$filter' ORDER BY ea.date ASC
                    ";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $availabe = 1;
        } else {
            $availabe = 0;
        }
        $applications = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($applications as $applicunt){
                            $applicunt_status = "";
                            $applicunt_status_style = "";
                            $applicunt_id = $applicunt['user_id'];
                             $profile = $applicunt['profile_picture']; //Original String
                              $profile = preg_replace('/^\.\.\//', '', $profile); // Remove "../" from the start
                           
                            $date_of_joining = date('jS M y', strtotime($applicunt['registration_date']));
                            $date_of_application = date('jS M y', strtotime($applicunt['date_of_application']));
                            switch ($applicunt['applicunt_status']) {
                                case 'pending':
                                    $applicunt_status = 'Pending';
                                    $applicunt_status_style = "bg-amber-100 text-amber-800";
                                    break;
                                case 'rejected':
                                    $applicunt_status = 'Rejected';
                                    $applicunt_status_style = "bg-red-100 text-red-800";
                                    break;
                                case 'accepted':
                                    $applicunt_status = 'Accepted';
                                    $applicunt_status_style = "bg-green-100 text-green-800";
                                    break;
                            }

                            $gender = $applicunt['gender'];
                            switch ($gender) {
                                case 'M':
                                    $gender = 'Male';

                                    break;
                                case 'F':
                                    $gender = 'Female';

                                    break;
                                case 'O':
                                    $gender = 'Others';

                                    break;
                                default:
                                    $gender = 'Not Specified';
                                    break;
                            }


                            $query = "SELECT status,COUNT(*) AS total from events_application where volunteer_id=? group by status";

                            // Prepare and execute the statement
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("i", $applicunt_id); // "i" for integer
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Initialize variables
                            $accepted = 0;
                            $rejected = 0;
                            $pending = 0;


                            // Fetch the results and store in variables
                            while ($row = $result->fetch_assoc()) {
                                switch ($row['status']) {
                                    case 'accepted':
                                        $accepted = $row['total'];
                                        break;
                                    case 'pending':
                                        $pending = $row['total'];
                                        break;
                                    case 'rejected':
                                        $rejected = $row['total'];
                                        break;
                                }
                            }

                            echo'
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                                <div class="p-6">
                                    <!-- Header Section -->
                                    <div class="flex items-start justify-between">
                                        <div class="flex flex-grow space-x-6">
                                            <img
                                                src="'.$profile.'"
                                                alt="'.$applicunt['name'].'"
                                                class="h-24 w-24 rounded-lg object-cover border-2 border-gray-200">
                                            <div class="flex-1">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h3 class="text-2xl font-bold text-gray-900">'.$applicunt['name'].' <span class=" ml-3 text-sm text-gray-700 border-2 border-gray-200 shadow-sm rounded-xl px-2 py-1 bg-gray-200">'.$date_of_application .'</span></h3>
                                                        <p class="text-base text-gray-500">User ID: @.'.$applicunt['user_name'].'</p>
                                                    </div>
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium  .'.$applicunt_status_style.'">
                                                        '.$applicunt_status.'
                                                    </span>
                                                </div>
                                                <div class="mt-4 flex items-center space-x-4">
                                                    <div class="flex items-center">
                                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                        <p class="ml-1.5 text-base font-medium text-gray-600">Volunteer Score: 4900</p>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i data-lucide="clock" class="h-5 w-5 text-blue-500"></i>
                                                        <p class="ml-1.5 text-base font-medium text-gray-600">Joined: '. $date_of_joining .'</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Details Grid -->
                                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-4">
                                            <div>
                                                <h4 class="text-lg font-medium text-gray-500 mb-1">Personal Information</h4>
                                                <div class="space-y-2">
                                                    <div class="flex items-center">
                                                        <i data-lucide="calendar" class="h-4 w-4 text-blue-600 mr-2"></i>
                                                        <span class="text-base text-gray-600">DOB: '. $applicunt['DOB/DOE'] .'</span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i data-lucide="user" class="h-4 w-4 text-green-600 mr-2"></i>
                                                        <span class="text-base text-gray-600">Gender: '.$gender .'</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <h4 class="text-lg font-medium text-gray-500 mb-1">Contact Information</h4>
                                                <div class="space-y-2">
                                                    <div class="flex items-center">
                                                        <i data-lucide="mail" class="h-4 w-4 text-purple-700 mr-2"></i>
                                                        <span class="text-base text-gray-600">'.$applicunt['email'].'</span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i data-lucide="phone" class="h-4 w-4 text-indigo-800 mr-2"></i>
                                                        <span class="text-base text-gray-600">+91 '. $applicunt['contact'] .'</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-y-4">
                                            <div>
                                                <h4 class="text-lg font-medium text-gray-500 mb-1">Location</h4>
                                                <div class="space-y-2">
                                                    <div class="flex items-start">
                                                        <i data-lucide="map-pin" class="h-4 w-4 text-violet-700 mr-2 mt-0.5"></i>
                                                        <span class="text-base text-gray-600"> '.$applicunt['address'] .'</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <h4 class="text-lg font-medium text-gray-500 mb-1">Skills</h4>
                                                <div class="mt-2 flex flex-wrap gap-2">
';

                                                  
                                                    $sql = "SELECT skill_name FROM `skill` WHERE skill_id in (SELECT skill_id FROM `volunteer_skill` WHERE user_id=?)";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->bind_param("i", $applicunt_id);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    $index = 0;
                                                    $styles = [
                                                        "bg-amber-100 text-amber-800 hover:bg-amber-200",
                                                        "bg-violet-100 text-violet-800 hover:bg-violet-200",
                                                        "bg-rose-100 text-rose-800 hover:bg-rose-200",
                                                        "bg-fuchsia-100 text-fuchsia-800 hover:bg-fuchsia-200 ",
                                                        "bg-emerald-100 text-emerald-800 hover:bg-emerald-200 "
                                                    ];

                                                    if ($result->num_rows > 0) {

                                                        while ($row = $result->fetch_assoc()) {
                                                            $skill_name = $row['skill_name'];
                                                            $style = $styles[$index % 2];
                                                            $index++;
                                                            echo '
                                                         <span class=" ' . $style . '   inline-flex items-center px-3 py-1 rounded-full text-base font-medium  cursor-pointer">' . $skill_name . '</span>
                                                            ';
                                                        }
                                                    } else {
                                                        echo '
                                                            <span class=" bg-orange-100 text-orange-800 hover:bg-orange-200  rounded-xl px-4 py-2 font-medium hover:scale-105 transition-all duration-300 cursor-pointer"> No Skill</span>
                                                                                    ';
                                                    }


                                                   
                                                  echo'
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Statistics -->
                                    <div class="mt-6 grid grid-cols-2 gap-4">
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-base font-semibold text-gray-500">Events Attended</div>
                                            <div class="text-lg font-semibold text-gray-900">'.$accepted .'</div>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-base font-semibold text-gray-500">Events to Attend</div>
                                            <div class="text-lg font-semibold text-gray-900">'.$pending .'</div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-6 flex justify-end space-x-4">
                                        <button onclick="window.location.href=\'profile.php?'.base64_encode($applicunt_id).'\'" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            View Full Profile
                                        </button>
                                        <div class="applicunt_action">
';

                                         if ($applicunt_status == 'Accepted') {
                                                echo '
                                             <button data-action="rejected" data-userid="' . $applicunt_id . '" class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Reject
                                            </button>
                                            ';
                                            } elseif ($applicunt_status == 'Rejected') {
                                                echo '
                                                 <button data-action="accepted" data-userid="' . $applicunt_id . '" class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Accept
                                               </button>
                                                ';
                                            } else {
                                                echo'
                                                <button data-action="rejected" data-userid="'. $applicunt_id.'" class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    Reject
                                                </button>
                                                <button data-action="accepted" data-userid="'. $applicunt_id .'" class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                    Accept
                                                </button>
                                            ';
                                            } 
                                            echo'
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            ';

                        }
        if ($availabe == 0) {
            echo "<h1 class=' text-2xl h-72 text-center mb-40'>No Applications Yet</h1> ";
        }

    } else {
        $response = ['status' => 'error', 'message' => 'Invalid event ID, user_is and action!'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method!'];
}


exit;


?>

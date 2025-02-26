 <?php
    include("../../../config/connect.php"); // Connection to the database
    if (
        $_SERVER['REQUEST_METHOD'] == 'POST'
    ) {
        if (!empty($_POST['type']) && !empty($_POST['user_id'])) {
            $type = $_POST['type'];
            $user_id = $_POST['user_id'];

            $sql = "SELECT e.*, ea.status as applicunt_status, ea.date as date_of_application
                    FROM events e
                    JOIN events_application ea ON e.event_id = ea.event_id
                    WHERE ea.volunteer_id = ? AND ea.status=? ORDER BY ea.date DESC
                    ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $user_id, $type);
            $stmt->execute();
            $result2 = $stmt->get_result();
            if ($result2->num_rows > 0) {
                $availabe = 1;
            } else {
                $availabe = 0;
            }

            if ($result2->num_rows > 0) {

                $rows = $result2->fetch_all(MYSQLI_ASSOC);
                foreach ($rows as $row) {

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
                    $event_image = preg_replace('/^\.\.\//', '', $event_image);
                    $date_of_creation = $row['date_of_creation'];
                    $status = $row['status'];
                    $applicunt_status = $row['applicunt_status'];
                    $application_date = date('jS M y', strtotime($row['date_of_application']));


                    switch ($applicunt_status) {
                        case 'pending':
                            $applicunt_status = 'Pending';
                            $applicunt_status_style = "bg-amber-200 text-amber-800";
                            break;
                        case 'rejected':
                            $applicunt_status = 'Rejected';
                            $applicunt_status_style = "bg-red-200 text-red-800";
                            break;
                        case 'accepted':
                            $applicunt_status = 'Accepted';
                            $applicunt_status_style = "bg-green-200 text-green-800";
                            break;
                    }

                    //'Ongoing','Scheduled','Completed','Cancelled'
                    if ($status == "Ongoing") {
                        $status_style = " bg-green-500 hover:bg-green-800 ";
                    } elseif ($status == "Scheduled") {
                        $status_style = " bg-sky-500 hover:bg-sky-800 ";
                    } elseif ($status == "Completed") {
                        $status_style = " bg-indigo-500 hover:bg-indigo-800 ";
                    } else {
                        $status_style = " bg-red-500 hover:bg-red-800 ";
                    }


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

                    $sql = "SELECT * FROM `user` WHERE user_id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $organization_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $organization_name = $row['name'];
                    $organization_email = $row['email'];
                    echo '
<div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                                <div class="md:flex">
                                    <div class="md:w-1/3 relative group">
                                        <img
                                            src="' . $event_image . '"
                                            alt="' . $event_name . '"
                                            class="h-48 w-full object-cover md:h-full transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute top-4 left-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ' . $status_style . ' text-white shadow-lg">
                                                ' . $status . '
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-6 md:w-2/3">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <div
                                                    class="uppercase mb-2  tracking-wide text-sm text-blue-600 font-semibold">
                                                    ' . $organization_name . '
                                                    <span class=" ml-3 text-gray-700 border-2 border-gray-200 shadow-sm rounded-xl px-2 py-1 bg-gray-200">' . $application_date . '</span>
                                                </div>
                                                <h3 class="text-xl font-bold text-gray-900">' . $event_name . '


                                                </h3>
                                                <div class="mt-2 flex flex-col items-start text-gray-500 text-sm space-y-2">
                                                    <span class="mt-2 flex items-center font-normal text-base text-gray-600">
                                                        <svg class="h-5 w-5 mr-2 bg-sky-100 rounded-lg text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        ' . $from_date . ' • ' . $to_date . '
                                                    </span>
                                                    <span class="mt-2 flex items-center font-normal text-base text-gray-600">
                                                        <svg class="h-5 w-5 mr-2 bg-violet-100 rounded-lg text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        ' . $from_time . ' - ' . $to_time . '
                                                    </span>
                                                    <div class="mt-2 text-base flex items-center text-gray-600">
                                                        <svg
                                                            class="h-5 w-5 mr-2 text-sky-500"
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
                                                        ' . $location . '
                                                    </div>
                                                    <div class="mt-2 flex items-center font-semibold text-base text-gray-600">
                                                        <svg
                                                            class="h-5 w-5 mr-2 bg-green-100 rounded-lg text-green-600"
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
                                                        Volunteer Needed: ' . $accepted_count . '/' . $volunteer_needed . '
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
                        "bg-fuchsia-100 text-fuchsia-800 hover:bg-fuchsia-200 ",
                        "bg-emerald-100 text-emerald-800 hover:bg-emerald-200 "
                    ];

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            $cause_name = $row['name'];
                            $style = $styles[$index % 5];
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
                                                         ' . $description . '
                                                    </p>


                                                </div>
                                            </div>


                                            <div class="flex space-x-2">

                                                <span class="inline-flex items-center px-4 py-2 rounded-full hover:scale-105 transition-all text-base font-semibold ' . $applicunt_status_style . '">
                                                    ' . $applicunt_status . '
                                                </span>
                                            </div>
                                        </div>


                                        <div class="mt-6 flex justify-end space-x-4">
                                            <button onclick="window.location.href=\'event_detail.php?id=' . base64_encode($event_id) . '\'"
                                                class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                View Details
                                            </button>
                                            <button data-event_id="' . $event_id . '" class="delete-application flex text-center px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-700 hover:scale-105 transition-all duration-300 " data-event-id="<?= $event_id ?>">
                                                Cancel
                                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


';
                }
            } else {

                echo "
                            <h1 class=' text-2xl font-semibold'>No Application Found</h1>
                            ";
            }
        } else {
            echo "
             <h1 class=' text-2xl font-semibold'>Error!!!</h1> ";
        }
    }






    ?>


 <script>
     $(function() {
         $(".example").moreLess({
             moreLabel: "... Read more",
             lessLabel: "... Read less",
             moreClass: "read-more-link",
             lessClass: "read-less-link",
             wordsCount: 20,
         });
     });
 </script>
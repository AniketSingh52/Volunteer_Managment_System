 <?php
    include("../../../config/connect.php"); // Connection to the database
    if ($_SERVER['REQUEST_METHOD'] == 'POST'
    ) {
        if (!empty($_POST['type']) && !empty($_POST['org_id'])) {
            $type = $_POST['type'];
            $organizer_id= $_POST['org_id'];
            $sql = "SELECT * FROM `events`
            WHERE organization_id = ? AND status=? 
            ORDER BY `date_of_creation` DESC";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $organizer_id,$type);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($rows as $row) {

                    $event_id = $row['event_id'];
                    $event_name = $row['event_name'];
                    $from_date = date('jS M y', strtotime($row['from_date']));
                    $to_date = date('jS M y', strtotime($row['to_date']));
                    $from_time = $row['from_time'];
                    $to_time = $row['to_time'];

                    $from_time = date("h:i A", strtotime($from_time));
                    $to_time = date("h:i A", strtotime($to_time));
                    $volunteer_needed = $row['volunteers_needed'];
                    $max_application = $row['maximum_application'];

                    $event_image = $row['poster'];
                    $event_image = preg_replace('/^\.\.\//', '', $event_image);
                    $date_of_creation = $row['date_of_creation'];
                    $status = $row['status'];

                    //'Ongoing','Scheduled','Completed','Cancelled'
                    if ($status == "Ongoing") {
                        $status_style = " bg-green-500 hover:bg-green-800/90  duration-300 transition-all ";
                    } elseif ($status == "Scheduled") {
                        $status_style = " bg-sky-500 hover:bg-sky-800/90  duration-300 transition-all ";
                    } elseif ($status == "Completed") {
                        $status_style = " bg-indigo-500 hover:bg-indigo-800/90  duration-300 transition-all ";
                    } else {
                        $status_style = " bg-red-500 hover:bg-red-800/90  duration-300 transition-all ";
                    }

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



                    echo
                    '
                     <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
             <div class="md:flex">
                 <div class="md:w-1/3 relative group">
                     <img
                         src="'.$event_image.'"
                         alt="'.$event_name.'"
                         class="h-48 w-full object-cover md:h-full transition-transform duration-300 group-hover:scale-105">
                     <div class="absolute top-4 left-4">
                         <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium '. $status_style.' text-white shadow-lg">
                            '.$status.'
                         </span>
                     </div>
                 </div>
                 <div class="p-6 md:w-2/3">
                     <div class="flex justify-between items-start">
                         <div>
                             <h3 class="text-xl font-bold text-gray-900">'.$event_name.'
                                 <span class=" ml-3 text-gray-700 border-2 text-sm border-gray-200 shadow-sm rounded-xl px-2 py-1 bg-gray-200">'.$days_ago.'</span>

                             </h3>
                             <div class="mt-2 flex flex-col items-start text-gray-500 text-sm space-y-2">
                                 <span class="mt-2 flex items-center font-normal text-base text-gray-600">
                                     <svg class="h-5 w-5 mr-2 bg-sky-100 rounded-lg text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                     </svg>
                                     '.$from_date.' • '. $to_date.'
                                 </span>
                                 <span class="mt-2 flex items-center font-normal text-base text-gray-600">
                                     <svg class="h-5 w-5 mr-2 bg-violet-100 rounded-lg text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                     </svg>
                                    '. $from_time .' - '. $to_time.'
                                 </span>
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
                                     Volunteer Needed: 0/'.$volunteer_needed. '
                                 </div>
                                   <div class="mt-2 flex items-center font-bold text-base text-gray-600">
                                                        <svg
                                                            class="h-5 w-5 mr-2 bg-green-100 rounded-lg text-fuchsia-600"
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
                                                        Max Application: 0/'.$max_application.'
                                                    </div>
                             </div>
                         </div>


                         <div class="flex space-x-2">
                             <button class="p-2 text-gray-400 hover:text-gray-500" onclick="window.location.href=\'edit_event.php?id='.base64_encode($event_id).'\'">
                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                 </svg>
                             </button>
                             <button class="delete-event p-2 text-gray-400 hover:text-gray-500" data-event-id="'.$event_id. '">
                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                 </svg>
                             </button>
                         </div>
                     </div>

                     <div class="mt-4">
                         <div class="grid grid-cols-3 gap-4">
                             <div class="bg-gray-100 shadow-md p-4 rounded-lg text-center ">
                                 <p class="text-sm font-medium text-gray-500">Total Applications</p>
                                 <p class="mt-2 text-xl font-bold text-gray-900">'.$total_applications.'</p>
                             </div>
                             <div class="bg-gray-100 shadow-md p-4 rounded-lg text-center">
                                 <p class="text-sm font-medium text-gray-500">Approved</p>
                                 <p class="mt-2 text-xl font-bold text-green-600">'.$accepted_count.'</p>
                             </div>
                             <div class="bg-gray-100 shadow-md p-4 rounded-lg text-center">
                                 <p class="text-sm font-medium text-gray-500">Pending</p>
                                 <p class="mt-2 text-xl font-bold text-amber-500">'.$pending_count.'</p>
                             </div>
                         </div>
                     </div>

                     <div class="mt-6 flex justify-end space-x-4">
                         <button onclick="window.location.href=\'event_detail.php?id='. base64_encode($event_id) . '\'"
                             class="px-4 py-2 border hover:scale-105 transition-all duration-300 border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                             View Details
                         </button>
                         <button onclick="window.location.href=\'Event_Applications.php?id='. base64_encode($event_id).'\'"
                             class="px-4 py-2 border hover:scale-105 transition-all duration-300 border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                             View Applications
                         </button>
                     </div>
                 </div>
             </div>
         </div>        
                  ';

        }
        }
         else {

            echo "
                            <h1 class=' text-2xl font-semibold text-center mt-12'>No Event Found</h1>
                            ";
        }
    }else{
            echo "
                            <h1 class=' text-2xl font-semibold'>Error!!!</h1> ";
    }
}


    



    ?>

         <!-- Event Card 1 -->
         <!-- <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
             <div class="md:flex">
                 <div class="md:w-1/3 relative group">
                     <img
                         src="<?= $event_image ?>"
                         alt="<?= $event_name ?>"
                         class="h-48 w-full object-cover md:h-full transition-transform duration-300 group-hover:scale-105">
                     <div class="absolute top-4 left-4">
                         <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $status_style ?> text-white shadow-lg">
                             <?= $status ?>
                         </span>
                     </div>
                 </div>
                 <div class="p-6 md:w-2/3">
                     <div class="flex justify-between items-start">
                         <div>
                             <h3 class="text-xl font-bold text-gray-900"><?= $event_name ?>
                                 <span class=" ml-3 text-gray-700 border-2 text-sm border-gray-200 shadow-sm rounded-xl px-2 py-1 bg-gray-200"><?= $days_ago ?></span>

                             </h3>
                             <div class="mt-2 flex flex-col items-start text-gray-500 text-sm space-y-2">
                                 <span class="mt-2 flex items-center font-normal text-base text-gray-600">
                                     <svg class="h-5 w-5 mr-2 bg-sky-100 rounded-lg text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                     </svg>
                                     <?= $from_date ?> • <?= $to_date ?>
                                 </span>
                                 <span class="mt-2 flex items-center font-normal text-base text-gray-600">
                                     <svg class="h-5 w-5 mr-2 bg-violet-100 rounded-lg text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                     </svg>
                                     <?= $from_time ?> - <?= $to_time ?>
                                 </span>
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
                                     Volunteer Needed: 0/<?= $volunteer_needed ?>
                                 </div>
                             </div>
                         </div>


                         <div class="flex space-x-2">
                             <button class="p-2 text-gray-400 hover:text-gray-500" onclick="window.location.href='edit_event.php?id=<?= base64_encode($event_id) ?>'">
                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                 </svg>
                             </button>
                             <button class="delete-event p-2 text-gray-400 hover:text-gray-500" data-event-id="<?= $event_id ?>">
                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                 </svg>
                             </button>
                         </div>
                     </div>

                     <div class="mt-4">
                         <div class="grid grid-cols-3 gap-4">
                             <div class="bg-gray-100 shadow-md p-4 rounded-lg text-center ">
                                 <p class="text-sm font-medium text-gray-500">Total Applications</p>
                                 <p class="mt-2 text-xl font-bold text-gray-900">24</p>
                             </div>
                             <div class="bg-gray-100 shadow-md p-4 rounded-lg text-center">
                                 <p class="text-sm font-medium text-gray-500">Approved</p>
                                 <p class="mt-2 text-xl font-bold text-green-600">15</p>
                             </div>
                             <div class="bg-gray-100 shadow-md p-4 rounded-lg text-center">
                                 <p class="text-sm font-medium text-gray-500">Pending</p>
                                 <p class="mt-2 text-xl font-bold text-amber-500">9</p>
                             </div>
                         </div>
                     </div>

                     <div class="mt-6 flex justify-end space-x-4">
                         <button onclick="window.location.href='event_detail.php?id=<?= base64_encode($event_id) ?>'"
                             class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                             View Details
                         </button>
                         <button onclick="window.location.href='/events/1/applications'"
                             class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                             View Applications
                         </button>
                     </div>
                 </div>
             </div>
         </div> -->

 <?php
       
    ?>
 <?php
    include("../../../config/connect.php"); // Connection to the database

    if (
        $_SERVER['REQUEST_METHOD'] == 'POST'
    ) {
        if (!empty($_POST['user_id']) && !empty($_POST['current_id'])) {
            $user_id = $_POST['current_id']; // Logged-in user
            $chat_user_id = $_POST['user_id']; // Chatting with user 10

            //the receiver, the user with whom we are chating
            $sql = "SELECT user_name,name,profile_picture FROM user WHERE user_id='$chat_user_id'";
            $result2= $conn->query($sql);
            $row = $result2->fetch_assoc();
            $name=$row['name'];
            $username=$row['user_name'];
            $profile_img=$row['profile_picture'];
            $profile_img = preg_replace('/^\.\.\//', '', $profile_img);


            //sender loggedin user
            // $sql = "SELECT user_name,name,profile_picture FROM user WHERE user_id='$user_id'";
            // $result2 = $conn->query($sql);
            // $row = $result2->fetch_assoc();
            // $name2 = $row['name'];
            // $username2 = $row['user_name'];
            // $profile_img2 = $row['profile_picture'];
            // $profile_img2 = preg_replace('/^\.\.\//', '', $profile_img2);

            $sql = "SELECT 
            m.message_id,
            m.text AS message_text,
            m.date_time AS message_time,
            m.from_id,
            m.to_id,
            CASE 
                WHEN m.from_id = $user_id THEN 'sent' 
                ELSE 'received' 
            END AS message_type
        FROM messages m
        WHERE (m.from_id = $user_id AND m.to_id = $chat_user_id) 
           OR (m.from_id = $chat_user_id AND m.to_id = $user_id)
        ORDER BY m.date_time ASC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $message_id = $row['message_id'];
                    $message_text = $row['message_text'];
                    $message_time = strtotime($row['message_time']);
                    $message_type = $row['message_type'];  //sent, received

                    // Check if the date is today
                    if (date('Y-m-d', $message_time) == date('Y-m-d')) {
                        $formatted_time = "Today: " . date('h:i A', $message_time);
                    } else {
                        $formatted_time = date('M d, Y', $message_time);
                    }

                    if($message_type=='received')
                    {

                        echo '
                         <div class="flex items-end space-x-2">
                        <img
                            src="'.$profile_img.'"
                            alt="'.$name.'"
                            class="w-8 h-8 rounded-full object-cover">
                        <div class="max-w-md">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <p class="text-gray-800">'.$message_text.'</p>
                            </div>
                            <span class="text-xs text-gray-500 ml-2">'.$formatted_time.'</span>
                        </div>
                    </div>
                        ';
                    }elseif($message_type=='sent'){
                        echo '
                        <div class="flex items-end justify-end space-x-2">
                        <div class="max-w-md">
                            <div class="bg-blue-100 rounded-lg p-4 shadow-sm">
                                <p class="text-gray-800">'.$message_text.'</p>
                            </div>
                            <div class="flex items-center justify-end space-x-1">
                                <span class="text-xs text-gray-500">'.$formatted_time.'</span>
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                        ';

                    }

                }
            } else {
                echo "
                  <h1 class=' text-2xl font-semibold text-center mt-12'>No Message Found</h1>
                ";
            }
        } else {

            echo "
                    <h1 class=' text-2xl font-semibold text-center mt-12'>Wrong Method</h1>
                    ";
        }
    } else {
        echo "
            <h1 class=' text-2xl font-semibold'>Error!!!</h1> ";
    }







    ?>
 <!-- Received Message
 <div class="flex items-end space-x-2">
     <img
         src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150"
         alt="Jane Smith"
         class="w-8 h-8 rounded-full object-cover">
     <div class="max-w-md">
         <div class="bg-white rounded-lg p-4 shadow-sm">
             <p class="text-gray-800">Hi! Thanks for organizing the community garden event. It was really great!</p>
         </div>
         <span class="text-xs text-gray-500 ml-2">12:25 PM</span>
     </div>
 </div>
 -->
 <!-- Sent Message -->
 <!-- <div class="flex items-end justify-end space-x-2">
     <div class="max-w-md">
         <div class="bg-blue-100 rounded-lg p-4 shadow-sm">
             <p class="text-gray-800">You're welcome! I'm glad you enjoyed it. We're planning another one next month.</p>
         </div>
         <div class="flex items-center justify-end space-x-1">
             <span class="text-xs text-gray-500">12:28 PM</span>
             <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
             </svg>
         </div>
     </div>
 </div> --> 
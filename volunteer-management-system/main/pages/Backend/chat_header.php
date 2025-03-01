 <?php
    include("../../../config/connect.php"); // Connection to the database

    if (
        $_SERVER['REQUEST_METHOD'] == 'POST'
    ) {
        if (!empty($_POST['user_id']) && !empty($_POST['current_id'])) {
            $user_id = $_POST['current_id']; // Logged-in user
            $chat_user_id = $_POST['user_id']; // Chatting with user 10

            //the receiver, the user with whom we are chating
            $sql = "SELECT user_name,name,profile_picture,user_type FROM user WHERE user_id='$chat_user_id'";
            $result2 = $conn->query($sql);
            $row = $result2->fetch_assoc();
            $name = $row['name'];
            $username = $row['user_name'];
            $profile_img = $row['profile_picture'];
            $user_type= $row['user_type'];
            $user_type_text = ($user_type == 'V') ? "Volunteer" : "Organisation";
            $user_style = ($user_type == 'V') ? "bg-indigo-100 text-indigo-800" : "bg-green-100 text-green-800";
            $profile_img = preg_replace('/^\.\.\//', '', $profile_img);

            echo '
<a onclick="window.location.href=\'profile2.php?id='.base64_encode($chat_user_id).'\'">
            <div class="flex justify-between items-center">
     <div class="flex items-center space-x-4">
         <img
             src="'.$profile_img.'"
             alt="'.$username.'"
             class="w-10 h-10 rounded-full object-cover">
         <div>
             <h3 class="font-semibold tracking-wide text-gray-900">'.$name. '<span class=" ml-2 text-xs ' . $user_style . ' rounded-xl px-2 py-1">' . $user_type_text . '</span></h3>
             <p class="text-sm text-green-500">Online</p>
         </div>
     </div>
     <div class="flex items-center space-x-4">
        
         <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
             <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
             </svg>
         </button>
     </div>
 </div>
 </a>
            
            
            ';

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
<!-- 
 <div class="flex justify-between items-center">
     <div class="flex items-center space-x-4">
         <img
             src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150"
             alt="Jane Smith"
             class="w-10 h-10 rounded-full object-cover">
         <div>
             <h3 class="font-semibold text-gray-900">Jane Smith</h3>
             <p class="text-sm text-green-500">Online</p>
         </div>
     </div>
     <div class="flex items-center space-x-4">
         <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
             <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
             </svg>
         </button>
         <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
             <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
             </svg>
         </button>
         <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
             <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
             </svg>
         </button>
     </div>
 </div> -->
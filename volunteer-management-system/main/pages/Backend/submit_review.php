<?php
include('../../../config/connect.php');
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');

session_start();
$user_id = $_SESSION['user_id'];

if (!$user_id) {
    echo "<script>alert('User not logged in.'); window.location.href='../login_in.php';</script>";
    exit;
} else {
    //echo "<script>alert('$user_id');</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //To re-initialize the review list after submission
    if (isset($_POST['all_id']) && !empty($_POST['all_id']) && isset($_POST['event_id'])) {

        $event_id = $_POST['event_id'];
        $sql = "SELECT r.description, r.date_time, r.rating, u.name, u.profile_picture
                                 FROM feedback_rating r
                                JOIN user u ON r.volunteer_id = u.user_id
                                WHERE r.event_id = ?  ORDER BY `date_time` DESC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
               
            while ($row = $result->fetch_assoc()) {
                $profile = preg_replace('/^\.\.\//', '', $row['profile_picture']);

                echo '
                                    <div class="border-b pb-8">
                                        <div class="flex items-start space-x-6">
                                            <img src="' . $profile . '" alt="Reviewer" class="w-14 h-14 rounded-full object-cover border-2 border-gray-200">
                                            <div class="flex-1">
                                                <div class="flex items-start justify-between mb-2">
                                                    <div>
                                                        <h4 class="font-bold text-lg">' . $row['name'] . '</h4>
                                                        <div class="flex text-yellow-400 text-base">
                                                             ' . str_repeat("★", $row['rating']) . str_repeat("☆", 5 - $row['rating']) . '
                                                        </div>
                                                    </div>
                                                    <span class="text-sm text-gray-500">' . date('jS M Y', strtotime($row['date_time'])) . '</span>
                                                </div>
                                                <p class="mt-3 text-gray-600 text-lg leading-relaxed">' . $row['description'] . '</p>
                                            </div>
                                        </div>
                                    </div>
                
                
                ';
            }
       
        } else {
            echo "<h1>No Review Found</h1>";
        }

        //To submit the review
    } else {
        $event_id = $_POST['event_id'];
        $user_id = $_POST['user_id'];
        $rating = $_POST['rating'];
        $review_text = $_POST['review_text'];

        $sql = "INSERT INTO feedback_rating (description, date_time, rating, volunteer_id, event_id) VALUES (?, NOW(), ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siii", $review_text, $rating, $user_id, $event_id);

        if ($stmt->execute()) {
            echo "Success";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<?php
session_start();
$user_id = $_SESSION['user_id'];

include("../../../config/connect.php"); // Database connection

header('Content-Type: application/json');
ob_clean(); // Clean output buffer to avoid unexpected output
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');

$response = [];
$message="";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['event_id']) && !empty($_POST['user_id'])) {
        $event_id = $conn->real_escape_string($_POST['event_id']); // Prevent SQL injection
        $user_id = $conn->real_escape_string($_POST['user_id']); // Prevent SQL injection
        $current_date=date("Y-m-d");
        $status="pending";

        $stmt = $conn->prepare("INSERT INTO `events_application` (`event_id`,`volunteer_id`,date,status) 
                                         VALUES (?,?,?,?)");
        $stmt->bind_param(
            "iiss",
            $event_id,
            $user_id,
            $current_date,
            $status
        );

        if ($stmt->execute()) {
            $message = $message . "Applied Sucessfully";
            $response = ['status' => 'success', 'message' => $message];

        } else {
            //echo "Error: " . $stmt->error;
            $message = $message . "Application Failed \n";
            $response = ['status' => 'error', 'message' => $message];
        }

    } else {
        $response = ['status' => 'error', 'message' => 'Invalid event ID, user_id!'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method!'];
}

echo json_encode($response); // Ensure JSON response is always sent
exit;

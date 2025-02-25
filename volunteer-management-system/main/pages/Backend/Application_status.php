<?php
include("../../../config/connect.php"); // Database connection

header('Content-Type: application/json');
ob_clean(); // Clean output buffer to avoid unexpected output
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['event_id']) &&!empty($_POST['user_id']) &&!empty($_POST['action']) ) {
        $event_id = $conn->real_escape_string($_POST['event_id']); // Prevent SQL injection
        $user_id = $conn->real_escape_string($_POST['user_id']); // Prevent SQL injection
        $action = $conn->real_escape_string($_POST['action']); // Prevent SQL injection


    
        // Delete event query
        $deleteSql = "UPDATE `events_application` SET `status` = '$action' WHERE event_id = '$event_id' AND volunteer_id = '$user_id'";
        if ($conn->query($deleteSql)) {
            $response = ['status' => 'success', 'message' => 'Application! '.$action.' Successfully!'];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed Change the status!'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid event ID, user_is and action!'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method!'];
}

echo json_encode($response); // Ensure JSON response is always sent
exit;

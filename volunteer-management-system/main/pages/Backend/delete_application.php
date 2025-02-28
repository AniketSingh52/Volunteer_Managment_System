<?php
include("../../../config/connect.php"); // Database connection

header('Content-Type: application/json');
ob_clean(); // Clean output buffer to avoid unexpected output
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');

$response = [];
// $_SERVER['REQUEST_METHOD'] ='POST';
// $_POST['event_id']=7;
// $_POST['user_id']=19;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['event_id'])&& !empty($_POST['user_id'])) {
        $event_id = $_POST['event_id']; // Prevent SQL injection
        $user_id = $_POST['user_id']; // Prevent SQL injection

        // Delete event query
        $deleteSql = "DELETE FROM `events_application` WHERE event_id = '$event_id' AND volunteer_id='$user_id'";
        if ($conn->query($deleteSql)) {
            $response = ['status' => 'success', 'message' => 'Application Deleted Successfully!'];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to delete the Application!'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid event ID!'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method!'];
}

echo json_encode($response); // Ensure JSON response is always sent
exit;

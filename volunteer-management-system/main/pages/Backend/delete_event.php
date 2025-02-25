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
    if (!empty($_POST['event_id'])) {
        $event_id = $conn->real_escape_string($_POST['event_id']); // Prevent SQL injection
        
        // Delete event query
        $deleteSql = "DELETE FROM `events` WHERE event_id = '$event_id'";
        if ($conn->query($deleteSql)) {
            $response = ['status' => 'success', 'message' => 'Event Deleted Successfully!'];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to delete the event!'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid event ID!'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method!'];
}

echo json_encode($response); // Ensure JSON response is always sent
exit;

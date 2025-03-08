<?php
include("../../../../config/connect.php"); // Database connection
session_start();
header('Content-Type: application/json');
ob_clean(); // Clean output buffer to avoid unexpected output
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');
date_default_timezone_set("Asia/Kolkata");
$admin_id = $_SESSION['admin_id'];
$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['event_id']) && !empty($_POST['action'])) {

        $event_id = $conn->real_escape_string($_POST['event_id']); // Prevent SQL injection
        $action = $conn->real_escape_string($_POST['action']); // Prevent SQL injection
        $date = date("Y-m-d H:i:s");


        // Delete event query
        $deleteSql = "INSERT INTO admin_manage_event (`admin_id`, `event_id`, `date`,  `action`) VALUES ('$admin_id','$event_id','$date','$action')";
        if ($conn->query($deleteSql)) {
            $response = ['status' => 'success', 'message' => 'Event ' . $action . ' Successfully!'];
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

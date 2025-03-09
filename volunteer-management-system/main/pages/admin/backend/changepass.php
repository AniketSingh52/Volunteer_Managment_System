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
$user_id2 = $_SESSION['admin_id2'];
// $admin_id = $_SESSION['admin_id'];
$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['Cpassword']) && !empty($_POST['Npassword'])) {

     
        $password = $conn->real_escape_string($_POST['Cpassword']); // Prevent SQL injection
        $date = date("Y-m-d H:i:s");

        // Delete event query
        $deleteSql = "UPDATE administration SET password='$password' WHERE admin_id='$user_id2'";
        if ($conn->query($deleteSql)) {

            $_SESSION['admin_id'] = $user_id2;
          
            unset($_SESSION['user_id2']);
            $response = ['status' => 'success', 'message' => 'Password changed Successfully!'];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed Changing the password!'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid user ID, user_id and action!'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method!'];
}

echo json_encode($response); // Ensure JSON response is always sent
exit;

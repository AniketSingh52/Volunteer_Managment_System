<?php
include('../../../config/connect.php');

header('Content-Type: application/json');

//ob_clean(); // Cle // Return JSON response
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
date_default_timezone_set("Asia/Kolkata");
ini_set('error_log', 'error_log.txt');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //To re-initialize the review list after submission
    if (isset($_POST['from_id']) && !empty($_POST['to_id']) && isset($_POST['message'])) {
        $from_id = $_POST['from_id'];
        $to_id = $_POST['to_id'];
        $message = $_POST['message'];
        $date = date("Y-m-d H:i:s");
        //INSERT INTO `messages` (`message_id`, `text`, `date_time`, `status`, `message_type`, `from_id`, `to_id`) VALUES ('4', 'hkkk', current_timestamp(), 'sent', 'Private', '19', '17');
        $sql = "INSERT INTO messages (`text`, `date_time`, `status`,  `from_id`, `to_id`) VALUES (?, ?, 'sent',?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $message, $date, $from_id, $to_id);


        if ($stmt->execute()) {

            echo json_encode(['status' => 'success', 'message' => trim('Message sent !!!'), 'date' => trim("Today at: " . date("h:i A"))]);
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => trim('Failed To sent message!!!')]);
        }
    }
    // echo json_encode(['status' => 'error', 'message' => trim($message . ' Failed To Create The Post & invalis server method!!!')]);
    // echo json_encode(['status' => 'success', 'message' => $message]);
}

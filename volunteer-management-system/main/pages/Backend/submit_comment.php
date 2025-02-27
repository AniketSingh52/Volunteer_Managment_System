<?php
include('../../../config/connect.php');

header('Content-Type: application/json');

ob_clean(); // Cle // Return JSON response
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
date_default_timezone_set("Asia/Kolkata");
ini_set('error_log', 'error_log.txt');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //To re-initialize the review list after submission
    if (isset($_POST['post_id']) && !empty($_POST['comment']) && isset($_POST['user_id'])) {
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];
        $comment = $_POST['comment'];
        $date = date("Y-m-d H:i:s");

        $sql = "INSERT INTO comments (text, date_time, user_id, picture_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $comment, $date, $user_id, $post_id);

        

        if ($stmt->execute()) {

            $sql = "SELECT COUNT(*) AS Total FROM `comments` WHERE picture_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $post_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $comments_total = $row['Total'];

            echo json_encode(['status' => 'success', 'total' => $comments_total, 'message' => trim('Comments added!!!'), 'date' => trim("Today at: ".date("h:i A"))]);
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => trim('Failed To add comment!!!')]);
        }
    }
    // echo json_encode(['status' => 'error', 'message' => trim($message . ' Failed To Create The Post & invalis server method!!!')]);
    // echo json_encode(['status' => 'success', 'message' => $message]);
}

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
    if (isset($_POST['post_id'])) {
        $post_id = $_POST['post_id'];
        
        $sql = "UPDATE pictures SET likes = likes + 1 WHERE picture_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $post_id);



        if ($stmt->execute()) {

            $sql = "SELECT likes FROM `pictures` WHERE picture_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $post_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $likes = $row['likes'];

            echo json_encode(['status' => 'success', 'like' => $likes, 'message' => trim('likes added!!!') ]);
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => trim('Failed To add likes!!!')]);
        }
    }
    // echo json_encode(['status' => 'error', 'message' => trim($message . ' Failed To Create The Post & invalis server method!!!')]);
    // echo json_encode(['status' => 'success', 'message' => $message]);
}

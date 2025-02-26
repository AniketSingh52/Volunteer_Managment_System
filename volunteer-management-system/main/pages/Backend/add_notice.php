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
    if (isset($_POST['event_id']) && !empty($_POST['user_id']) && isset($_POST['notice_text'])) {
        $event_id = $_POST['event_id'];
        $user_id2 = $_POST['user_id'];
        $notice_text = $_POST['notice_text'];

        $sql = "INSERT INTO event_has_notices (notice, date, user_id, event_id) VALUES (?, NOW(), ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $notice_text, $user_id2, $event_id);

        if ($stmt->execute()) {
            echo "Success";
        } else {
            echo "Error: " . $conn->error;
        }
        
    } 
}

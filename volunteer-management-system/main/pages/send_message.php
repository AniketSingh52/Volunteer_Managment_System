<?php
include("../../config/connect.php");
session_start();

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from_id = $_SESSION['user_id'];
    $to_id = $_POST['to_id'];
    $message = $_POST['message'];
    
    $sql = "INSERT INTO messages (text, date_time, status, message_type, from_id, to_id) 
            VALUES (?, NOW(), 'sent', 'Private', ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $message, $from_id, $to_id);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Message sent successfully';
    } else {
        $response['message'] = 'Failed to send message';
    }
}

echo json_encode($response);
?> 
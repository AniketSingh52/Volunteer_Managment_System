<?php
include("../../config/connect.php");
session_start();

$current_user_id = $_SESSION['user_id'];
$other_user_id = $_GET['user_id'];

// Mark messages as read
$sql = "UPDATE messages 
        SET status = 'read' 
        WHERE from_id = ? AND to_id = ? AND status = 'sent'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $other_user_id, $current_user_id);
$stmt->execute();

// Get messages
$sql = "SELECT m.*, u.name, u.profile_picture 
        FROM messages m 
        JOIN user u ON m.from_id = u.user_id
        WHERE (m.from_id = ? AND m.to_id = ?) 
           OR (m.from_id = ? AND m.to_id = ?)
        ORDER BY m.date_time ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $current_user_id, $other_user_id, $other_user_id, $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
?> 
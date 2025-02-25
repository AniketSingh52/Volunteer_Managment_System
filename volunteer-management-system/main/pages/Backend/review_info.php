<?php
session_start();
$user_id = $_SESSION['user_id'];

if (!$user_id) {
    echo "<script>alert('User not logged in.'); window.location.href='../login_in.php';</script>";
    exit;
} else {
    //echo "<script>alert('$user_id');</script>";
}


//To re-initialize the review count and average
include('../../../config/connect.php');
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id=$_POST['event_id'];
    $sql = "SELECT COUNT(rating) AS TOTAL, AVG(rating) AS average FROM `feedback_rating` WHERE event_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $average = number_format($row['average'], 1);
    $count=$row['TOTAL'];
    $star = round($average);
    echo '
    <span class="text-3xl font-bold text-gray-900">'. $average .'</span>
    <div>
     <div class="flex text-yellow-400 text-sm">'.str_repeat("★", $star) . str_repeat("☆", 5 - $star).'</div>
      <span class="text-sm text-gray-500">'.$count.' reviews</span>
     </div>
    ';
    }
?>
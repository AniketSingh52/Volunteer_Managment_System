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
    if (!empty($_POST['post_id'])) {
        $post_id = $conn->real_escape_string($_POST['post_id']); // Prevent SQL injection
        $message = "Failed to delete the Event Image\n";

        // Get picture URL
        $sql = "SELECT picture_url FROM `pictures`
            WHERE picture_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            if ($row = $result->fetch_assoc()) {
                $picture_url = $row['picture_url'];
                // $picture_path = $picture_url;
                if (file_exists($picture_url)) {
                    unlink($picture_url);
                    $message=" Image deleted successfully! \n";
                }
            }
        }
        // Delete event query
        $deleteSql = "DELETE FROM `pictures` WHERE picture_id = '$post_id'";
        if ($conn->query($deleteSql)) {
            $response = ['status' => 'success', 'message' => trim($message).'Post Deleted Successfully!'];
        } else {
            $response = ['status' => 'error', 'message' => trim($message) . 'Failed to delete the Post!'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid Post ID!'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method!'];
}

echo json_encode($response); // Ensure JSON response is always sent
exit;

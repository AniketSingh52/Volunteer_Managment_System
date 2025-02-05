<?php
include("../../../config/connect.php");

// Ensure the content type is plain text
header('Content-Type: text/plain');

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    // Query to check if the email exists
    $sql = "SELECT * FROM `user` WHERE `email` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "exists"; // email already exists
    } else {
        echo "available"; // email is available
    }
}
elseif(isset($_POST['username'])){
    $username= $_POST['username'];
    // Query to check if the email exists
    $sql = "SELECT * FROM `user` WHERE `user_name` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "exists"; // email already exists
    } else {
        echo "available"; // email is available
    }

}else{
    echo "error"; // error in email
}
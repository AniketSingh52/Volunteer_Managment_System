<?php
include("../../../config/connect.php"); // Connection to the database

header('Content-Type: application/json');
ob_clean(); // Cle // Return JSON response
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 1);
ini_set('error_log', 'error_log.txt');
// session_start();
// $user_id = $_SESSION['user_id'];
// //echo "console.log(" . $Staff_id . ")";

// if (!$user_id) {
//     // echo "<script>alert('User not logged in.'); window.location.href='login_in.php';</script>";
//     // exit;
//     // echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
//     exit;
// }


//error_reporting(0); isset($_FILES['poster'])
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        !empty($_POST['postid']) && !empty($_POST['Description']) && !empty($_POST['post_poster'])
    ) {

        $message = "";
        $file_destination = $_POST['post_poster'];
        //File Upload
        if (isset($_FILES['poster'])) {

            $file_to_delete = $_POST['post_poster'];
            if (file_exists($file_to_delete)) {
                //unlink($file_to_delete);
                $message = $message . " Image deleted successfully! \n";
            } else {
                $message = $message . " File not found! \n";
            }

            // File information
            //  print_r($_FILES['poster']);
            $file_tmp_path = $_FILES['poster']['tmp_name'];
            $file_name = $_FILES['poster']['name'];
            $file_size = $_FILES['poster']['size'];
            $file_type = $_FILES['poster']['type'];
            $file_error = $_FILES['poster']['error'];

            // Validate file
            // $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 10 * 1024 * 1024; // 10MB

            $fileExt = explode('.', $file_name);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array('jpg', 'jpeg', 'png');

            if (in_array($fileActualExt, $allowed)) {
                if ($file_error === 0) {
                    if ($file_size <= $max_size) {
                        $file_name_new = uniqid('', true) . "." . $fileActualExt;
                        $file_destination = '../uploads/' . $file_name_new;
                        if (move_uploaded_file($file_tmp_path, $file_destination)) {
                            $message = $message . "file uploaded successfully ";
                            //echo "file uploaded successfully";
                        } else {
                            $message = $message . "file not uploaded ";
                            //echo "file not uploaded";
                        }
                    } else {
                        $message = $message . "File size too large (max 10MB) ";
                        // echo "File size too large (max 10MB)";
                    }
                } else {
                    $message = $message . "there was an error uploading your image ";
                    //echo "there was an error uploading your image";
                }
            } else {
                $message = $message . "Invalid file type ";
                //die("Invalid file type");
            }
        }


        $post_id = $_POST['postid'];
        $description = $_POST['Description'];


        //  echo "
        // <script>
        // alert('$name $application_date $department $from_date $to_date $reason');
        // </script>
        // ";



        $stmt = $conn->prepare("UPDATE `pictures` 
    SET `picture_url` = ?, 
        `caption` = ?
    WHERE `picture_id` = ?");

        $stmt->bind_param(
            "ssi", // "i" for integer event_id
            $file_destination,
            $description,
            $post_id // Condition for updating the correct record
        );

        //Insert the event
        if ($stmt->execute()) {

            //echo "<script>alert('Duty Leave Applied Successfully!');</script>";
            //echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=APPLY_DL.php">';
            echo json_encode(['status' => 'success', 'message' => trim($message . 'Post Edited Successfully!')]);
            exit;
        } else {
            //echo "<script>alert('ERROR!!');</script>";
            echo json_encode(['status' => 'error', 'message' => trim($message . ' Failed To Edit The Post!!!')]);
        }
    } else {
        //echo"hbii";
    }
}

<?php
include("../../../config/connect.php"); // Connection to the database

header('Content-Type: application/json');


date_default_timezone_set("Asia/Kolkata");


ob_clean(); // Cle // Return JSON response
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');




//error_reporting(0); isset($_FILES['poster'])
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        !empty($_POST['Description'])
        && !empty($_POST['userid'])
    ) {

        $message = "";
        //File Upload
        if (isset($_FILES['poster'])) {
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
       
        $user_id = $_POST['userid'];
        $Description = $_POST['Description'];
        $status = "scheduled";
        $created_by = $user_id;
        $date= date("Y-m-d H:i:s");



            $stmt = $conn->prepare("INSERT INTO `pictures` ( `picture_url`, `caption`, `upload_date`, `user_id`,likes) 
         VALUES (?,?,?,?,0)");
            $stmt->bind_param(
                "sssi",
                $file_destination,
                $Description,
                $date,
                $user_id
            );

            //Insert the event
            if ($stmt->execute()) {
                $message=$message."Post Added Successfull\n";

            // if (isset($_POST['cause'])) {
            //     $causes= $_POST['cause'];
            //     // $event_id = $conn->real_escape_string($_POST['event_id']); // Prevent SQL injection
            //     // Using Organizer_id and Date_of_creation and Title To insert event skill and causes
            //     $checkSql = "SELECT picture_id FROM `pictures` WHERE picture_url  = '$file_destination' AND caption = '$Description' AND `upload_date`='$date' AND user_id = '$user_id'";
            //     $checkResult = $conn->query($checkSql);
            //     if ($checkResult->num_rows > 0) {
            //         $row = $checkResult->fetch_assoc();
            //         $picture_id = $row['picture_id'];


            //         //Causes Insertion as per the user_id
            //         foreach ($causes as $c) {

            //             $stmt = $conn->prepare("INSERT INTO `event_images` (`event_id`,`image_id`) 
            //                              VALUES (?,?)");
            //             $stmt->bind_param(
            //                 "ii",
            //                 $event_id,
            //                 $c
            //             );

            //             if ($stmt->execute()) {
            //                 $message = $message . "cause Inserested! \n";
            //                 //echo "cause Inserested! \n";


            //             } else {
            //                 $message = $message . "cause Failed! \n";
            //                 //echo "Error: " . $stmt->error;
            //                 break;
            //             }
            //         }



            //     }else{
            //         $message = $message . "Failed TO fetch the post\n";

            //     }

            // }

                //echo "<script>alert('Duty Leave Applied Successfully!');</script>";
                //echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=APPLY_DL.php">';
            } else {
            $message = $message . "Failed to add Post !!\n";
                //echo "<script>alert('ERROR!!');</script>"; 
            }
        echo json_encode(['status' => 'success', 'message' => $message]);
        
    }else{
    echo json_encode(['status' => 'error', 'message' => trim($message . ' Failed To Create The Post & invalis server method!!!')]);
    }
}

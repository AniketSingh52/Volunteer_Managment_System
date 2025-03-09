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
//     echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
//     exit;
// }


//error_reporting(0); isset($_FILES['poster'])
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        !empty($_POST['fullName']) && !empty($_POST['address'])
        && !empty($_POST['dob']) 
        && !empty($_POST['phone'])
        && !empty($_POST['causes'])
        && !empty($_POST['user_poster'])
        && !empty($_POST['user_id']) && !empty($_POST['type_user'])
    ) {

        $message = "";
        $file_destination = $_POST['user_poster'];
        //File Upload
        if (isset($_FILES['poster'])) {

            $file_to_delete = $_POST['user_poster'];
            if (file_exists($file_to_delete)) {
                unlink($file_to_delete);
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


        $user_id = $_POST['user_id'];
        $user_type= $_POST['type_user'];
        $contact= $_POST['phone'];
        $dob= $_POST['dob'];
        $address= $_POST['address'];
        $name= $_POST['fullName'];



        // if($user_type== "Volunteer"){
        //     $skill = $_POST['skill'];
        //     $gender= $_POST['gender'];
        // }else{
        //     $organ_type=$_POST['organ_type'];
        // }


        $causes = $_POST['causes'];
       
        $stmt = $conn->prepare("UPDATE `user` 
    SET `name` = ?, 
        `contact` = ?, 
        `address` = ?, 
         `DOB/DOE` = ?,
          `profile_picture` = ?
    WHERE `user_id` = ?");

        $stmt->bind_param(
            "sssssi", // "i" for integer event_id
            $name,
            $contact,
            $address,
            $dob,
            $file_destination,
            $user_id // Condition for updating the correct record
        );

        //Insert the event
        if ($stmt->execute()) {
            $message = $message . "User Updated! \n";



            if ($user_type == "Volunteer") {
                $skill = $_POST['skill'];

                // Using Organizer_id and Date_of_creation and Title To insert event skill and causes
                $checkSql = "DELETE FROM `volunteer_skill` WHERE user_id  = '$user_id'";
                if ($conn->query($checkSql)) {
                    $message = $message . "Skills Deleted! \n";
                    //echo "Skills Deleted! \n";
                    foreach ($skill as $s) {
                        $stmt = $conn->prepare("INSERT INTO `volunteer_skill` (`user_id`,`skill_id`) 
                                         VALUES (?,?)");
                        $stmt->bind_param(
                            "ii",
                            $user_id,
                            $s
                        );

                        if ($stmt->execute()) {
                            $message = $message . "Skill Inserested!\n";
                            //echo "Skill Inserested! \n";

                        } else {
                            //echo "Error: " . $stmt->error;
                            $message = $message . "skill Failed \n";
                            
                        }
                    }
                } else {
                    $message = $message . "Skills Not Deleted! \n";
                }


               
            } else {
                $organ_type = $_POST['organ_type'];

                $checkSql = "DELETE FROM `organization_belongs_type` WHERE user_id  = '$user_id'";
                if ($conn->query($checkSql)) {

                    $message = $message . "Organization Type Deleted! \n";

                    //organization type as per the user_id
                    
                    $stmt = $conn->prepare("INSERT INTO `organization_belongs_type` (`user_id`,`type_id`) 
                                        VALUES (?,?)");
                    $stmt->bind_param(
                        "ii",
                        $user_id,
                        $organ_type
                    );

                    if ($stmt->execute()) {
                        $message = $message . "Org Type Inserested! \n";
                        //echo "cause Inserested! \n";


                    } else {
                        $message = $message . "Org Type Failed! \n";
                        //echo "Error: " . $stmt->error;
                        
                    }
                    
                } else {
                    $message = $message . "Org Type Not Deleted! \n";
                }

            }

        

            // Using Organizer_id and Date_of_creation and Title To insert event skill and causes
            $checkSql = "DELETE FROM `user_workfor_causes` WHERE user_id  = '$user_id'";
            if ($conn->query($checkSql)) {

                $message = $message . "causes Deleted! \n";

                //Causes Insertion as per the user_id
                foreach ($causes as $c) {

                    $stmt = $conn->prepare("INSERT INTO `user_workfor_causes` (`user_id`,`cause_id`) 
                                         VALUES (?,?)");
                    $stmt->bind_param(
                        "ii",
                        $user_id,
                        $c
                    );

                    if ($stmt->execute()) {
                        $message = $message . "cause Inserested! \n";
                        //echo "cause Inserested! \n";


                    } else {
                        $message = $message . "cause Failed! \n";
                        //echo "Error: " . $stmt->error;
                        break;
                    }
                }
            } else {
                $message = $message . "causes Not Deleted! \n";
            }


            //echo "<script>alert('Duty Leave Applied Successfully!');</script>";
            //echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=APPLY_DL.php">';
            echo json_encode(['status' => 'success', 'message' => trim($message . ' Profile Edited Successfully!')]);
            exit;
        } else {
            //echo "<script>alert('ERROR!!');</script>";
            echo json_encode(['status' => 'error', 'message' => trim($message . ' Failed To Edit The Profile!!!')]);
        }
    } else {
        //echo"hbii";
        echo json_encode(['status' => 'error', 'message' => trim($message . ' Failed To Edit The Profile!!!')]);
    }
}

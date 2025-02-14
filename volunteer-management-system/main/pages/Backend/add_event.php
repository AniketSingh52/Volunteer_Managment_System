<?php
include("../../../config/connect.php"); // Connection to the database

header('Content-Type: application/json');
ob_clean(); // Cle // Return JSON response
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');
session_start();
$user_id= $_SESSION['user_id'];
//echo "console.log(" . $Staff_id . ")";

if (!$user_id) {
    // echo "<script>alert('User not logged in.'); window.location.href='login_in.php';</script>";
    // exit;
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}


//error_reporting(0); isset($_FILES['poster'])
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['poster']) && !empty($_POST['date_of_creation']) 
     && !empty($_POST['title']) && !empty($_POST['from_date'])
     && !empty($_POST['to_date']) && !empty($_POST['from_time'])
     && !empty($_POST['to_time']) && !empty($_POST['max_application'])
     && !empty($_POST['location']) && !empty($_POST['volunteer_need'])
     && !empty($_POST['cause']) && !empty($_POST['skill'])
     && !empty($_POST['Description'])) {

        $message="";
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
                            $message=$message. "file uploaded successfully ";
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


        $skill = $_POST['skill'];
        $causes = $_POST['cause'];
        $date_of_creation = $_POST['date_of_creation'];
        $title = $_POST['title'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $from_time = $_POST['from_time'];
        $to_time = $_POST['to_time'];
        $max_application = $_POST['max_application'];
        $location = $_POST['location'];
        $volunteer_need = $_POST['volunteer_need'];
        $Description = $_POST['Description'];
        $status = "scheduled";
        $created_by = $user_id;

        //  echo "
        // <script>
        // alert('$name $application_date $department $from_date $to_date $reason');
        // </script>
        // ";
     

            // Check for duplicate entry
            $checkSql = "SELECT * FROM `events` WHERE organization_id  = '$user_id' AND event_name = '$title' AND `date_of_creation`='$date_of_creation' AND from_date = '$from_date' AND to_date = '$to_date' AND location = '$location'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Duplicate found
                //echo "<script>alert('Duplicate Entry: Duty Leave has already been applied for these dates!');</script>";
                echo json_encode(['status' => 'error', 'message' => 'Duplicate Entry: Event Already Exists!']);
            
            } else {
            // No duplicate, proceed with insertion


            $stmt = $conn->prepare("INSERT INTO `events` ( `event_name`, `description`, `from_date`, `to_date`, `from_time`, `to_time`, `location`, `volunteers_needed`, `maximum_application`, `status`, `organization_id`, `date_of_creation`, `poster`) 
         VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param(
                "sssssssssssss",
                $title,
                $Description,
                $from_date,
                $to_date,
                $from_time,
                $to_time,
                $location,
                $volunteer_need,
                $max_application,
                $status,
                $created_by,
                $date_of_creation,
                $file_destination
            );

            //Insert the event
            if ($stmt->execute()) {

                // Using Organizer_id and Date_of_creation and Title To insert event skill and causes
                $checkSql = "SELECT * FROM `events` WHERE organization_id  = '$user_id' AND event_name = '$title' AND `date_of_creation`='$date_of_creation' AND from_date = '$from_date' AND to_date = '$to_date' AND location = '$location'";
                $checkResult = $conn->query($checkSql);
                if ($checkResult->num_rows > 0) {
                    $row = $checkResult->fetch_assoc();
                    $event_id = $row['event_id'];
                    // echo $user_id;

                    //Skill Insertion as per the user_id
                    foreach ($skill as $s) {

                        $stmt = $conn->prepare("INSERT INTO `event_req_skill` (`event_id`,`skill_id`) 
                                         VALUES (?,?)");
                        $stmt->bind_param(
                            "ii",
                            $event_id,
                            $s
                        );

                        if ($stmt->execute()) {
                            $message = $message . "Skill Inserested!\n";
                            //echo "Skill Inserested! \n";

                        } else {
                            //echo "Error: " . $stmt->error;
                            $message = $message . "skill Failed \n";
                            break;
                        }
                    }
                    //Causes Insertion as per the user_id
                    foreach ($causes as $c) {

                        $stmt = $conn->prepare("INSERT INTO `event_has_causes` (`event_id`,`cause_id`) 
                                         VALUES (?,?)");
                        $stmt->bind_param(
                            "ii",
                            $event_id,
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
                }

                //echo "<script>alert('Duty Leave Applied Successfully!');</script>";
                //echo '<META HTTP-EQUIV="Refresh" Content="0.5;URL=APPLY_DL.php">';
                echo json_encode(['status' => 'success', 'message' => trim($message . ' Event Created Successfully!')]);
                exit;
            } else {
                //echo "<script>alert('ERROR!!');</script>";
                echo json_encode(['status' => 'error', 'message' => trim($message . ' Failed To Create The Event!!!')]);
            }


           

              
            }
        
    }
}

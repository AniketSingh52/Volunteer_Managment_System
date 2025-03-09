<?php include("../../../../config/connect.php"); ?>
<?php
ob_clean(); // Cle // Return JSON response
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');
header('Content-Type: application/json');


date_default_timezone_set("Asia/Kolkata");



//error_reporting(0); isset($_FILES['poster'])
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        !empty($_POST['name'])
        && !empty($_POST['email'])
        && !empty($_POST['password'])
        && !empty($_POST['role'])
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

       $name=$_POST['name'];
       $email=$_POST['email'];
       $password=$_POST['password'];
       $role= $_POST['role'];
        $date = date("Y-m-d H:i:s");



        $stmt = $conn->prepare("INSERT INTO `administration` ( `name`, `email`, `role`, `password`,`profile_picture`,`date_of_registration`,`status`) 
         VALUES (?,?,?,?,?,?,'active')");
        $stmt->bind_param(
            "ssssss",
            $name,
            $email,
            $role,
            $password,
            $file_destination,
            $date
        );

        //Insert the event
        if ($stmt->execute()) {
            $message = $message . "Admin Added Successfull\n";

        } else {
            $message = $message . "Failed to add Admin !!\n";
            //echo "<script>alert('ERROR!!');</script>"; 
        }
        echo json_encode(['status' => 'success', 'message' => $message]);
    } else {
        echo json_encode(['status' => 'error', 'message' => trim($message . ' Failed To add admin & invalid server method!!!')]);
    }
}


?>

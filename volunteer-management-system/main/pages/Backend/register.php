	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

	<?php
    //error_reporting(0);
    include("../../../config/connect.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (
            isset($_POST['name']) && !empty($_POST['DOB'])
            && !empty($_POST['Contact']) && !empty($_POST['gender'])
            && !empty($_POST['occupation']) && !empty($_POST['address'])
            && !empty($_POST['password']) && !empty($_POST['username'])
            && !empty($_POST['skill']) && !empty($_POST['cause'])
            && !empty($_POST['email']) && isset($_FILES['profile'])
        ) {


            //File Upload
            if (isset($_FILES['profile'])) {
                // File information
                // print_r($_FILES['profile']);
                $file_tmp_path = $_FILES['profile']['tmp_name'];
                $file_name = $_FILES['profile']['name'];
                $file_size = $_FILES['profile']['size'];
                $file_type = $_FILES['profile']['type'];
                $file_error = $_FILES['profile']['error'];

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
                                echo "file uploaded successfully";
                            } else {
                                // echo "file not uploaded";
                            }
                        } else {
                            // echo "File size too large (max 10MB)";
                        }
                    } else {
                        // echo "there was an error uploading your image";
                    }
                } else {
                    die("Invalid file type");
                }
            }
        


            // Get other form data
            $name = $_POST['name'];
            $dob = $_POST['DOB'];
            $contact = $_POST['Contact'];
            $gender = $_POST['gender'];
            $occupation = $_POST['occupation'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $username = $_POST['username'];
            $skill = $_POST['skill'];
            $causes = $_POST['cause'];
            $registration_date = date('Y-m-d');
            $type = 'V';


            $flag = "";   // For ERROR Checking
            //print_r($skill);
            // echo "
            // <script>
            // alert('$ok');
            // </script>
            // ";


            //INSERT INTO `user` (`name`, `email`, `contact`, `gender`, `occupation`, `user_name`, `password`, `address`, `user_type`, `DOB/DOE`, `registration_date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?);

            // Insert into database 
            $stmt = $conn->prepare("INSERT INTO `user` (`name`, `email`, `contact`, `gender`, `occupation`, `user_name`, `password`, `address`, `user_type`, `DOB/DOE`, `registration_date`, `profile_picture`) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param(
                "ssisssssssss",
                $name,
                $email,
                $contact,
                $gender,
                $occupation,
                $username,
                $password,
                $address,
                $type,
                $dob,
                $registration_date,
                $file_destination
            );


            //Registration
            if ($stmt->execute()) {
                //echo "Registration successful!\n";
                $flag = $flag . "_RS";
            } else {
                //echo "Error: " . $stmt->error;
                $flag = $flag . "_RF";
            }

            // Using Email and Username To insert skill and causes
            $checkSql = "SELECT * FROM user WHERE  name = '$name' AND email = '$email' AND user_name ='$username' ";
            $checkResult = $conn->query($checkSql);
            if ($checkResult->num_rows > 0) {
                $row = $checkResult->fetch_assoc();
                $user_id = $row['user_id'];
                $S1 = 0;
                $C1 = 0;
                // echo $user_id;

                //Skill Insertion as per the user_id
                foreach ($skill as $s) {

                    $stmt = $conn->prepare("INSERT INTO `volunteer_skill` (`user_id`,`skill_id`) 
                                         VALUES (?,?)");
                    $stmt->bind_param(
                        "ii",
                        $user_id,
                        $s
                    );

                    if ($stmt->execute()) {
                        //echo "Skill Inserested! \n";
                        if ($S1 == 0) {
                            $flag = $flag . "_SS";
                            $S1 = 1;
                        }
                    } else {
                        //echo "Error: " . $stmt->error;
                        $flag = $flag . "_SF";
                        break;
                    }
                }
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
                        //echo "cause Inserested! \n";

                        if ($C1 == 0) {
                            $flag = $flag . "_CS";
                            $C1 = 1;
                        }
                    } else {
                        //echo "Error: " . $stmt->error;
                        $flag = $flag . "_CF";
                        break;
                    }
                }
            }

            $verify = explode("_", $flag);

            // Removing empty elements (since the first character is '_', the first element will be empty)
            $verify = array_filter($verify);

            // Reindex the array (optional)
            $verify = array_values($verify);

            // print_r($verify);
            $failed_values = ["RF", "SF", "CF"];

            if ($flag === "_RS_SS_CS") {
                echo "
             <script>
             alert('Registration Successful !');
             </script>
                ";

                //header("refresh:0.5; url=../pages/changepass.php");
                echo '<META HTTP-EQUIV="Refresh" Content="0.5; URL=../login_in.php">';


                // echo '<div class="alert alert-success alert-dismissible fade-show">
                //      <a href="../login_in.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                //      <strong>Resigtration Sucessfull!</strong>An Verification Link is sent on you registered Email.
                //      </div>';
            }    // if any of he above 3 process fails.
            elseif (!empty(array_intersect($failed_values, $verify))) {
                echo "
                   <script>
                     alert('Registration Failed!!!!! Please Retry!');
                   </script>
                  ";

                //header("refresh:0.5; url=../pages/changepass.php");
                echo '<META HTTP-EQUIV="Refresh" Content="0.5; URL=../signup.php">';

                echo '<div class="alert alert-warning alert-dismissible fade-show">
		             <a href="../signup.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		              <strong>Registration Failed!</strong> Please Retry Again !!.
	                 </div>';
            }


        }       //Organization Registration Code
        elseif (
            isset($_POST['name']) && !empty($_POST['DOE'])
            && !empty($_POST['Contact']) && !empty($_POST['org_type'])
            && !empty($_POST['address'])  && !empty($_POST['password']) 
            && !empty($_POST['username']) && !empty($_POST['cause'])
            && !empty($_POST['email']) && isset($_FILES['profile'])
        ) {


            //File Upload
            if (isset($_FILES['profile'])) {
                // File information
                print_r($_FILES['profile']);
                $file_tmp_path = $_FILES['profile']['tmp_name'];
                $file_name = $_FILES['profile']['name'];
                $file_size = $_FILES['profile']['size'];
                $file_type = $_FILES['profile']['type'];
                $file_error = $_FILES['profile']['error'];

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
                                echo "file uploaded successfully";
                            } else {
                                echo "file not uploaded";
                            }
                        } else {
                            echo "File size too large (max 10MB)";
                        }
                    } else {
                        echo "there was an error uploading your image";
                    }
                } else {
                    die("Invalid file type");
                }
            }



            // Get other form data
            $name = $_POST['name'];
            $dob = $_POST['DOE'];
            $contact = $_POST['Contact'];
            echo"contact: ".$contact;
            $org_type = $_POST['org_type'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $username = $_POST['username'];
            $causes = $_POST['cause'];
            $registration_date = date('Y-m-d');
            $type = 'O';
            $gender="N";
            $occupation=NULL;


            $flag = "";   // For ERROR Checking
            //print_r($skill);
            // echo "
            // <script>
            // alert('$ok');
            // </script>
            // ";


            //INSERT INTO `user` (`name`, `email`, `contact`, `gender`, `occupation`, `user_name`, `password`, `address`, `user_type`, `DOB/DOE`, `registration_date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?);

            // Insert into database 
            $stmt = $conn->prepare("INSERT INTO `user` (`name`, `email`, `contact`, `gender`, `occupation`, `user_name`, `password`, `address`, `user_type`, `DOB/DOE`, `registration_date`, `profile_picture`) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param(
                "ssisssssssss",
                $name,
                $email,
                $contact,
                $gender,
                $occupation,
                $username,
                $password,
                $address,
                $type,
                $dob,
                $registration_date,
                $file_destination
            );


            //Registration
            if ($stmt->execute()) {
                //echo "Registration successful!\n";
                $flag = $flag . "_RS";
            } else {
                //echo "Error: " . $stmt->error;
                $flag = $flag . "_RF";
            }

            // Using Email and Username To insert skill and causes
            $checkSql = "SELECT * FROM user WHERE  name = '$name' AND email = '$email' AND user_name ='$username' ";
            $checkResult = $conn->query($checkSql);
            if ($checkResult->num_rows > 0) {
                $row = $checkResult->fetch_assoc();
                $user_id = $row['user_id'];
                $O1 = 0;
                $C1 = 0;
                // echo $user_id;

                //Organization Type Insertion as per the user_id

                    $stmt = $conn->prepare("INSERT INTO `organization_belongs_type` (`user_id`,`type_id`) 
                                         VALUES (?,?)");
                    $stmt->bind_param(
                        "ii",
                        $user_id,
                        $org_type
                    );

                    if ($stmt->execute()) {
                    //echo "Organization Type inserted! \n";
                       $flag = $flag . "_OTS";
                    } else {
                        //echo "Error: " . $stmt->error;
                        $flag = $flag . "_OTF";
                        
                    }
                
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
                        //echo "cause Inserested! \n";

                        if ($C1 == 0) {
                            $flag = $flag . "_CS";
                            $C1 = 1;
                        }
                    } else {
                        //echo "Error: " . $stmt->error;
                        $flag = $flag . "_CF";
                        break;
                    }
                }
            }

            $verify = explode("_", $flag);

            // Removing empty elements (since the first character is '_', the first element will be empty)
            $verify = array_filter($verify);

            // Reindex the array (optional)
            $verify = array_values($verify);

            // print_r($verify);
            $failed_values = ["RF", "OTF", "CF"];

            if ($flag === "_RS_OTS_CS") {
                echo "
             <script>
             alert('Registration Successful !');
             </script>
                ";

                //header("refresh:0.5; url=../pages/changepass.php");
                echo '<META HTTP-EQUIV="Refresh" Content="0.5; URL=../login_in.php">';


                echo '<div class="alert alert-success alert-dismissible fade-show">
                     <a href="../login_in.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                     <strong>Resigtration Sucessfull!</strong>An Verification Link is sent on you registered Email.
                     </div>';
            }    // if any of he above 3 process fails.
            elseif (!empty(array_intersect($failed_values, $verify))) {
                echo "
                   <script>
                     alert('Registration Failed!!!!! Please Retry!');
                   </script>
                  ";

                //header("refresh:0.5; url=../pages/changepass.php");
                echo '<META HTTP-EQUIV="Refresh" Content="0.5; URL=../signup.php">';

                echo '<div class="alert alert-warning alert-dismissible fade-show">
		             <a href="../signup.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		              <strong>Registration Failed!</strong> Please Retry Again !!.
	                 </div>';
            }
        }



    }



    ?>
<?php
session_start();

    //include('../../config/connect.php');
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require('../../library/Exception.php');
    require('../../library/PHPMailer.php');
    require('../../library/SMTP.php');


?>

<?php
// session_start();
include("../../config/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

//include('../../config/connect.php');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function


    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $otp = rand(1000, 9999);
        $_SESSION['OTP'] = $otp;
        $_SESSION['email'] = $email;

       

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'odhadam0@gmail.com';                     //SMTP username
            $mail->Password   = 'oyzcgfwumrbyuhct';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->SMTPDebug = 0; // Ensure this is set to 0
            //Recipients
            $mail->setFrom('odhadam0@gmail.com', 'OmkarDhadam');
            $mail->addAddress($email, 'Mail For Forget Password');     //Add a recipient


            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Mail for Forget Password';
            $mail->Body = '
<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: "Arial", sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f8f9fa;
      color: #4d4d4d;
    }
    .email-container {
      max-width: 600px;
      margin: 30px auto;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      border: 1px solid #ddd;
    }
    .email-header {
      background-color: #0056b3;
      color: #ffffff;
      padding: 20px;
      text-align: center;
    }
    .email-header h1 {
      margin: 0;
      font-size: 24px;
      font-weight: bold;
    }
    .email-body {
      padding: 20px;
      font-size: 16px;
      line-height: 1.6;
      color: #333333;
    }
    .email-body p {
      margin: 10px 0;
      color: #5a5a5a;
    }
    .otp-box {
      margin: 20px 0;
      padding: 15px;
      background-color: #e3f2fd;
      color: #007bff;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      border-radius: 5px;
      letter-spacing: 1.2px;
    }
    .email-footer {
      background-color: #f1f3f5;
      padding: 15px;
      text-align: center;
      font-size: 14px;
      color: #6c757d;
      border-top: 1px solid #ddd;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="email-header">
      <h1>Volunteer Management System</h1>
    </div>
    <div class="email-body">
      <p>Dear User,</p>
      <p>You have requested to reset your password on the <strong style="color: #0056b3;">Volunteer Management System</strong>. Please use the OTP below to complete the process:</p>
      <div class="otp-box">' . $otp . '</div>
      <p style="color: #6c757d;">If you did not make this request, please ignore this email. Your account remains secure.</p>
      <p>Best Regards,<br><strong style="color: #0056b3;">VolunteerHUB Team</strong></p>
    </div>
    <div class="email-footer">
      <p>&copy; ' . date("Y") . ' VolunteerHub | All Rights Reserved.</p>
    </div>
  </div>
</body>
</html>
';



            $mail->send();

            echo '<script>alert("Mail Sent Successfully.....");</script>';
            echo '<META HTTP-EQUIV="Refresh" Content="0.5; URL=verify.php">';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo '<script>alert("Email not EXISTS !!!");</script>';
    }
}

    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Management - Login</title>
    <?php include("../../library/library.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="min-h-screen bg-gradient-to-br from-purple-200 to-blue-200 py-6 px-4">
   

    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-block p-2 rounded-full bg-purple-100 mb-4">
                <div class="h-20 w-20 rounded-full shadow-md flex items-center justify-center overflow-hidden">
                    <img src="../assets/Screenshot 2025-02-05 215045.svg" class="profile-image2 w-full h-full object-cover" alt="Profile Image">
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Forgot Password</h1>
            <p class="mt-2 text-gray-600">Don't worry we have got you covered</p>
        </div>

        <!-- Form -->
        <form id="loginForm" class="bg-white rounded-xl shadow-lg p-8 space-y-3" method="POST" action="forgot.php">
            

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Enter Your Registerd Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition-all"
                    placeholder="john@example.com">
                <span class="error-message text-red-500 text-sm hidden"></span>
            </div>

            <!-- Password -->
          

         

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
               Generate OTP
            </button>

            <!-- Sign Up Link -->
            <div class="text-center text-sm">
                <span class="text-gray-600">Back to Login page ?</span>
                <a href="login_in.php" class="text-purple-600 hover:text-purple-500 font-medium ml-1">Sign-In</a>
            </div>
        </form>


    </div>

    <script>
        $(document).ready(function() {
            // Password Toggle
            $('#togglePassword').on('click', function() {
                const passwordInput = $('#password');
                const showIcons = $('.show-password');
                const hideIcon = $('.hide-password');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    showIcons.removeClass('hidden');
                    hideIcon.addClass('hidden');
                } else {
                    passwordInput.attr('type', 'password');
                    showIcons.addClass('hidden');
                    hideIcon.removeClass('hidden');
                }
            });



            // Clear error styling on input
            $('input').on('input', function() {
                $(this).removeClass('border-red-500');
                $(this).next('.error-message').addClass('hidden').text('');
            });
        });
    </script>
</body>

</html>



<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "volunteer";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?>

<?php
/*
define("DB_HOST", "localhost");
define("DB_PASSWORD", "");
define("DB_USERNAME", "root");
define("DB_NAME", "volunteer_management_system");

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()) {
    //echo("not connected");
} else {
    // echo("Successfull !!");
}
*/
?>

<?php
$host = "localhost";
$username = "root";
$password = "";  // Empty string if no password is set
$database = "lawfirm";

$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

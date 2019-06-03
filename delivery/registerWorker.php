
<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "doctor";

$conn = new mysqli($servername,$username,$password,$dbname);

if(isset($_POST['w_username'])){            
    $w_username = $_POST['w_username'];
    $w_password  = $_POST['w_password'];
    $w_email = $_POST['w_email'];

    $sql = "INSERT into workers (w_username,w_password,w_email) values ('$w_username','$w_password','$w_email')";
    $result = mysqli_query($conn,$sql);
    }
    
?>
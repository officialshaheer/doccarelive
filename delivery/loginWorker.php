<?php 

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "doctor";

$conn = new mysqli($servername, $username, $password, $dbname);

if(isset($_POST['w_username'])){

    $w_username = $_POST['w_username'];
    $w_password = $_POST['w_password'];
    
    $sql   = "SELECT * from workers where w_username = '$w_username' and w_password = '$w_password' ";
    if ($conn->query($sql)->num_rows) {
        session_start();
        $_SESSION['w_username'] = $w_username ;
        header('Location: work.php');
    }
    else {
        // echo "User Not Found!";
        $name = 'Error Log In';
        // echo $name;    
        }
}
?>
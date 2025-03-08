<?php
include('../assets/config/dbconn.php');

session_start();
$user_id = $_SESSION['user_id'];

$sql = "UPDATE notifications SET status = 'read' WHERE user_id = '$user_id'";
mysqli_query($conn, $sql);
?>

<?php
include('../assets/config/dbconn.php');

$user_id = $_POST['user_id']; // The ID of the user receiving the notification
$message = "Your document has been submitted successfully.";

$sql = "INSERT INTO notifications (user_id, message, status) VALUES ('$user_id', '$message', 'unread')";
if (mysqli_query($conn, $sql)) {
    echo "Notification inserted";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

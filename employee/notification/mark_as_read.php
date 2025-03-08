<?php
session_start();
include('../assets/config/dbconn.php');

if (!isset($_SESSION['user_id']) || !isset($_POST['notification_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$notification_id = intval($_POST['notification_id']);
$query = "UPDATE notifications SET status = 'read' WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $notification_id);
if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update"]);
}
?>

<?php
include '../assets/config/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = $_POST['id'];
    $status = $_POST['status'];

    // Update the appointment status
    $query = "UPDATE appointments SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database error.']);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "si", $status, $appointmentId);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Appointment status updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update appointment status.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
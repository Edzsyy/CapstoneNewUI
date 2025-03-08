<?php
include '../assets/config/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = $_POST['id'];

    // Delete the appointment
    $query = "DELETE FROM appointments WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database error.']);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $appointmentId);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Appointment deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete appointment.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
<?php
include '../assets/config/dbconn.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Log received data for debugging
    error_log('Received POST data: ' . print_r($_POST, true));

    // Validate required fields
    if (
        !isset($_POST['serviceType']) ||
        !isset($_POST['appointmentDate']) ||
        !isset($_POST['timeSlot']) ||
        !isset($_POST['duration']) ||
        !isset($_POST['notes'])
    ) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
        exit;
    }

    $serviceType = $_POST['serviceType'];
    $appointmentDate = $_POST['appointmentDate'];
    $timeSlot = $_POST['timeSlot'];
    $duration = intval($_POST['duration']);
    $notes = $_POST['notes'];

    // Debugging: Log the data being processed
    error_log("Processing data: serviceType=$serviceType, appointmentDate=$appointmentDate, timeSlot=$timeSlot, duration=$duration, notes=$notes");

    // Insert the appointment into the database
    $query = "INSERT INTO appointments (service_type, appointment_date, time_slot, duration, notes) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        error_log('Error preparing statement: ' . mysqli_error($conn));
        echo json_encode(['status' => 'error', 'message' => 'Database error.']);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "sssis", $serviceType, $appointmentDate, $timeSlot, $duration, $notes);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Appointment booked successfully!']);
    } else {
        error_log('Error inserting appointment: ' . mysqli_error($conn));
        echo json_encode(['status' => 'error', 'message' => 'Failed to book appointment.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
<?php
include('../assets/config/dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['date']) && isset($_GET['duration'])) {
    $selectedDate = $_GET['date'];
    $duration = intval($_GET['duration']);

    // Define working hours
    $workingHours = [
        'start' => '09:00:00',
        'end' => '17:00:00',
        'interval' => $duration . ' minutes' // Dynamic interval based on duration
    ];

    // Fetch booked time slots for the selected date
    $query = "SELECT time_slot FROM appointments WHERE appointment_date = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $selectedDate);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $bookedSlots = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $bookedSlots[] = $row['time_slot'];
    }

    // Generate available time slots
    $availableSlots = [];
    $currentTime = strtotime($workingHours['start']);
    $endTime = strtotime($workingHours['end']);

    while ($currentTime + ($duration * 60) <= $endTime) {
        $slot = date('H:i:s', $currentTime);
        if (!in_array($slot, $bookedSlots)) {
            $availableSlots[] = $slot;
        }
        $currentTime = strtotime('+' . $workingHours['interval'], $currentTime);
    }

    echo json_encode($availableSlots);
}
?>
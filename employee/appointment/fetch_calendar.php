<?php
include '../assets/config/dbconn.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['month'])) {
    $selectedMonth = $_GET['month'];

    // Debugging: Log the selected month
    error_log("Selected Month: $selectedMonth");

    // Fetch all appointments for the selected month
    $query = "SELECT appointment_date, time_slot FROM appointments WHERE DATE_FORMAT(appointment_date, '%Y-%m') = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        error_log("Error preparing statement: " . mysqli_error($conn));
        echo "Error preparing statement. Check server logs.";
        exit;
    }

    mysqli_stmt_bind_param($stmt, "s", $selectedMonth);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        error_log("Error fetching appointments: " . mysqli_error($conn));
        echo "Error fetching appointments. Check server logs.";
        exit;
    }

    $bookedSlots = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $bookedSlots[$row['appointment_date']][] = $row['time_slot'];
    }

    // Debugging: Log booked slots
    error_log("Booked Slots: " . print_r($bookedSlots, true));

    // Generate the calendar
    $firstDayOfMonth = date('Y-m-01', strtotime($selectedMonth));
    $daysInMonth = date('t', strtotime($firstDayOfMonth));
    $firstDayOfWeek = date('N', strtotime($firstDayOfMonth));

    echo '<tr>';
    // Fill empty cells for the first week
    for ($i = 1; $i < $firstDayOfWeek; $i++) {
        echo '<td></td>';
    }

    // Fill the calendar with dates
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = date('Y-m-d', strtotime("$firstDayOfMonth + " . ($day - 1) . " days"));
        $isBooked = isset($bookedSlots[$date]) ? 'bg-danger text-white' : '';
        echo "<td class='$isBooked'><a href='#' class='book-appointment' data-date='$date'>$day</a></td>";

        // Start a new row at the end of the week
        if (($firstDayOfWeek + $day - 1) % 7 == 0) {
            echo '</tr><tr>';
        }
    }

    // Fill empty cells for the last week
    while (($firstDayOfWeek + $daysInMonth - 1) % 7 != 0) {
        echo '<td></td>';
        $daysInMonth++;
    }
    echo '</tr>';
} else {
    echo "Invalid request. Month parameter is missing.";
}
?>
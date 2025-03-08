<?php
include '../employee/assets/config/dbconn.php';
include '../employee/assets/inc/header.php';
?>

<!-- Include jQuery & Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Page Content -->
<div class="table-container-form">
    <div class="table-container table-form">
        <div class="table-body">
            <h4>Manage Appointments</h4>

            <!-- Search Bar -->
            <div class="mb-3">
                <input type="text" id="searchAppointments" class="form-control" placeholder="Search by user, service type, or status...">
            </div>

            <!-- Appointments Table -->
            <table class="table table-bordered" id="appointmentsTable">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Service Type</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Attendance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch all appointments
                    $query = "SELECT * FROM appointments";
                    $result = mysqli_query($conn, $query);

                    // Group appointments by date
                    $appointmentsByDate = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $date = $row['appointment_date'];
                        if (!isset($appointmentsByDate[$date])) {
                            $appointmentsByDate[$date] = [];
                        }
                        $appointmentsByDate[$date][] = $row;
                    }

                    // Display appointments
                    foreach ($appointmentsByDate as $date => $appointments) {
                        $totalAppointments = count($appointments);
                        echo "<tr>
                                <td colspan='6'><strong>Date: {$date} (Total Appointments: {$totalAppointments})</strong></td>
                              </tr>";

                        foreach ($appointments as $row) {
                            echo "<tr data-id='{$row['id']}'>
                                    <td>{$row['user_id']}</td> <!-- Replace with actual user name if available -->
                                    <td>{$row['service_type']}</td>
                                    <td>{$row['appointment_date']} {$row['time_slot']}</td>
                                    <td class='status'>{$row['status']}</td>
                                    <td>
                                        <select class='form-control attendance' onchange='updateAttendance({$row['id']}, this.value)'>
                                            <option value='pending' " . ($row['attendance'] === 'pending' ? 'selected' : '') . ">Pending</option>
                                            <option value='attended' " . ($row['attendance'] === 'attended' ? 'selected' : '') . ">Attended</option>
                                            <option value='not_attended' " . ($row['attendance'] === 'not_attended' ? 'selected' : '') . ">Not Attended</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class='dropdown'>
                                            <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton{$row['id']}' data-bs-toggle='dropdown' aria-expanded='false'>
                                                Actions
                                            </button>
                                            <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton{$row['id']}'>
                                                <li><a class='dropdown-item' href='#' data-action='approve' data-id='{$row['id']}'>Approve</a></li>
                                                <li><a class='dropdown-item' href='#' data-action='pending' data-id='{$row['id']}'>Pending</a></li>
                                                <li><a class='dropdown-item' href='#' data-action='reject' data-id='{$row['id']}'>Reject</a></li>
                                                <li><a class='dropdown-item' href='#' data-action='delete' data-id='{$row['id']}'>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                  </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JavaScript to Handle Appointment Management -->
<script>
$(document).ready(function() {
    // Search Appointments
    $('#searchAppointments').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('#appointmentsTable tbody tr').each(function() {
            const rowText = $(this).text().toLowerCase();
            if (rowText.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Handle Action Buttons
    $(document).on('click', '.dropdown-item[data-action]', function(e) {
        e.preventDefault(); // Prevent default link behavior
        const action = $(this).data('action'); // Get the action (approve, pending, reject, delete)
        const appointmentId = $(this).data('id'); // Get the appointment ID

        if (action === 'delete') {
            deleteAppointment(appointmentId);
        } else {
            updateAppointmentStatus(appointmentId, action);
        }
    });
});

// Update Appointment Status
function updateAppointmentStatus(appointmentId, status) {
    if (confirm("Are you sure you want to update the status of this appointment?")) {
        $.ajax({
            url: '../employee/manage-appointment-backend/update_appointment_status.php',
            type: 'POST',
            data: { id: appointmentId, status: status },
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    alert('Appointment status updated successfully!');
                    location.reload(); // Refresh the page
                } else {
                    alert('Error: ' + res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating appointment status:', error);
                alert('Error updating appointment status. Please check the console for details.');
            }
        });
    }
}

// Update Attendance
function updateAttendance(appointmentId, attendance) {
    $.ajax({
        url: '../employee/manage-appointment-backend/update_attendance.php',
        type: 'POST',
        data: { id: appointmentId, attendance: attendance },
        success: function(response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
                alert('Attendance updated successfully!');
            } else {
                alert('Error: ' + res.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating attendance:', error);
            alert('Error updating attendance. Please check the console for details.');
        }
    });
}

// Delete Appointment
function deleteAppointment(appointmentId) {
    if (confirm("Are you sure you want to delete this appointment?")) {
        $.ajax({
            url: '../employee/manage-appointment-backend/delete_appointment.php',
            type: 'POST',
            data: { id: appointmentId },
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    alert('Appointment deleted successfully!');
                    location.reload(); // Refresh the page
                } else {
                    alert('Error: ' + res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error deleting appointment:', error);
                alert('Error deleting appointment. Please check the console for details.');
            }
        });
    }
}
</script>

<?php
include '../employee/assets/inc/footer.php';
?>
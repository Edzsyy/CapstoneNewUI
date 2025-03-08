<?php
include '../user/assets/config/dbconn.php';
include '../user/assets/inc/header.php';

// Fetch all appointments for the current month
$currentMonth = date('Y-m');
$query = "SELECT appointment_date, time_slot FROM appointments WHERE DATE_FORMAT(appointment_date, '%Y-%m') = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $currentMonth);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$bookedSlots = [];
while ($row = mysqli_fetch_assoc($result)) {
    $bookedSlots[$row['appointment_date']][] = $row['time_slot'];
}
?>

<!-- Include jQuery & Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Month Selector -->
<div class="table-container-form">
    <div class="table-container table-form">
        <div class="table-body">
            <h4>Appointment Calendar</h4>
            
            <div class=" mb-3">
                <label for="monthSelector" class="form-label">Select Month</label>
                <input type="month" class="form-control" id="monthSelector" value="<?php echo date('Y-m'); ?>" style="padding: 15px; width: 200px; ">
            </div>

            
            <table class="table table-bordered" id="calendarTable">
                <thead>
                    <tr>
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Calendar will be dynamically populated here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Appointment Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Book Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="appointmentForm">
                    <input type="hidden" id="appointmentDate">
                    <div class="mb-3">
                        <label for="serviceType" class="form-label">Service Type</label>
                        <select class="form-control" id="serviceType" name="serviceType" required>
                            <option value="registration">Registration</option>
                            <option value="renewal">Renewal</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration</label>
                        <select class="form-control" id="duration" name="duration" required>
                            <option value="30">30 minutes</option>
                            <option value="60">1 hour</option>
                            <option value="90">1.5 hours</option>
                            <option value="120">2 hours</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="timeSlot" class="form-label">Available Time Slots</label>
                        <select class="form-control" id="timeSlot" name="timeSlot" required>
                            <option value="">Select a Time Slot</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveAppointment">Save Appointment</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Load the calendar for the selected month
    function loadCalendar(month) {
        $.ajax({
            url: '../user/appointment/fetch_calendar.php',
            type: 'GET',
            data: { month: month },
            success: function(response) {
                $('#calendarTable tbody').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error loading calendar:', error);
                alert('Error loading calendar. Please check the console for details.');
            }
        });
    }

    // Initialize the calendar with the current month
    loadCalendar($('#monthSelector').val());

    // Update the calendar when the month is changed
    $('#monthSelector').change(function() {
        const selectedMonth = $(this).val();
        loadCalendar(selectedMonth);
    });

    // Open modal when a date is clicked
    $(document).on('click', '.book-appointment', function(e) {
        e.preventDefault();
        const selectedDate = $(this).data('date');
        $('#appointmentDate').val(selectedDate);
        $('#appointmentModal').modal('show');

        // Fetch available time slots for the selected date
        fetchTimeSlots(selectedDate);
    });

    // Fetch available time slots
    function fetchTimeSlots(date) {
        const duration = $('#duration').val();
        $.ajax({
            url: '../user/appointment/fetch_time_slots.php',
            type: 'GET',
            data: { date: date, duration: duration },
            success: function(response) {
                const timeSlots = JSON.parse(response);
                const timeSlotSelect = $('#timeSlot');
                timeSlotSelect.empty();
                timeSlotSelect.append(`<option value="">Select a Time Slot</option>`);
                timeSlots.forEach(slot => {
                    timeSlotSelect.append(`<option value="${slot}">${slot}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching time slots:', error);
                alert('Error fetching time slots. Please check the console for details.');
            }
        });
    }

    // Update time slots when duration is changed
            $('#duration').change(function() {
                const selectedDate = $('#appointmentDate').val();
                if (selectedDate) {
                    fetchTimeSlots(selectedDate);
                }
            });

            // Save appointment
            $('#saveAppointment').click(function() {
            const formData = {
                serviceType: $('#serviceType').val(),
                appointmentDate: $('#appointmentDate').val(),
                timeSlot: $('#timeSlot').val(),
                duration: $('#duration').val(),
                notes: $('#notes').val()
            };

            console.log('Sending Data:', formData); // Debugging: Log sent data

            $.ajax({
                url: '../user/appointment/save_appointment.php',
                type: 'POST',
                data: formData,
                dataType: 'json', // Ensure response is treated as JSON
                success: function(response) {
                    console.log('Server Response:', response); // Debugging: Log server response
                    if (response.status === 'success') {
                        alert('Appointment booked successfully!');
                        $('#appointmentModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error, 'Response:', xhr.responseText);
                    alert('Error booking appointment. Check the console for details.');
                }
            });
        });
});
</script>

<?php
include '../user/assets/inc/footer.php';
?>
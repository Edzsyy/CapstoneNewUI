<?php 
include('../employee/assets/config/dbconn.php');

// Fetch data from both registration and renewal tables
$query = "
    SELECT email, business_name, business_address, business_type, application_status, date_application, id 
    FROM registration 
    UNION ALL 
    SELECT email, business_name, business_address, business_type, application_status, date_application, id 
    FROM renewal
"; 

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<table class="table table-striped">';
    echo '<thead>
            <tr>
                <th>Email</th>
                <th>Business Name</th>
                <th>Business Address</th>
                <th>Business Type</th>
                <th>Application Status</th>
                <th>Date of Application</th>
            </tr>
          </thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
                <td>' . htmlspecialchars($row['email']) . '</td>
                <td>' . htmlspecialchars($row['business_name']) . '</td>
                <td>' . htmlspecialchars($row['business_address']) . '</td>
                <td>' . htmlspecialchars($row['business_type']) . '</td>
                <td>' . htmlspecialchars($row['application_status']) . '</td>
                <td>' . htmlspecialchars($row['date_application']) . '</td>
              </tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>No records found.</p>';
}

mysqli_close($conn);
?>

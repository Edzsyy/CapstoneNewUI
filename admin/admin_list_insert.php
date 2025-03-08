<?php
include('../assets/config/dbconn.php');
session_start(); // Ensure session is started

if (isset($_POST['fnameSend']) && isset($_POST['lnameSend']) && isset($_POST['emailSend']) && isset($_POST['passwordSend'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fnameSend']);
    $lname = mysqli_real_escape_string($conn, $_POST['lnameSend']);
    $email = mysqli_real_escape_string($conn, $_POST['emailSend']);
    $password = password_hash($_POST['passwordSend'], PASSWORD_DEFAULT); // Hash the password

    // Use prepared statement for security
    $stmt = $conn->prepare("INSERT INTO admin (fname, lname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fname, $lname, $email, $password);

    if ($stmt->execute()) {
        // Get the last inserted admin ID
        $last_id = $stmt->insert_id;

        // Fetch the new admin details and update session
        $result = mysqli_query($conn, "SELECT * FROM admin WHERE id = '$last_id'");

        if ($fetch = mysqli_fetch_assoc($result)) {
            $_SESSION['admin_id'] = $fetch['id'];
            $_SESSION['fname'] = $fetch['fname'];
            $_SESSION['lname'] = $fetch['lname'];
            $_SESSION['email'] = $fetch['email'];
            $_SESSION['role_as'] = $fetch['role_as'];
            $_SESSION['image'] = isset($fetch['image']) ? $fetch['image'] : 'default-image.png'; // Ensure image is set
        }

        echo "Admin added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../error/errordb.php'); // Ensure logs folder exists
include '../employee/assets/config/dbconn.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Debugging - Log received POST data
    error_log("Received POST Data: " . print_r($_POST, true));

    // Get values safely
    $id = $_POST['id'] ?? null;
    $fname = $_POST['fname'] ?? '';
    $mname = $_POST['mname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $zip = $_POST['zip'] ?? null;
    $business_name = $_POST['business_name'] ?? '';
    $business_address = $_POST['business_address'] ?? '';
    $building_name = $_POST['building_name'] ?? '';
    $building_no = $_POST['building_no'] ?? '';
    $street = $_POST['street'] ?? '';
    $barangay = $_POST['barangay'] ?? '';
    $business_type = $_POST['business_type'] ?? '';
    $rent_per_month = $_POST['rent_per_month'] ?? '';
    $date_application = $_POST['date_application'] ?? '';
    $application_number = $_POST['application_number'] ?? null;

    // Debugging - Check what is missing
    $missing_fields = [];
    if (!$id) $missing_fields[] = 'id';
    if (!$zip) $missing_fields[] = 'zip';
    if (!$application_number) $missing_fields[] = 'application_number';

    if (!empty($missing_fields)) {
        die(json_encode([
            "status" => "error",
            "message" => "Error: Required fields are missing: " . implode(', ', $missing_fields)
        ]));
    }

    // File Upload Handling
    $upload_dir = "../user/assets/image/";
    $upload_dti = $upload_store_picture = $food_security_clearance = $upload_old_permit = "";

    function handleFileUpload($fileKey, $uploadDir) {
        if (!empty($_FILES[$fileKey]['name'])) {
            $fileName = time() . '_' . basename($_FILES[$fileKey]['name']); // Unique filename
            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $filePath)) {
                return $fileName;
            }
        }
        return null;
    }

    $upload_dti = handleFileUpload('upload_dti', $upload_dir);
    $upload_store_picture = handleFileUpload('upload_store_picture', $upload_dir);
    $food_security_clearance = handleFileUpload('food_security_clearance', $upload_dir);
    $upload_old_permit = handleFileUpload('upload_old_permit', $upload_dir);

    // Use prepared statements to prevent SQL injection
    $query = "UPDATE registration SET 
              fname=?, mname=?, lname=?, email=?, phone=?, address=?, zip=?, 
              business_name=?, business_address=?, building_name=?, building_no=?, street=?, 
              barangay=?, business_type=?, rent_per_month=?, date_application=?, 
              application_number=?";

    // Append file fields dynamically
    $params = [$fname, $mname, $lname, $email, $phone, $address, $zip, 
               $business_name, $business_address, $building_name, $building_no, 
               $street, $barangay, $business_type, $rent_per_month, $date_application, 
               $application_number];

    $types = str_repeat("s", count($params)); // Prepare data types for bind_param

    if ($upload_dti) {
        $query .= ", upload_dti=?";
        $params[] = $upload_dti;
        $types .= "s";
    }
    if ($upload_store_picture) {
        $query .= ", upload_store_picture=?";
        $params[] = $upload_store_picture;
        $types .= "s";
    }
    if ($food_security_clearance) {
        $query .= ", food_security_clearance=?";
        $params[] = $food_security_clearance;
        $types .= "s";
    }
    if ($upload_old_permit) {
        $query .= ", upload_old_permit=?";
        $params[] = $upload_old_permit;
        $types .= "s";
    }

    $query .= " WHERE id=?";
    $params[] = $id;
    $types .= "s";

    $stmt = mysqli_prepare($conn, $query);
    
    if (!$stmt) {
        die(json_encode(["status" => "error", "message" => "SQL Error: " . mysqli_error($conn)]));
    }

    mysqli_stmt_bind_param($stmt, $types, ...$params);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "Renewal record updated successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating record: " . mysqli_error($conn)]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
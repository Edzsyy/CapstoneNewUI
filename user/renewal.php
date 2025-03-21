<?php
// Start output buffering
ob_start();

// Enable error reporting and logging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/home/businesspermit.unifiedlgu.com/public_html/error.log');

// Start the session
//session_start();

// Include necessary files
include('../user/assets/inc/header.php');
include('../user/assets/config/dbconn.php');

// Initialize messages
$errorMessage = '';
$successMessage = '';

// Function to generate a unique application number
function generateApplicationNumber($conn)
{
    $prefix = "APP-";
    $date = date("Ymd");
    $query = "SELECT application_number FROM renewal WHERE application_number LIKE '$prefix$date%' ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastNumber = (int)substr($row['application_number'], -4);
        $newNumber = str_pad($lastNumber + 1, 4, "0", STR_PAD_LEFT);
    } else {
        $newNumber = "0001";
    }

    return $prefix . $date . $newNumber;
}

// Generate application number
$applicationNumber = generateApplicationNumber($conn);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure required fields exist before accessing them
    $fname = mysqli_real_escape_string($conn, $_POST['fname'] ?? '');
    $mname = mysqli_real_escape_string($conn, $_POST['mname'] ?? '');
    $lname = mysqli_real_escape_string($conn, $_POST['lname'] ?? '');
    $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $zip = mysqli_real_escape_string($conn, $_POST['zip'] ?? '');
    $business_name = mysqli_real_escape_string($conn, $_POST['business_name'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $business_address = mysqli_real_escape_string($conn, $_POST['business_address'] ?? '');
    $building_name = mysqli_real_escape_string($conn, $_POST['building_name'] ?? '');
    $building_no = mysqli_real_escape_string($conn, $_POST['building_no'] ?? '');
    $street = mysqli_real_escape_string($conn, $_POST['street'] ?? '');
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay'] ?? '');
    $business_type = mysqli_real_escape_string($conn, $_POST['business_type'] ?? '');
    $rent_per_month = mysqli_real_escape_string($conn, $_POST['rent_per_month'] ?? '');
    $date_application = isset($_POST['date_application']) ? mysqli_real_escape_string($conn, $_POST['date_application']) : '';

    // Handle file uploads
    $uploads = [
        'upload_dti' => $_FILES["upload_dti"] ?? null,
        'store_picture' => $_FILES["store_picture"] ?? null,
        'food_security_clearance' => $_FILES["food_security_clearance"] ?? null,
        'old_permit' => $_FILES["old_permit"] ?? null
    ];

    $uploadedFiles = [];
    foreach ($uploads as $key => $file) {
        if ($file && $file['error'] == 0) {
            $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
            if (in_array($file['type'], $allowedTypes) && $file['size'] < 2000000) { // 2MB limit
                $uploadedFiles[$key] = time() . '_' . basename($file['name']);
                $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/user/assets/image/' . $uploadedFiles[$key];

                if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    $errorMessage = "Failed to upload $key.";
                    break;
                }
            } else {
                $errorMessage = "Invalid file type or size for $key.";
                break;
            }
        } else {
            $uploadedFiles[$key] = NULL; // Handle optional file uploads
        }
    }

    // Check if there are no errors before inserting into the database
    if (empty($errorMessage)) {
        // Set the default application status to "Pending"
        $application_status = "Pending";

        $sql = "INSERT INTO renewal (fname, mname, lname, address, zip, business_name, phone, email, business_address, 
                building_name, building_no, street, barangay, business_type, rent_per_month, 
                application_number, document_status, upload_dti, upload_store_picture, food_security_clearance, upload_old_permit, date_application, application_status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $errorMessage = "MySQL prepare failed: " . htmlspecialchars($conn->error);
        } else {
            $document_status = ""; // Default document status
            $stmt->bind_param(
                "sssssssssssssssssssssss",
                $fname,
                $mname,
                $lname,
                $address,
                $zip,
                $business_name,
                $phone,
                $email,
                $business_address,
                $building_name,
                $building_no,
                $street,
                $barangay,
                $business_type,
                $rent_per_month,
                $applicationNumber,
                $document_status,
                $uploadedFiles['upload_dti'],
                $uploadedFiles['store_picture'],
                $uploadedFiles['food_security_clearance'],
                $uploadedFiles['old_permit'],
                $date_application,
                $application_status // Add application_status to the query
            );

            if ($stmt->execute()) {
                $successMessage = "Renewal successful!";
                header("location: renewal_list.php");
                exit();
            } else {
                $errorMessage = "Renewal Failed: " . $stmt->error;
            }
        }
    }
    // End output buffering
    ob_end_flush();
}
?>



<!--YOUR CONTENTHERE-->
<div class="table-container-form">
    <div class="table-container table-form">
        <div class="table-body ">
            <table id="myTable">
                <tbody>
                    <?php if ($errorMessage): ?>
                        <div class="alert alert-danger"><?= $errorMessage; ?></div>
                    <?php endif; ?>
                    <?php if ($successMessage): ?>
                        <div class="alert alert-success"><?= $successMessage; ?></div>
                    <?php endif; ?>

                    <form class="row g-3" id="validated_form" method="post" action="renewal.php" enctype="multipart/form-data">
                        <div class="top-form" style="text-align: center;">
                            <h6>Republic of the Philippines</h6>
                            <h6>San Agustin, Metropolitan Manila</h6>
                            <h6>Business Permit & Licence Office</h6>
                            <h5>APPLICATION FORM FOR RENEWAL OF BUSINESS PERMIT</h5>
                        </div>



                        <div class="row" style="margin-top: 30px;">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_application" class="form-label">Date of Application:</label>
                                    <input type="date" class="form-control" id="date_application" name="date_application" value="<?= date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="application_number" class="form-label">Application Number:</label>
                                    <input type="text" class="form-control" id="application_number" name="application_number" placeholder="Application Number" value="<?php echo $applicationNumber; ?>" readonly>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fname" class="form-label">First name:</label>
                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="mname" class="form-label">Middle name:</label>
                                    <input type="text" class="form-control" id="mname" name="mname" placeholder="Middle name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="lname" class="form-label">Last name:</label>
                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" required>
                                </div>
                            </div>


                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address:</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="zip" class="form-label">Zip Code:</label>
                                    <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip Code" required>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="business_name" class="form-label">Business Name:</label>
                                    <input type="text" class="form-control" id="business_name" name="business_name" placeholder="Business Name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Contact Number:</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Contact Number" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="business_address" class="form-label">Business Address:</label>
                                    <input type="text" class="form-control" id="business_address" name="business_address" placeholder="Business Address" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="building_name" class="form-label">Building Name:</label>
                                    <input type="text" class="form-control" id="building_name" name="building_name" placeholder="Building Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="building_no" class="form-label">Building No:</label>
                                    <input type="text" class="form-control" id="building_no" name="building_no" placeholder="Building No">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="street" class="form-label">Street:</label>
                                    <input type="text" class="form-control" id="street" name="street" placeholder="Street">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="barangay" class="form-label">Barangay:</label>
                                    <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Barangay">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="business_type" class="form-label">Business Type(Merchandising, Manufacturing, Service, etc..):</label>
                                    <input type="text" class="form-control" id="business_type" name="business_type" placeholder="Business Type" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rent_per_month" class="form-label">Rent Per Month:</label>
                                    <input type="text" class="form-control" id="rent_per_month" name="rent_per_month" placeholder="Rent Per Month" required>
                                </div>
                            </div>


                            <h5 class="col-md-12" style="text-align: center; margin: 30px 0;">Upload Required Documents</h5>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="upload_dti" class="form-label">Upload DTI:</label>
                                    <input type="file" class="form-control" id="upload_dti" name="upload_dti" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="store_picture" class="form-label">Upload Store Picture:</label>
                                    <input type="file" class="form-control" id="store_picture" name="store_picture" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="food_security_clearance" class="form-label">Upload Food Security Clearance:</label>
                                    <input type="file" class="form-control" id="food_security_clearance" name="food_security_clearance" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="old_permit" class="form-label">Upload Old Permit:</label>
                                    <input type="file" class="form-control" id="old_permit" name="old_permit" required>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top: 30px;">
                                <div class="mb-3">
                                    <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                </div>
                            </div>


                            <div class="col-md-12" style="margin-top: 30px;">
                                <div class="mb-3">
                                    <?php if (!empty($errorMessage)) : ?>
                                        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($successMessage)) : ?>
                                        <div class="alert alert-success"><?php echo $successMessage; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </form>
                </tbody>
            </table>
        </div>
    </div>
</div>










<?php
// Include footer and scripts
include('../user/assets/inc/footer.php');
?>

</body>

</html>
<?php
include('../employee/assets/config/dbconn.php');

// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log the received POST data for debugging
file_put_contents('debug.log', "POST Data: " . print_r($_POST, true) . "\n", FILE_APPEND);

if (isset($_POST['viewid'])) {
    $id = $_POST['viewid'];

    if (isset($_POST['application_status'])) {
        $status = $_POST['application_status'];

        // Update the application_status in the renewal table
        $query = "UPDATE renewal SET application_status = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $status, $id);
        $result = $stmt->execute();

        if ($result) {
            if ($status == 'Need Correction') {
                // Update document_status to '' in the renewal table
                $resubmitQuery = "UPDATE renewal SET document_status = '' WHERE id = ?";
                $resubmitStmt = $conn->prepare($resubmitQuery);
                $resubmitStmt->bind_param("i", $id);
                $resubmitResult = $resubmitStmt->execute();

                if (!$resubmitResult) {
                    echo json_encode(['success' => false, 'error' => 'Failed to update application_status: ' . $resubmitStmt->error]);
                    exit;
                }
            } elseif ($status == 'Approved') {
                // Update document_status to 'Pending to Released' in the renewal table
                $approveQuery = "UPDATE renewal SET document_status = 'Pending to Released' WHERE id = ?";
                $approveStmt = $conn->prepare($approveQuery);
                $approveStmt->bind_param("i", $id);
                $approveResult = $approveStmt->execute();

                if (!$approveResult) {
                    echo json_encode(['success' => false, 'error' => 'Failed to update application_status: ' . $approveStmt->error]);
                    exit;
                }
            }

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update document status: ' . $stmt->error]);
        }
    } elseif (isset($_POST['document_status']) && $_POST['document_status'] == 'Released') {
        // When clicking the "Release" button, update document_status to "Released" and set expiration_date
        $expirationDate = date('Y-m-d', strtotime('+1 year')); // Calculate expiration date as 1 year from today

        $releaseQuery = "UPDATE renewal SET document_status = 'Released', expiration_date = ? WHERE id = ?";
        $releaseStmt = $conn->prepare($releaseQuery);
        $releaseStmt->bind_param("si", $expirationDate, $id);
        $releaseResult = $releaseStmt->execute();

        if ($releaseResult) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update application_status: ' . $releaseStmt->error]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request. Missing parameters.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request. Missing parameters.']);
}

$conn->close();
?>
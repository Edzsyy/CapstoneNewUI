<?php
/* 1. SESSION & SECURITY FIRST
session_start();
session_regenerate_id(true);


// 2. Check authentication immediately
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}*/

// 3. Now include output-generating files
include('../user/assets/inc/header.php');
include('../user/assets/config/dbconn.php');

// 4. Fetch user data
$user_id = $_SESSION['user_id'];
$select = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'") or die(mysqli_error($conn));
$fetch = mysqli_fetch_assoc($select);


// Handle profile update
if (isset($_POST['update_profile'])) {
    $update_fname = mysqli_real_escape_string($conn, $_POST['update_fname']);
    $update_lname = mysqli_real_escape_string($conn, $_POST['update_lname']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
    $update_phone = mysqli_real_escape_string($conn, $_POST['update_phone']);
    $update_address = mysqli_real_escape_string($conn, $_POST['update_address']);

    mysqli_query($conn, "UPDATE users SET fname='$update_fname', lname='$update_lname', email='$update_email', phone='$update_phone', address='$update_address' WHERE id='$user_id'") or die(mysqli_error($conn));

    $old_pass = md5($_POST['old_pass']); // Ensure old password is hashed
    $update_pass = md5($_POST['update_pass']);
    $new_pass = md5($_POST['new_pass']);
    $confirm_pass = md5($_POST['confirm_pass']);

    if (!empty($_POST['update_pass']) || !empty($_POST['new_pass']) || !empty($_POST['confirm_pass'])) {
        if ($update_pass != $old_pass) {
            $message[] = 'Old password does not match!';
        } elseif ($new_pass != $confirm_pass) {
            $message[] = 'New password confirmation does not match!';
        } else {
            mysqli_query($conn, "UPDATE users SET password='$confirm_pass' WHERE id='$user_id'") or die(mysqli_error($conn));
            $message[] = 'Password updated successfully!';
        }
    }

    // Handle profile picture update
    if (!empty($_FILES['update_image']['name'])) {
        $update_image = $_FILES['update_image']['name'];
        $update_image_size = $_FILES['update_image']['size'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_folder = 'assets/image/' . $update_image;

        if ($update_image_size > 2000000) {
            $message[] = 'Image is too large!';
        } else {
            $image_update_query = mysqli_query($conn, "UPDATE users SET image='$update_image' WHERE id='$user_id'") or die(mysqli_error($conn));

            if ($image_update_query) {
                move_uploaded_file($update_image_tmp_name, $update_image_folder);
            }
            $message[] = 'Profile image updated successfully!';
        }
    }
}
?>




<!-- YOUR CONTENT HERE -->
<div class="table-container-form">
    <div class="table-container table-form">
        <div class="table-body">
            <table id="myTable">
                <tbody>
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                        <div class="row" style="margin-top: 30px;">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <div class="card-box text-center">
                                        <?php
                                        if ($fetch && !empty($fetch['image'])) {
                                            echo '<img src="assets/image/' . $fetch['image'] . '" style="height: 100px; width: 100px; border-radius: 50%; object-fit: cover;">';
                                        } else {
                                            echo '<img src="assets/image/profile.png" style="height: 100px; width: 100px; border-radius: 50%; object-fit: cover;">';
                                        }
                                        
                                        if (isset($message)) {
                                            foreach ($message as $msg) {
                                                echo '<div class="message">' . $msg . '</div>';
                                            }
                                        }
                                        ?>

                                        <h4 class="mb-0" style="margin-top: 15px"><?php echo $fetch ? $fetch['fname'] : ''  ; ?> <?php echo $fetch ? $fetch['lname'] : ''  ; ?></h4>
                                        <p class="text-muted"style="margin-top: 5px"><?php echo $fetch ? $fetch['email'] : ''; ?></p>
                                        
                                        <div class="text-left mt-3" style="margin-bottom: 20px;">
                                            <p class="text-muted"><strong>Full Name :</strong> <?php echo $fetch ? $fetch['fname'] . ' ' . $fetch['lname'] : 'N/A'; ?></p>
                                            <p class="text-muted"><strong>Email :</strong> <?php echo $fetch ? $fetch['email'] : 'N/A'; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <div class="card-box">
                                        <ul class="nav nav-pills navtab-bg nav-justified" style="margin-bottom: 20px;">
                                            <li class="nav-item">
                                                <a href="#aboutme" data-toggle="tab" class="nav-link active">Update Profile</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#settings" data-toggle="tab" class="nav-link">Change Password</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane show active" id="aboutme">
                                                <h5 class="mb-4"><i class="fa-solid fa-circle-user"></i> Personal Info</h5>
                                                <div class="row" style="margin-bottom: 20px;">
                                                    <div class="col-md-6">
                                                        <label>First Name</label>
                                                        <input type="text" name="update_fname" value="<?php echo $fetch ? $fetch['fname'] : ''; ?>" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Last Name</label>
                                                        <input type="text" name="update_lname" value="<?php echo $fetch ? $fetch['lname'] : ''; ?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-bottom: 20px;">
                                                    <div class="col-md-6">
                                                        <label>Phone</label>
                                                        <input type="text" name="update_phone" value="<?php echo $fetch ? $fetch['phone'] : ''; ?>" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Address</label>
                                                        <input type="text" name="update_address" value="<?php echo $fetch ? $fetch['address'] : ''; ?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-bottom: 20px;">
                                                    <div class="col-md-6">
                                                        <label>Email</label>
                                                        <input type="email" name="update_email" value="<?php echo $fetch ? $fetch['email'] : ''; ?>" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>PRofile Picture</label>
                                                        <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <button type="submit" name="update_profile" class="btn btn-success">Save</button>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="settings">
                                                <h5 class="mb-4" style="margin-bottom: 20px;">Change Password</h5>
                                                <input type="hidden" name="old_pass" value="<?php echo $fetch ? $fetch['password'] : ''; ?>" >
                                                <label>Old Password</label>

                                                <input type="password" class="form-control" name="update_pass" style="margin-bottom: 20px;">
                                                <label>New Password</label>

                                                <input type="password" class="form-control" name="new_pass" style="margin-bottom: 20px;">
                                                <label>Confirm Password</label>
                                                
                                                <input type="password" class="form-control" name="confirm_pass" style="margin-bottom: 20px;">
                                                
                                                <div class="text-right">
                                                    <button type="submit" name="update_pwd" class="btn btn-success">Update Password</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

include('../user/assets/inc/footer.php');

?>
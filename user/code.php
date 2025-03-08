<?php

require '../assets/config/function.php';

//update profile with image
if(isset($_POST['update_profile'])){
    $profileId = validate($_POST['profileId']);

    $fname = validate($_POST['fname']);
    $lname = validate($_POST['lname']);
    $email = validate($_POST['email']);

    $profile = getById('users', $profileId);
    

    if($_FILES['image']['size'] > 0){
        $image = $_FILES['image']['name'];

        $imgFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        if($imgFileType != 'jpg' && $imgFileType != 'jpeg' && $imgFileType != 'png'){
            redirect('profile.php', 'Sorry, Only JPG, JPEG, PNG Images Only');
        }

        //delete image or change image
        $path = "user/assets/image/";
        $deleteImage = "../".$profile['data']['image'];
        if(file_exists($deleteImage)){
            unlink($deleteImage);
        }

        //upload image
        $imgExt = pathinfo($image, PATHINFO_EXTENSION);
        $filename = time().'.'.$imgExt;

        $finalImage = 'user/assets/image/'.$filename;
    }
    else{
        $finalImage = $profile['data']['image'];
    }
    

    $query = "UPDATE users SET fname = '$fname', lname = '$lname', email = '$email' WHERE id='$profileId' ";
    $result = mysqli_query($conn, $query);

    if($result){
        if($_FILES['image']['size'] > 0){
            move_uploaded_file($_FILES['image']['tmp_name'], $path.$filename);
        }


        redirect('profile.php?id='.$profileId, 'profile updated successfully');
    }
    else{
        redirect('profile.php?id='.$profileId, 'Something Went Wrong');
    }
}

?>
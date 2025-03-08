
<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    bootstrap
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.1.6/datatables.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">  
    style
    <link rel="stylesheet" href="./assets/css/admin-style.css">
    icon logo
    <link rel="shortcut icon" href="./assets/image/logo.jpg" type="image/x-icon">
    
    <title>Admin</title>
</head>
<body>-->
    



<?php 
// 1. SESSION & SECURITY FIRST
session_start();

include('../admin/assets/config/dbconn.php');

require '../assets/config/function.php';

//include 'authentication.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="assets/images/unified-lgu-logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>LGU - Business Registration and Renewal system</title>

    <!-- Simple bar CSS (for scvrollbar)-->
    <link rel="stylesheet" href="assets/css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="assets/css/feather.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- datatable css cdn -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <!-- summer note css cdn -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- calendar event -->
    <link rel="stylesheet" href="assets/css/evo-calendar.midnight-blue.min.css">
    <link rel="stylesheet" href="assets/css/evo-calendar.min.css">
    <!-- calendar event anothor color -->
    <link rel="stylesheet" href="assets/css/evo-calendar.royal-navy.css">
    <link rel="stylesheet" href="assets/css/evo-calendar.royal-navy.min.css">






    <style>
        .avatar-initials {
            width: 165px;
            height: 165px;
            border-radius: 50%;
            display: flex;
            margin-left: 8px;
            justify-content: center;
            align-items: center;
            font-size: 50px;
            font-weight: bold;
            color: #fff;

        }

        .avatar-initials-min {
            width: 40px;
            height: 40px;
            background: #75e6da;
            border-radius: 50%;
            display: flex;
            margin-left: 8px;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            font-weight: bold;
            color: #fff;

        }

        .upload-icon {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            cursor: pointer;
            font-size: 24px;
            color: #fff;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            background-color: #333;
            padding: 10px;
            border-radius: 50%;
            z-index: 1;
        }

        .avatar-img:hover .upload-icon {
            opacity: 1;
        }

        .avatar-img {
            position: relative;
            transition: background-color 0.3s ease-in-out;
        }

        .avatar-img:hover {
            background-color: #a0f0e6;
        }
    </style>

</head>


<div class="loader-mask">
    <div class="loader">
        <div></div>
        <div></div>
    </div>
</div>


<body class="vertical  light">
    <div class="wrapper">

        <?php include 'assets/inc/navbar.php';  ?>


        <?php include 'assets/inc/sidebar.php';  ?>


        <main role="main" class="main-content">

            <!--For Notification header naman ito-->

            <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="defaultModalLabel">Notifications</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>


                        <div class="modal-body">
                            <div class="list-group list-group-flush my-n3">

                                <div class="col-12 mb-4">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="notification">
                                        <img class="fade show" src="assets/image/warning.png" width="35" height="35">
                                        <strong style="font-size:12px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"></strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="removeNotification()">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <p>Moreover, failing to renew your permit or register your business results in a fine ranging 
                                            from P5,000 to P20,000, and in extreme cases confiscation of assets and business closure.
                                        <a href="">click</a>
                                        </p>
                                        
                                    </div>
                                </div> <!-- /. col -->

                                <div id="no-notifications" style="display: none; text-align:center; margin-top:10px;">No notifications</div>
                            </div> <!-- / .list-group -->

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-block" onclick="clearAllNotifications()">Clear All</button>
                        </div>
                    </div>
                </div>
            </div>
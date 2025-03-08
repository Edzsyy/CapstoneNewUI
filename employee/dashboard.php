<?php 
include('../employee/assets/config/dbconn.php');

include('../employee/assets/inc/header.php');


?> 

<?= alertMessage(); ?>
   
<!--data info-->
<div class="main">
    <div class="box box-2">
        <div class="box-details">
            <h4>
                <?= getCount('registration') ?>
            </h4>
            <span>Total Registrations</span>
        </div>
        <div class="box-icon">
            <i class="fa-solid fa-user"></i>
        </div>
    </div>
    <div class="box box-3">
        <div class="box-details">
            <h4>
                <?= getCount('renewal') ?>
            </h4>
            <span>Total Renewals</span>
        </div>
        <div class="box-icon">
            <i class="fa-solid fa-user"></i>
        </div>
    </div>
    <div class="box box-2">
        <div class="box-details">
            <h4>
                <?= getCount('employee') ?>
            </h4>
            <span>Total Employees</span>
        </div>
        <div class="box-icon">
            <i class="fa-solid fa-user"></i>
        </div>
    </div>
    <div class="box box-2">
        <div class="box-details">
            <h4>
                <?= getCount('users') ?>
            </h4>
            <span>Total Users</span>
        </div>
        <div class="box-icon">
            <i class="fa-solid fa-user"></i>
        </div>
    </div>
</div>











<?php 
include('../employee/assets/inc/footer.php');
?> 




</body>
</html>

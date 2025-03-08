<?php 
include('../admin/assets/config/dbconn.php');

include('../admin/assets/inc/header.php');


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






<div class="fix-table-header" style="margin-top: 40px;">
    <h4>Registration List</h4>
</div>
<div class="table-container-form">
    <div class="table-container table-form">
        <div class="table-body">
            <table id="myTable">
                <tbody>
                    <div id="displayDataTable">
                        <!-- admin_dashboard_list_displaydata -->
                    </div>
                </tbody>
            </table>
        </div>
    </div>
</div>




<?php 
include('../admin/assets/inc/footer.php');
?> 


<script>
    $(document).ready(function()
    {
        displayData();
    });
    //display function
    function displayData()
    {
        var displayData="true";
        $.ajax
        ({
            url:"dashboard_list_displaydata.php",
            type:'post',
            data:{
                displaysend:displayData
            },
            success:function(data,status)
            {
                $('#displayDataTable').html(data);
                $('#updateModal').modal('hide');
            }
        });
    }




    //delete function
    function deleteuser(deleteid)
    {
        $.ajax({
            url:"registration_and_renewal_list_delete.php",
            type:'post',
            data:{
                deletesend:deleteid
            },
            success:function(data,status){
                //console.log(status);
                displayData();
            }
        });
    }


    //update record
    function getdetails(updateid)
    {
        $('#hiddendata').val(updateid);

        $.post("registration_and_renewal_list_update.php", {updateid:updateid}, function(data,status)
        {
            var userid =JSON.parse(data);

            $('#updateFirstname').val(userid.fname);
            $('#updateLastname').val(userid.lname);
            $('#updateEmail').val(userid.email);
            $('#updatePhone').val(userid.phone);
            $('#updateAddress').val(userid.address);
        });

        $('#updateModal').modal("show");
    }

    //update function
    function updatedetails()
    {
        var updateFirstname = $('#updateFirstname').val();
        var updateLastname = $('#updateLastname').val();
        var updateEmail = $('#updateEmail').val();
        var updatePhone = $('#updatePhone').val();
        var updateAddress = $('#updateAddress').val();
        var hiddendata = $('#hiddendata').val();

        $.post("registration_and_renewal_list_update.php",
        {
            updateFirstname:updateFirstname,
            updateLastname:updateLastname,
            updateEmail:updateEmail,
            updatePhone:updatePhone,
            updateAddress:updateAddress,
            hiddendata:hiddendata
        },
        function(data,status)
        {
            $('#updateModal').modal('hide');
            displayData();
        });
    }
    

</script>

</body>
</html>

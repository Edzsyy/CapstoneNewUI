<!--active if you click one of the sidebar-->
<?php 

$pageName = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'],"/") +1);

?>

<aside class="sidebar-left border-right bg-white " id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>

    <nav class="vertnav navbar-side navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="index.php">
                <img src="assets/image/unified-lgu-logo.png" width="45">
                <div class="brand-title">
                    <br>
                    <span>LGU3 - BUSINESS REGISTRATION <br> AND RENEWAL SYSTEM </span>
                </div>
            </a>
        </div>

        <!--Sidebar ito-->
        <ul class="navbar-nav <?= $pageName == 'dashboard.php' ? 'active':''; ?> flex-fill w-100 mb-2">
            <li class="nav-item dropdown">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-chart-line"></i>
                    <span class="ml-3 item-text">Dashboard</span>

                </a>
            </li>
        </ul>

       <p class="text-muted-nav nav-heading mt-4 mb-1">
            <span style="font-size: 10.5px; font-weight: bold; font-family: 'Inter', sans-serif;">MAIN COMPONENTS</span>
        </p>

         <!--<ul class="navbar-nav flex-fill w-100 mb-2">
            <ul class="navbar-nav 
                <?= $pageName == 'registration-manage.php' ? 'active':''; ?> 
                <?= $pageName == 'registration-create.php' ? 'active':''; ?>
            flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="registration-manage.php">
                        <i class="fa-regular fa-address-card"></i>
                        <span class="ml-3 item-text">Registration</span>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav 
                <?= $pageName == 'renewal-manage.php' ? 'active':''; ?> 
                <?= $pageName == 'renewal-create.php' ? 'active':''; ?> 
            flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="renewal-manage.php">
                        <i class="fa-solid fa-address-card"></i>
                        <span class="ml-3 item-text">Renewal</span>
                    </a>
                </li>
            </ul>-->

            <!--<ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-wrench"></i>
                        <span class="ml-3 item-text">Module 1</span>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-wrench"></i>
                        <span class="ml-3 item-text">Module 2</span>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#users" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fa-solid fa-users"></i>
                        <span class="ml-3 item-text">User's</span>  <span class="sr-only">(current)</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="users">
                        <li class="nav-item active">
                            <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">Add User</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">Manage User</span></a>
                        </li>

                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#pages" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fa-solid fa-wrench"></i>
                        <span class="ml-3 item-text">Module 5</span><span class="sr-only">(current)</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="pages">
                        <li class="nav-item active">
                            <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">Sub Module 5.1</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">Sub Module 5.2</span></a>
                        </li>

                    </ul>
                </li>
            </ul>-->

            

            <!--<p class="text-muted-nav nav-heading mt-4 mb-1">
                <span style="font-size: 10.5px; font-weight: bold; font-family: 'Inter', sans-serif;">OTHER COMPONENTS</span>
            </p>

            <ul class="navbar-nav 
                <?= $pageName == 'users-manage.php' ? 'active':''; ?> 
                <?= $pageName == 'users-create.php' ? 'active':''; ?>
                <?= $pageName == 'users-edit.php' ? 'active':''; ?>
            flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="users-manage.php">
                        <i class="fa-solid fa-users"></i>
                        <span class="ml-3 item-text">User's</span>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav 
                <?= $pageName == 'admins-manage.php' ? 'active':''; ?> 
                <?= $pageName == 'admins-create.php' ? 'active':''; ?> 
                <?= $pageName == 'admins-edit.php' ? 'active':''; ?> 
            flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="admins-manage.php">
                        <i class="fa-solid fa-user-secret"></i>
                        <span class="ml-3 item-text">Admin</span>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav 
                <?= $pageName == 'subadmins-manage.php' ? 'active':''; ?> 
                <?= $pageName == 'subadmins-create.php' ? 'active':''; ?> 
                <?= $pageName == 'subadmins-edit.php' ? 'active':''; ?> 
            flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="subadmins-manage.php">
                        <i class="fa-solid fa-user-tie"></i>
                        <span class="ml-3 item-text">Sub Admin</span>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav 
                <?= $pageName == 'employees-manage.php' ? 'active':''; ?> 
                <?= $pageName == 'employees-create.php' ? 'active':''; ?> 
                <?= $pageName == 'employees-edit.php' ? 'active':''; ?> 
            flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="employees-manage.php">
                        <i class="fa-solid fa-user-tie"></i>
                        <span class="ml-3 item-text">Employee</span>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav 
                <?= $pageName == 'applicants-manage.php' ? 'active':''; ?> 
                <?= $pageName == 'applicants-create.php' ? 'active':''; ?> 
                <?= $pageName == 'applicants-edit.php' ? 'active':''; ?> 
            flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="applicants-manage.php">
                        <i class="fa-solid fa-user"></i>
                        <span class="ml-3 item-text">User</span>
                    </a>
                </li>
            </ul>



            <p class="text-muted-nav nav-heading mt-4 mb-1">
                <span style="font-size: 10.5px; font-weight: bold; font-family: 'Inter', sans-serif;">OTHER COMPONENTS</span>
            </p>

            <ul class="navbar-nav 
                <?= $pageName == 'social-media.php' ? 'active':''; ?> 
                <?= $pageName == 'social-media-create.php' ? 'active':''; ?> 
                <?= $pageName == 'social-media-edit.php' ? 'active':''; ?> 
            flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="social-media.php">
                        <i class="fa-solid fa-tv"></i>
                        <span class="ml-3 item-text">Social media</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav 
                <?= $pageName == 'services.php' ? 'active':''; ?> 
                <?= $pageName == 'services-create.php' ? 'active':''; ?> 
                <?= $pageName == 'services-edit.php' ? 'active':''; ?> 
            flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="services.php">
                        <i class="fa-solid fa-tv"></i>
                        <span class="ml-3 item-text">Services or features</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav 
                <?= $pageName == 'enquiries.php' ? 'active':''; ?> 
                <?= $pageName == 'enquiries-view.php' ? 'active':''; ?> 
            flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="enquiries.php">
                        <i class="fa-solid fa-tv"></i>
                        <span class="ml-3 item-text">Enquiries</span>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav 
                <?= $pageName == 'calendar-event.php' ? 'active':''; ?> flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="calendar-event.php">
                        <i class="fa-solid fa-tv"></i>
                        <span class="ml-3 item-text">Calendar Event</span>
                    </a>
                </li>
            </ul>-->

            


            <p class="text-muted-nav nav-heading mt-4 mb-1">
                <span style="font-size: 10.5px; font-weight: bold; font-family: 'Inter', sans-serif;">APPOINTMENTS</span>
            </p>

            <ul class="navbar-nav <?= $pageName == 'appointment_calendar.php' ? 'active':''; ?> flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="appointment_calendar.php">
                        <i class="fa-solid fa-calendar-days"></i> <!-- Use a calendar icon -->
                        <span class="ml-3 item-text">Appointment Calendar</span>
                    </a>
                </li>
            </ul>


            <!--<p class="text-muted-nav nav-heading mt-4 mb-1">
                <span style="font-size: 10.5px; font-weight: bold; font-family: 'Inter', sans-serif;">OTHER COMPONENTS</span>
            </p>-->

            <ul class="navbar-nav <?= $pageName == 'registration_list.php' ? 'active':''; ?> flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="registration_list.php">
                        <i class="fa-solid fa-tv"></i>
                        <span class="ml-3 item-text">Registration List</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav <?= $pageName == 'renewal_list.php' ? 'active':''; ?> flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="renewal_list.php">
                        <i class="fa-solid fa-tv"></i>
                        <span class="ml-3 item-text">Renewal List</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav <?= $pageName == 'business_aprove_list_data.php' ? 'active':''; ?> flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="business_aprove_list_data.php">
                        <i class="fa-solid fa-tv"></i>
                        <span class="ml-3 item-text">Registered Business</span>
                    </a>
                </li>
            </ul>
            
            <p class="text-muted-nav nav-heading mt-4 mb-1">
                <span style="font-size: 10.5px; font-weight: bold; font-family: 'Inter', sans-serif;">APPOINTMENTS</span>
            </p>

            <ul class="navbar-nav <?= $pageName == 'manage_appointments.php' ? 'active':''; ?> flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="manage_appointments.php">
                        <i class="fa-solid fa-calendar-check"></i> <!-- Use a calendar check icon -->
                        <span class="ml-3 item-text">Manage Appointments</span>
                    </a>
                </li>
            </ul>




            <p class="text-muted-nav nav-heading mt-4 mb-1">
                <span style="font-size: 10.5px; font-weight: bold; font-family: 'Inter', sans-serif;">OTHER COMPONENTS</span>
            </p>

            <ul class="navbar-nav <?= $pageName == 'registration.php' ? 'active':''; ?> flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="registration.php">
                        <i class="fa-solid fa-tv"></i>
                        <span class="ml-3 item-text">Registration</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav <?= $pageName == 'renewal.php' ? 'active':''; ?> flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="renewal.php">
                        <i class="fa-solid fa-tv"></i>
                        <span class="ml-3 item-text">Renewal</span>
                    </a>
                </li>
            </ul>











            <p class="text-muted-nav nav-heading mt-4 mb-1">
                <span style="font-size: 10.5px; font-weight: bold; font-family: 'Inter', sans-serif;">OTHER COMPONENTS</span>
            </p>

            <ul class="navbar-nav <?= $pageName == 'admin_list.php' ? 'active':''; ?> flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="admin_list.php">
                        <i class="fa-solid fa-tv"></i>
                        <span class="ml-3 item-text">Admin List</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav <?= $pageName == 'employee_list.php' ? 'active':''; ?> 
            flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="employee_list.php">
                        <i class="fa-solid fa-tv"></i>
                        <span class="ml-3 item-text">Employee List</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav <?= $pageName == 'user_list.php' ? 'active':''; ?>  flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="user_list.php">
                        <i class="fa-solid fa-tv"></i>
                        <span class="ml-3 item-text">User List</span>
                    </a>
                </li>
            </ul>














            <p class="text-muted-nav nav-heading mt-4 mb-1">
                <span style="font-size: 10.5px; font-weight: bold; font-family: 'Inter', sans-serif;">SETTINGS</span>
            </p>

            <ul class="navbar-nav <?= $pageName == 'settings_ai.php' ? 'active':''; ?> flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="settings_ai.php">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        <span class="ml-3 item-text">AI Settings</span>
                    </a>
                </li>
            </ul>

            <!--
            <ul class="navbar-nav <?= $pageName == 'settings.php' ? 'active':''; ?> flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="settings.php">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        <span class="ml-3 item-text">Settings</span>
                    </a>
                </li>
            </ul>
            -->

        </ul>
    </nav>
</aside>


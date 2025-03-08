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


            

        </ul>
    </nav>
</aside>


  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">

      <i class="bi toggle-sidebar-btn">
        <img class="logo" src="assets/img/logo-b.png" alt="">
      </i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown">
          <?php
          $ret1 = mysqli_query($con, "SELECT tblcustomers.FirstName, tblcustomers.LastName, tblappointments.AptNum from tblappointments join tblcustomers on tblcustomers.CustID=tblappointments.CustID WHERE tblappointments.Status='Scheduled' OR tblappointments.Status='Re-Scheduled'");
          $num = mysqli_num_rows($ret1);

          ?>

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i><?php if ($num > 0) { ?>
              <span class="badge bg-primary badge-number"><?php echo $num; ?></span><?php } ?>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">

            <li class="dropdown-header">
              You have <?php echo $num; ?> new notifications
              <a href="appointment.php"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <?php if ($num > 0) {
              while ($result = mysqli_fetch_array($ret1)) {
            ?>
                <a class="notification-item" href="appointment-view.php?viewid=<?php echo $result['AptNum']; ?>">
                  <i class="bi bi-info-circle text-primary"></i>
                  <div>
                    <h4>NEW APPOINTMENT</h4>
                    <p>New appointment received from <b> <?php echo $result['FirstName']; ?> <?php echo $result['LastName']; ?></b></p>
                    <p>Appointment No. <b><?php echo $result['AptNum']; ?></b></p>

                  </div>

                </a>
                <hr class="dropdown-divider">
              <?php }
            } else { ?>
              <a class="dropdown-item" href="all-appointment.php">No New Appointment Received</a>
            <?php } ?>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->
        
        <?php $ID = $_SESSION['empid'];
        $ret = mysqli_query($con, "SELECT * from tblemployee where EmployeeID =$ID");
        while ($row = mysqli_fetch_array($ret)) { ?>
        
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <?php if (isset($row['ProfilePic'])) { ?>
                  <img src="../profilepics/<?php echo $row['ProfilePic']; ?>" alt="Profile" class="rounded-circle">
                <?php
                } else { ?>
                  <img src="../profilepics/default-avatar.png" alt="Profile" class="rounded-circle">
                <?php } ?>
            <span class="d-none d-md-block dropdown-toggle ps-2"></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $row['FirstName'] . " ". $row['LastName']; ?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="admin-profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <?php } ?>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
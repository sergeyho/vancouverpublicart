<?php 
  require('helpers.php');
  session_start();
  require_once "../utils/auth.php";
  
  html_headers('Public Art');
?>

<!-- Navbar -->
<nav class="navbar ps-3 pe-3 navbar-expand-lg navbar-dark">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Navbar brand -->
    <!-- <a class="navbar-brand" href="../routes/index.php">Public Art</a> -->

    <!-- Toggle button -->
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarButtonsExample"
      aria-controls="navbarButtonsExample"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarButtonsExample">
      <!-- Left links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="../routes/index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../routes/sites.php">Public Arts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
      </ul>
      <!-- Left links -->
      <?php 
        if(is_logged_in()) {
          $name = $_SESSION["first_name"] . ' ' . $_SESSION["last_name"];
          echo "
            <div class='dropdown'>
              <a
                class='dropdown-toggle d-flex align-items-center hidden-arrow'
                href='#'
                id='navbarDropdownMenuAvatar'
                role='button'
                data-mdb-toggle='dropdown'
                aria-expanded='false'
              >
                <button type='button' class='btn btn-primary btn-floating'>
                  <i class='fa-solid fa-user'></i>
                </button>
              </a>
              <ul
                class='dropdown-menu dropdown-menu-end'
                aria-labelledby='navbarDropdownMenuAvatar'
              >
                <li><h6 class='dropdown-header'>$name</h6></li>
                <li>
                  <a class='dropdown-item' href='myprofile.php'>My profile</a>
                </li>
                <li>
                  <a class='dropdown-item' href='../routes/logout.php'>Logout</a>
                </li>
              </ul>
            </div>
          ";
        } else {
          echo "
            <div class='d-flex align-items-center'>
              <a class='btn btn-link px-3 me-3' href='../routes/login.php'>Login</a>
              <a class='btn btn-primary' href='../routes/register.php'>Sign Up For Free</a>
            </div>
          ";
        }
      ?>
    </div>
    <!-- Collapsible wrapper -->
  </div>
  <!-- Container wrapper -->
</nav>
<!-- Navbar -->
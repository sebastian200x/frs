<style>
  .user-img{
        position: absolute;
        height: 27px;
        width: 27px;
        object-fit: cover;
        left: -7%;
        top: -12%;
  }
  .btn-rounded{
        border-radius: 50px;
  }
</style>

<!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-light bg-primary shadow text-sm">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
          <!-- <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> -->
          </li>
          <li class="nav-item d-none d-sm-inline-block navbar-light">
            <a href="<?php echo base_url ?>" class="nav-link"><?php echo (!isMobileDevice()) ? $_settings->info('name'):$_settings->info('short_name'); ?> - Admin</a>
          </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

          <div class="dropdown show mr-2 navbar-light">
              <a class="btn btn-white " href="#" role="button" id="Userinformation" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Authentication
              </a>

              <div class="dropdown-menu" aria-labelledby="Userinformation">
                <a class="dropdown-item" href="./?page=user"><i class="nav-icon fas fa-angle-right fa-xs"></i> User Profile</a>
                <!-- <a class="dropdown-item" href="./?page=user/log"><i class="nav-icon fas fa-angle-right fa-xs"></i> User log</a> -->
                
              </div>
          </div>

          <div class="dropdown show mr-2 navbar-light">
              <a class="btn btn-white " href="#" role="button" id="Orderingprocess" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Facial Recognition
              </a>

              <div class="dropdown-menu" aria-labelledby="Orderingprocess">
                <a class="dropdown-item" href="./?page=face/faceCapture"><i class="nav-icon fas fa-angle-right fa-xs"></i> Face Capture</a>
                <a class="dropdown-item" href="./?page=face"><i class="nav-icon fas fa-angle-right fa-xs"></i> Facial analyzer</a>
              </div>
          </div>

          <div class="dropdown show mr-2 navbar-light">
              <a class="btn btn-white " href="#" role="button" id="report" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Data Management
              </a>
            
              <div class="dropdown-menu" aria-labelledby="report">
                <a class="dropdown-item" href="./?page=reports"><i class="nav-icon fas fa-angle-right fa-xs"></i>Face logs</a>
                <a class="dropdown-item" href="./?page=reports/fileReport"><i class="nav-icon fas fa-angle-right fa-xs"></i>File Logs</a>
                <!-- <a class="dropdown-item" href="./?page=inventory"><i class="nav-icon fas fa-angle-right fa-xs"></i> Inventory</a> -->
                
              </div>
          </div>
          
          

        <script> $('.dropdown-item.hover').addClass('bg-gradient-orange')</script>
          <!-- Navbar Search -->
          <!-- <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
              <form class="form-inline">
                <div class="input-group input-group-sm">
                  <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </li> -->
          <!-- Messages Dropdown Menu -->
          <li class="nav-item">
            <div class="btn-group nav-link" id="my-account">
                  <button type="button" class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon" data-toggle="dropdown">
                    <!-- <span><img src="<?php echo validate_image($_settings->userdata('avatar')) ?>" class="img-circle elevation-2 user-img" alt="User Image"></span> -->
                    <span class="ml-3"><?php echo ucwords($_settings->userdata('firstname').' '.$_settings->userdata('lastname')) ?></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu" role="menu">
                    <!-- <a class="dropdown-item" href="<?php echo base_url.'admin/?page=user' ?>"><span class="fa fa-user"></span> My Account</a>
                    <div class="dropdown-divider"></div> -->
                    <!-- <a class="dropdown-item" href="./?page=system_info"><span class="fa fa-cog"></span> System Information</a> -->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo base_url.'/classes/Login.php?f=logout' ?>"><span class="fas fa-sign-out-alt"></span> Logout</a>
                  </div>
              </div>
          </li>
          <li class="nav-item">
            
          </li>
         <!--  <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
            </a>
          </li> -->
        </ul>
      </nav>
      <!-- /.navbar -->
      <script>
        $("a").hover(function(){
        $(this).css("background-color", "MistyRose");
        }, function(){
        $(this).css("background-color", "white");
        });

      </script>
      
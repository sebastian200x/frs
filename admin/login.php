<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
 <?php require_once('inc/topBarNav.php') ?>
<body class="sidebar-collapse hold-transition">
  <script>
    start_loader()
    $(document).ready(function(){

    $('.account').hide();
    $('.sys_name').hide();
    $('#register').hide();
    $('#registerbtn').hide();
    

    });
  </script>
  <style>
    body{
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size:cover;
      background-repeat:no-repeat;
      backdrop-filter: contrast(1);
    }
    #page-title{
      text-shadow: 6px 4px 7px black;
      font-size: 3.5em;
      color: #fff4f4 !important;
      background: #8080801c;
    }
  </style>

      <?php 
      // if(isset($_GET['id'])){
      //     $user = $conn->query("SELECT * FROM tblusers where id ='{$_GET['id']}' ");
      //     foreach($user->fetch_array() as $k =>$v){
      //         $meta[$k] = $v;
      //     }
      // }
      ?>
      <?php if($_settings->chk_flashdata('success')): ?>
      
      <?php endif;?>
      



  <div style="padding-top:1%;">
  <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo $_settings->info('name') ?></b></h1>
  </div>
  <div class="login-box" style="display: block; margin-left: auto;margin-right: auto; width: 30%;">
  
  <!-- /.login-logo -->
  <div class="card card-warning my-2">
    <div class="card-body">
      <!-- register -->
      <div class="card-body" id="register" >
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="login.php" id="manage-user">	
				<input type="hidden" name="id" value="<?= isset($meta['id']) ? $meta['id'] : '' ?>">
				<div class="form-group">
					<label for="name">First Name</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required>
				</div>
				<div class="form-group">
					<label for="name">Middle Name</label>
					<input type="text" name="middlename" id="middlename" class="form-control" value="<?php echo isset($meta['middlename']) ? $meta['middlename']: '' ?>">
				</div>
				<div class="form-group">
					<label for="name">Last Name</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required>
				</div>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
				</div>
				<div class="form-group">
					<label for="password"><?= isset($meta['id']) ? "New" : "" ?> Password</label>
					<input type="password" name="password" id="password" class="form-control" value="" required autocomplete="off">
                    <?php if(isset($meta['id'])): ?>
					<small><i>Leave this blank if you dont want to change the password.</i></small>
                    <?php endif; ?>
				</div>
        <div class="form-group">
					<label for="password"><?= isset($meta['id']) ? "New" : "" ?>Confirm Password</label>
					<input type="password" name="password" id="password" class="form-control" value="" required autocomplete="off">
                   
				</div>
        <div class="row">
          <div id="registerbtn" style="margin: auto;width: 80%;padding: 10px;" class="btn-group" role="group" aria-label="Basic outlined example">
            <button type="submit" form="manage-user" id="user_list_btn" class="btn btn-outline-primary">Create Account</button>          
            <button type="button" onclick="back()" class="btn btn-outline-primary">Back to Login</button>
          </div>
        </div>
				<!-- <div class="form-group">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
		              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))" accept="image/png, image/jpeg">
		              <label class="custom-file-label" for="customFile">Choose file</label>
		            </div>
				</div> -->
				<!-- <div class="form-group d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div> -->
			</form>
		</div>
	</div>
<!-- register -->
      <div id="login">
      <p class="login-box-msg">Sign in to continue</p>
      <form id="login-frm" action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" autofocus placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control"  name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        </div>
        
        <div class="row">
          <div class="col-8">
            <!-- <a href="< ?php echo base_url ?>">Go to Website</a> -->
          </div>
          <!-- /.col -->
<!-- buttons -->
          <div id="loginbtn" style="margin: auto;width: 80%;padding: 10px;" class="btn-group" role="group" aria-label="Basic outlined example">
            <button type="button" onclick="create_account()" class="btn btn-outline-primary">Register</button>          
            <button type="submit" id="sign_in_btn" class="btn btn-outline-primary">Sign in</button>
          </div>
          
          <!-- /.col -->
          
        </div>
      </form>
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url ?>dist/js/adminlte.min.js"></script>

<script>
  
  function create_account(){
    $('#register').show();
    $('#login').hide();
    $('#loginbtn').hide();
    $('#registerbtn').show();

  }
  function back(){
    $('#login').show();
    $('#register').hide();
    $('#loginbtn').show();
    $('#registerbtn').hide();
  }
  
  // register form
    
  $('#manage-user').submit(function(e){
    e.preventDefault();
    start_loader()
    $.ajax({
      url:_base_url_+'classes/Users.php?f=save',
      data: new FormData($(this)[0]),
      cache: false,
      contentType: false,
      processData: false,
      method: 'POST',
      type: 'POST',
      success:function(resp){
        if(resp == 1){
          location.href='./?page=user/list'
        }else{
          $('#msg').html('<div class="alert alert-danger">Username already exist</div>')
          end_loader();
        }
      }
    })
  });

  $(document).ready(function(){
    $('#my-account').hide();
    $('#create_new').click(function(){
      uni_modal("<i class='far fa-plus-square'></i> Add New Menu ","menus/manage_menu.php")
    });
    end_loader();

    var clickCount = 0;
    var cooldownTimer;

    // Function to reset the click count and cooldown timer
    function resetCooldown() {
      clickCount = 0;
      clearInterval(cooldownTimer);
      $('#sign_in_btn').prop('disabled', false).text('Sign In'); // Re-enable the button and reset text
      $('#cooldown_timer').text(''); // Clear the cooldown timer display
    }

    // Click event handler for the sign-in button
    $('#sign_in_btn').click(function() {
      clickCount++; // Increment the click count
      if (clickCount >= 3) { // If clicked 3 times
        $(this).prop('disabled', true); // Disable the button
        var cooldownSeconds = 30;
        updateButtonText(cooldownSeconds); // Update button text with initial cooldown time
        clearInterval(cooldownTimer); // Clear any existing cooldown timer
        cooldownTimer = setInterval(function() {
          cooldownSeconds--;
          if (cooldownSeconds <= 0) {
            resetCooldown(); // Reset the cooldown when time is up
          } else {
            updateButtonText(cooldownSeconds); // Update the button text with remaining cooldown time
          }
        }, 1000); // Update every second
      }
    });

    // Function to update the button text with remaining cooldown time
    function updateButtonText(seconds) {
      $('#sign_in_btn').text('Cooldown: ' + seconds + 's');
    }
  });
  
  
</script>




</body>
</html>
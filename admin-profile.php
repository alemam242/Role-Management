<?php
session_start();

require_once('./functions.php');


$usernameError = $emailError = "";

if(isset($_SESSION['user'])){
  $user = $_SESSION['user'];

  if($user['role'] !== 'admin'){
    header("Location: ./index.php");
  }
}


if(isset($_POST['save'])){
  $userId = $_POST['userId'];
  $username = $_POST['username'];
  $email = $_POST['email'];

  $newData = editProfile($userId,$username,$email);

  session_unset();
  $_SESSION['user']=$newData;
  header("Location: ./admin-profile.php");
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>
    Role-Management | Admin-Profile
  </title>

  <?php
  require_once('./const/linker.php');
  ?>

</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100">
    <!-- Nothing -->
  </div>


  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="#" target="_blank">
        <img src="./assets/img/logo.png" class="navbar-brand-img h-100" alt="...">
        <span class="ms-1 font-weight-bold">Role Management</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="./admin-dashboard.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="javascript:;">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="./logout.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-button-power text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>

<div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <?php
  require_once('./const/navbar.php');
  ?>
    <!-- End Navbar -->

    <div class="card shadow-lg mx-4 card-profile-bottom" style="margin-top: 10em;">
      <div class="card-body p-3">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="<?php echo getAvatar($user['username']);?>" alt="avatar" class="w-100 border-radius-lg ">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                <?php echo $user['username'];?>
              </h5>
              <p class="mb-0 font-weight-bold text-sm mb-1">
              <?php echo $user['email'];?>
              </p>
              <p class="mb-0 font-weight-bold text-sm">
              <label class="badge badge-sm bg-gradient-primary"><?php echo $user['role'];?></label>
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container-fluid py-4">
      <div class="row justify-content-md-center">
        <div class="col-md-8">

          <div class="card">
          <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="h5 mb-0">Edit Profile</p>
              </div>
            </div>
                <div class="card-body">
                <p class="text-uppercase text-sm">User Information</p>
                  <form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Username</label>
                                <input class="form-control" name="username" type="text" value="<?php echo $user['username'];?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Email address</label>
                                <input class="form-control" name="email" type="email" value="<?php echo $user['email'];?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <input type="hidden" id="editUserId" name="userId" value="<?php echo $user['id'];?>">
                            <button type="submit" name="save" class="btn btn-sm btn-primary">Save</button>
                        </div>
                    </div>
              
                  </form>
                  <hr class="horizontal dark">
                </div>
              </div>
        </div>
      </div>
    </div>
  </div>




  <!--   Core JS Files   -->
  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/chartjs.min.js"></script>
  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }

    function passValue(obj){
        document.getElementById('Role').value = obj['role'];
        document.getElementById('userName').value = obj['username'];
        document.getElementById('Email').value = obj['email'];
        document.getElementById('editUserId').value = obj['id'];

        // document.getElementById('editUserId').value = user;
        // console.log(obj);
        console.log(obj['id']);

        return false;
    }
</script>

  
</body>

</html>
<?php
session_start();

require_once('./functions.php');


$usernameError = $emailError = "";

if(isset($_SESSION['user'])){
  $user = $_SESSION['user'];

  if($user['role'] !== 'manager'){
    header("Location: ./index.php");
  }
}

$users = getUsers();
$admins = [];

$nadmin=$nuser=$nmanager=0;

foreach($users as $eachUser){
  if($eachUser['role'] === 'admin'){
    $admins[] = $eachUser;
    $nadmin++;
  }
  else if($eachUser['role'] === 'user'){
    $nuser++;
  }
  else if($eachUser['role'] === 'manager'){
    $nmanager++;
  }
}


if(isset($_POST['saveChanges'])){
  $userId = $_POST['userId'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $role = $_POST['role'];

  echo $userId . " " . $username . " " . $email . " " . $role;
  editUser($userId,$username,$email,$role);
  header("Location: ./admin-dashboard.php");
}

if(isset($_POST['deleteuser'])){
  $userId = $_POST['userId'];
  deleteUser($userId);
  header("Location: ./admin-dashboard.php");
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
    Role-Management | Manager-Dashboard
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
          <a class="nav-link active" href="javascript:;">
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
          <a class="nav-link " href="./manager-profile.php">
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

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4" style="margin-top: 10em;">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-6">
                  <h6>All Users</h6>
                </div>
              </div>
              <!-- <h6>All Users</h6> -->
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Registered</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($users as $eachUser){
                        if($eachUser['role']==='user'){
                      $str = json_encode($eachUser);
                      
                        echo "<tr>";
                        
                      echo "<td>
                      <div class='d-flex px-2 py-1'>
                        <div class='d-flex flex-column justify-content-center'>
                          <h6 class='mb-0 text-xs text-secondary ms-1'>{$eachUser['username']}</h6>
                        </div>
                      </div>
                    </td>";
                    echo "<td>
                      <h6 class='text-xs text-secondary mb-0'>{$eachUser['email']}</>
                    </td>";
                    echo "<td class='align-middle text-center text-sm'>
                      <p class='text-xs font-weight-bold mb-0'>{$eachUser['role']}</p>
                    </td>";
                    echo "<td class='align-middle text-center'>
                      <span class='text-secondary text-xs font-weight-bold'>23/04/18</span>
                    </td>";
                    echo "</tr>";
                    }
                }
                    ?>
                  </tbody>
                </table>
              </div>
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
<?php
session_start();

require_once('./functions.php');


$usernameError = $emailError = "";

if(isset($_SESSION['user'])){
  $user = $_SESSION['user'];

  if($user['role'] !== 'user'){
    header("Location: ./index.php");
  }
}


if(isset($_POST['save'])){
  $userId = $_POST['userId'];
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);

  if(!is_valid_email($email)){
    $emailError = "* Email is not valid!";
  }
  if(!is_valid_username($username)){
    $usernameError = "* Username is not valid!";
  }

  if($emailError === "" && $usernameError === ""){
  $newData = editProfile($userId,$username,$email);

  session_unset();
  $_SESSION['user']=$newData;
  header("Location: ./user-dashboard.php");
  }
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
    Role-Management | User-Dashboard
  </title>

  <?php
  require_once('./const/linker.php');
  ?>

</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100">
    <!-- Nothing -->
  </div>


  <?php
  require_once('./const/user-sidebar.php');
  ?>

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
                                <label for="example-text-input" class="form-control-label">Username</label><?php echo "<label for='example-text-input' class='text-danger form-control-label'> $usernameError </label>";?>
                                <input class="form-control" name="username" type="text" value="<?php echo $user['username'];?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Email address</label><?php echo "<label for='example-text-input' class='text-danger form-control-label'> $emailError </label>";?>
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



  
    <!-- Create Admin Modal -->
    <div class="modal fade" id="createAdminModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
                        <div class="mb-3">
                            <label for="editRole" class="form-label">Role</label>
                            <select class="form-select" id="editRole" name="role" required>
                                <!-- <option value="user">User</option>
                                <option value="manager">Manager</option> -->
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label> <?php echo "<label for='username' class='text-danger'>$usernameError</label>";?>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label> <?php echo "<label for='email' class='text-danger'>$emailError</label>";?>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label> <?php echo "<label for='password' class='text-danger'>$passwordError</label>";?>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="addUser">Add Admin</button>
                    </form>
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
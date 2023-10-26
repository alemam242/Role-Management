<?php
session_start();

require_once('./functions.php');


$usernameError = $emailError = $passwordError = "";

if(isset($_SESSION['user'])){
  $user = $_SESSION['user'];

  if($user['role'] !== 'admin'){
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

if(isset($_POST['addUser'])){
  $role = trim($_POST['role']);
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  if(!is_valid_username($username)){
      $usernameError = "* username is not valid!";
  }
  if(is_exists_username($username)){
      $usernameError = "* username is already exists!";
  }
  if(!is_valid_email($email)){
      $emailError = "* email is not valid!";
  }
  if(is_exists_email($email)){
      $emailError = "* email is already exists!";
  }
  if(!is_valid_password($password)){
      $passwordError = "* password is too short!";
  }


  if($usernameError == "" && $emailError=="" && $passwordError==""){
      addUser($role, $username, $email, $password);

      header("Location: ./admin-dashboard.php");
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
  if($userId === $user['id']){
    header("Location: ./logout.php");
    exit();
  }else{
    header("Location: ./admin-dashboard.php");
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
    Role-Management | Admin-Dashboard
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
  require_once('./const/admin-sidebar.php');
  ?>


  <main class="main-content position-relative border-radius-lg ">
    

  
  <?php
  require_once('./const/navbar.php');
  ?>
  


    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Users</p>
                    <h5 class="font-weight-bolder">
                      <?php
                      echo ($nuser+$nadmin+$nmanager);
                      ?>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="fa fa-users" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Admin</p>
                    <h5 class="font-weight-bolder">
                    <?php
                      echo $nadmin;
                      ?>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Manager</p>
                    <h5 class="font-weight-bolder">
                    <?php
                      echo $nmanager;
                      ?>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-badge text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">User</p>
                    <h5 class="font-weight-bolder">
                    <?php
                      echo $nuser;
                      ?>
                    </h5>
                    
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                    <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-6">
                  <h6>Admins</h6>
                </div>
                <div class="col-6 d-flex justify-content-end">
                  <button class="btn badge badge-sm bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#createAdminModal">Create Admin</button>
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
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($admins as $admin){
                      $str = json_encode($admin);
                      if($user['id'] === $admin['id']){
                        echo "<tr class='table-success'>";
                        }else{
                          echo "<tr>";
                        }
                      echo "<td>
                      <div class='d-flex px-2 py-1'>
                        <div class='d-flex flex-column justify-content-center'>
                          <h6 class='mb-0 text-xs text-secondary'>{$admin['username']}</h6>
                        </div>
                      </div>
                    </td>";
                    echo "<td>
                      <h6 class='text-xs text-secondary mb-0'>{$admin['email']}</>
                    </td>";
                    echo "<td class='align-middle text-center text-sm'>
                      <p class='text-xs font-weight-bold mb-0'>{$admin['role']}</p>
                    </td>";
                    echo "<td class='align-middle text-center'>
                      <span class='text-secondary text-xs font-weight-bold'>{$admin['date']}</span>
                    </td>";
                    echo "<td class='align-middle text-center text-sm'>
                        <form method='POST' action=''>";
                        if($user['id'] !== $admin['id']){
                          echo "<button onclick='return passValue(JSON.parse(\"" . addslashes($str) . "\"))' class='btn badge badge-sm bg-gradient-success mb-0' data-bs-toggle='modal' data-bs-target='#editRoleModal'>Edit</button>

                          
                          <input type='hidden' id='userID' name='userId' value='{$admin['id']}'></input>
                          <button name='deleteuser' onclick='return confirmDelete()' class='btn badge badge-sm bg-gradient-danger mb-0'>Delete</button>
                        </form>
                    </td>";
                        }else{
                          echo "<button onclick='return passValue(JSON.parse(\"" . addslashes($str) . "\"))' class='btn badge badge-sm bg-gradient-secondary mb-0' disabled data-bs-toggle='button'>Edit</button>

                          
                          <input type='hidden' id='userID' name='userId' value='{$admin['id']}'></input>
                          <button name='deleteuser' onclick='return confirmDelete()' class='btn badge badge-sm bg-gradient-danger mb-0'>Delete</button>
                        </form>
                    </td>";
                        }
                    echo "</tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
            <div class="row">
                <div class="col-6">
                  <h6>All Users</h6>
                </div>
                <div class="col-6 d-flex justify-content-end">
                  <button class="btn badge badge-sm bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">Create User</button>
                </div>
              </div>
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
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    foreach($users as $eachUser){
                      $str = json_encode($eachUser);
                      if($user['id'] === $eachUser['id']){
                      echo "<tr class='table-success'>";
                      }else{
                        echo "<tr>";
                      }
                      echo "<td>
                      <div class='d-flex px-2 py-1'>
                        <div class='d-flex flex-column justify-content-center'>
                          <h6 class='mb-0 text-xs text-secondary'>{$eachUser['username']}</h6>
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
                      <span class='text-secondary text-xs font-weight-bold'>{$eachUser['date']}</span>
                    </td>";
                    echo "<td class='align-middle text-center text-sm'>
                      <form method='POST' action=''>";
                      if($eachUser['id'] !== $user['id']){
                        echo "<input type='hidden' name='userId' value='{$eachUser['id']}'></input>
                        <button onclick='return passValue(JSON.parse(\"" . addslashes($str) . "\"))' class='btn badge badge-sm bg-gradient-success mb-0' data-bs-toggle='modal' data-bs-target='#editRoleModal'>Edit</button>

                        
                        <input type='hidden' id='userID' name='userId' value='{$eachUser['id']}'></input>
                        <button name='deleteuser' onclick='return confirmDelete()' class='btn badge badge-sm bg-gradient-danger mb-0'>Delete</button>
                      </form>
                    </td>";
                      }else{
                        echo "<input type='hidden' name='userId' value='{$eachUser['id']}'></input>
                        <button onclick='return passValue(JSON.parse(\"" . addslashes($str) . "\"))' class='btn badge badge-sm bg-gradient-secondary mb-0' disabled data-bs-toggle='button' opacity-25>Edit</button>
                        
                        <input type='hidden' id='userID' name='userId' value='{$eachUser['id']}'></input>
                        <button name='deleteuser' onclick='return confirmDelete()' class='btn badge badge-sm bg-gradient-danger mb-0'>Delete</button>
                      </form>
                    </td>";
                      }
                    echo "</tr>";
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



      <footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>



  
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

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
                        <div class="mb-3">
                            <label for="editRole" class="form-label">Role</label>
                            <select class="form-select" id="editRole" name="role" required>
                                <option value="user">User</option>
                                <option value="manager">Manager</option>
                                <!-- <option value="admin">Admin</option> -->
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
                        <button type="submit" class="btn btn-primary" name="addUser">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST" action="<?php $_SERVER['PHP_SELF']?>">
                        <div class="mb-3">
                            <label for="editRole" class="form-label">Role</label>
                            <select class="form-select" id="Role" name="role" required>
                                <option value="user">User</option>
                                <option value="manager">Manager</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="userName" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="Email" name="email" required>
                        </div>
                        <input type="hidden" id="editUserId" name="userId">
                        <button type="submit" class="btn btn-primary" name="saveChanges">Save Changes</button>
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

  <script>
    function logout(){
      window.open("./logout.php");
    }
  </script>
  
</body>

</html>
<?php
session_start();

require_once('./functions.php');

$usernameError = $emailError = $passwordError = "";

if(isset($_SESSION['user'])){
  $user = $_SESSION['user'];

  if($user['role'] === 'admin'){
    header("Location: ./admin-dashboard.php");
  }
  else if($user['role'] === 'user'){
    header("Location: ./user-dashboard.php");
  }else if($user['role'] === 'manager'){
    header("Location: ./manager-dashboard.php");
  }
}


if(isset($_POST['signup'])){
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  if(!is_valid_email($email)){
    $emailError = "* Email is not valid!";
  }
  if(is_exists_email($email)){
    $emailError = "* Email is already exists!";
  }

  if(!is_valid_username($username)){
    $usernameError = "* Username is not valid!";
  }
  if(is_exists_username($username)){
    $usernameError = "* Username is already exists!";
  }

  if(!is_valid_password($password)){
    $passwordError = "* Password is too short!";
  }


  if($usernameError === "" && $emailError === "" && $passwordError === ""){
    registerUser($username,$email,$password);

    header("Location: ./sign-in.php");
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Role-Management | Sign Up
  </title>
  
  <?php
  require_once('./const/linker.php');
  ?>
  
</head>

<body>
  <main class="main-content  mt-0">
    <div class="page-header bg-gradient-primary align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-position: top;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-3">Welcome!</h1>
            <p class="text-lead text-white">Create new account in our <strong>Role Management</strong> project for free.</p>
          </div>
        </div>
      </div>
    </div>  
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header pb-0 text-start">
              <h4 class="font-weight-bolder">Sign Up</h4>
            </div>
            <div class="card-body">
              <form method = "POST" action="<?php $_SERVER['PHP_SELF']?>">
                <div class="mb-3">
                <?php 
                      if($usernameError !== ""){
                        echo "<label for='password' class='text-danger'> $usernameError </label>";
                      }
                      ?>
                  <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" required>
                </div>
                <div class="mb-3">
                <?php 
                      if($emailError !== ""){
                        echo "<label for='password' class='text-danger'> $emailError </label>";
                      }
                      ?>
                  <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" required>
                </div>
                <div class="mb-3">
                <?php 
                      if($passwordError !== ""){
                        echo "<label for='password' class='text-danger'> $passwordError </label>";
                      }
                      ?>
                  <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" required>
                </div>
                <div class="form-check form-check-info text-start">
                  <input class="form-check-input" name="checkbox" type="checkbox" value="" id="flexCheckDefault" checked required>
                  <label class="form-check-label" for="flexCheckDefault">
                    I agree the <a href="#" class="font-weight-bolder condition-link">Terms and Conditions</a>
                  </label>
                </div>
                <div class="text-center">
                  <button type="submit" name="signup" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign up</button>
                </div>
                <p class="text-sm mt-3 mb-0">Already have an account? <a href="./sign-in.php" class="custom-link font-weight-bolder">Sign in</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>


  <footer class="footer py-5">
    <div class="container-fluid bg-gradient-dark p-3 ">
      <div class="row">
        <div class="col-lg-8 mx-auto text-center mb-4 mt-0">
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
            <span class="text-lg fab fa-twitter"></span>
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
            <span class="text-lg fab fa-instagram"></span>
          </a>
          <a href="https://github.com/alemam242" target="_blank" class="text-secondary me-xl-4 me-4">
            <span class="text-lg fab fa-github"></span>
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <?php echo date("Y");?>
          </p>
        </div>
      </div>
    </div>
  </footer>
</body>

</html>
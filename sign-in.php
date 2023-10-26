<?php
session_start();

require_once('./functions.php');

$emailError = $passwordError = $authFailed = "";

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


if(isset($_POST['login'])){
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  if(!is_valid_email($email)){
    $emailError = "* Email is not valid!";
  }
  if(!is_valid_password($password)){
    $passwordError = "* Password is too short!";
  }



  if($emailError === "" && $passwordError === ""){
    $user = authenticateUser($email,$password);
    if($user){
      $_SESSION['user'] = $user;
      header("Location: ./index.php");
    }else {
      $authFailed = "* Invalid email or password";
    }

    // header("Location: ./sign-in.php");
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
    Role-Management | Sign In
  </title>
  
  <?php
  require_once('./const/linker.php');
  ?>
  
</head>

<body class="bg-gradient-primary">
 
  <main class="main-content  mt-0">
    
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row justify-content-md-center">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your email and password to sign in</p>
                </div>
                <div class="card-body">
                  <form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
                    <div class="mb-2">
                    <?php 
                      if($emailError !== ""){
                        echo "<label for='email' class='text-danger'> $emailError </label>";
                      }
                      ?>
                      <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Email" aria-label="Email" required>
                    </div>
                    <div class="mb-3">
                    <?php 
                      if($passwordError !== ""){
                        echo "<label for='password' class='text-danger'> $passwordError </label>";
                      }
                      ?>
                      <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" required>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-check form-switch">
                          <input class="form-check-input" name="checkbox" type="checkbox" id="rememberMe" required>
                          <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                      </div>
                      <div class="col-6 d-flex justify-content-end">
                        <a href="#" class="form-check-label custom-link">Forgot Password?</a>
                      </div>
                    </div>
                    <div class="mt-4">
                      <?php 
                      if($authFailed !== ""){
                      echo "<span class='text-warning text-bold'> $authFailed </span>";
                      }
                      ?>
                    </div>
                    <div class="text-center">
                      <button type="submit" name="login" class="btn btn-lg btn-primary bg-gradient-success btn-lg w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="./sign-up.php" class="text-primary text-gradient font-weight-bold">Sign up</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

</body>

</html>
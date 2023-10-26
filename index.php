<?php
session_start();
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];

    if($user['role'] === 'user'){
        header("Location: ./user-dashboard.php");
    }
    else if($user['role'] === 'manager'){
        header("Location: ./manager-dashboard.php");
    }
    else if($user['role'] === 'admin'){
        header("Location: ./admin-dashboard.php");
    }
}
else{
    header("Location: ./sign-in.php"); 
}
?>




<?php
define("FILENAME", "./const/userDetails.json");
date_default_timezone_set("Asia/Dhaka");

function getAvatar($username){
    $apiUrl = 'https://api.dicebear.com/7.x/micah/png?seed='.$username;

    return $apiUrl;
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    if ($data && isset($data['url'])) {
        $avatarUrl = $data['url'];
        return $avatarUrl;
    } else {
        return "./assets/img/user-avatar.jpg";
    }
}

function is_valid_email($email) {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function is_exists_email($email){
    $users = getUsers();

    foreach($users as &$user){
        if($user['email'] === $email){
            return true;
        }
    }
    return false;
}

function is_valid_username($username) {
    return preg_match('/^[a-zA-Z0-9]{3,20}$/', $username);
}

function is_exists_username($username){
    $users = getUsers();

    foreach($users as &$user){
        if($user['username'] === $username){
            return true;
        }
    }
    return false;
}

function is_valid_password($password){
    return strlen($password)>=4 ? true:false;
}

function registerUser($username, $email, $password){
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $user = [
        'id' => uniqid(),
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'role' => 'user',
        'date' => date("d-m-Y")
    ];

    $users = getUsers();
    $users[] = $user;
    file_put_contents(FILENAME, json_encode($users));
}

function getUsers(){
    if(file_exists(FILENAME)){
        $users = file_get_contents(FILENAME);
        // echo strlen($users);
        if(strlen($users)>0){
        return json_decode($users,true);
        }
        else{
            return [];
        }
    }
    return [];
}

function authenticateUser($email, $password){
    $users = getUsers();
    foreach($users as $user){
        if($user['email'] === $email && $password === $user['password']){
            return $user;
        }
    }
    return null;
}

function editUserRole($userId, $newRole){
    $users = getUsers();
    foreach($users as &$user){
        if($user['id'] === $userId){
            $user['role'] = $newRole;
            break;
        }
    }
    file_put_contents(FILENAME, json_encode($users));
}

function editUser($userId, $username, $email, $role){
    $users = getUsers();
    foreach($users as &$user){
        if($user['id'] === $userId){
            $user['username']=$username;
            $user['email']=$email;
            $user['role'] = $role;
            break;
        }
    }
    file_put_contents(FILENAME, json_encode($users));
}

function editProfile($userId, $username, $email){
    $users = getUsers();
    $newData = [];
    foreach($users as &$user){
        if($user['id'] === $userId){
            $user['username']=$username;
            $user['email']=$email;
            $newData = $user;
            break;
        }
    }
    file_put_contents(FILENAME, json_encode($users));
    return $newData;
}

function deleteUser($userId){
    $users = getUsers();
    foreach($users as $key => $user){
        if($user['id'] === $userId){
            unset($users[$key]);
            break;
        }
    }
    file_put_contents(FILENAME, json_encode($users));
}

function addUser($role,$username, $email, $password){
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $user = [
        'id' => uniqid(),
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'role' => $role,
        'date' => date("d-m-Y")
    ];

    $users = getUsers();
    $users[] = $user;
    file_put_contents(FILENAME, json_encode($users));
}

?>

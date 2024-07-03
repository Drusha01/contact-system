<?php 
require_once '..\..\..\assets\contants\contants.php';
require_once ROOT_PATH.'middleware\isLoggedIn.php';
include_once ROOT_PATH.'assets\database\database.php';
$db = new Database();
if(!isset($_POST['username'])){
    echo 'Username is required';
    return ;
}
if(isset($_POST['confirmpassword'])){
    if(strlen($_POST['confirmpassword']) < 8 ) {
        echo 'confirm password less than 8';
        return;
    }
    elseif(!preg_match("#[0-9]+#",$_POST['confirmpassword'])) {
        echo 'confirm password must contain numbers';
        return;
    }
    elseif(!preg_match("#[A-Z]+#",$_POST['confirmpassword'])) {
        echo 'password must have 1 uppercase letter';
        return;
    }
    elseif(!preg_match("#[a-z]+#",$_POST['confirmpassword'])) {
        echo 'confirm password must have 1 lowercase letter';
        return;
    }
}
if(isset($_POST['password'])){
    if(strlen($_POST['password']) < 8 ) {
        echo 'password less than 8';
        return;
    }
    elseif(!preg_match("#[0-9]+#",$_POST['password'])) {
        echo 'password must contain numbers';
        return;
    }
    elseif(!preg_match("#[A-Z]+#",$_POST['password'])) {
        echo 'password must have 1 uppercase letter';
        return;
    }
    elseif(!preg_match("#[a-z]+#",$_POST['password'])) {
        echo 'password must have 1 lowercase letter';
        return;
    }
}
if($_POST['password'] != $_POST['confirmpassword']){
    echo 'Password doesn\' match';
    return;
}
if(!isset($_POST['email'])){
    echo 'Email is required';
}else{
    $email = $_POST['email'];
    $sql = 'SELECT * FROM users 
        WHERE email =:email
        LIMIT 1 ';
    $query=$db->connect()->prepare($sql);
    $query->bindParam(':email', $email);
    if($query->execute()){
        $data =  $query->fetch();
        if($data){
            echo $email.' exist in the system';
            return ;
        }
    }
}
// insert
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_ARGON2I);
$sql = "INSERT INTO `users`(`id`, `email`, `username`, `password`, `is_active`, `date_created`, `date_updated`) VALUES 
    (NULL,
    :email,
    :username,
    :password,
    1,
    NOW(),
    NOW());";
    $query=$db->connect()->prepare($sql);
    $query->bindParam(':username', $username);
    $query->bindParam(':email', $email);
    $query->bindParam(':password', $password);
    if($query->execute()){
        $sql = 'SELECT * FROM users 
        WHERE email =:email
        LIMIT 1 ';
        $query=$db->connect()->prepare($sql);
        $query->bindParam(':email', $email);
        if($query->execute()){
            $data =  $query->fetch();
            if($data){
                $_SESSION['user_id'] = $data['id'];
            }
        }
        echo '1';
        return ;
    }
?>
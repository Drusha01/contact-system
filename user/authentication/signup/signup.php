<?php 
require_once '..\..\..\assets\contants\contants.php';
require_once ROOT_PATH.'middleware\isLoggedIn.php';
include_once ROOT_PATH.'assets\database\database.php';
$db = new Database();
header('Content-Type: application/json; charset=utf-8');
if(!isset($_POST['username'])){
    echo json_encode(['response'=>'Username is required']);
    return ;
}
if(isset($_POST['password'])){
    if(strlen($_POST['password']) < 8 ) {
        echo json_encode(['response'=>'Password less than 8']);
        return;
    }
    elseif(!preg_match("#[0-9]+#",$_POST['password'])) {
        echo json_encode(['response'=>'Password must contain numbers']);
        return;
    }
    elseif(!preg_match("#[A-Z]+#",$_POST['password'])) {
        echo json_encode(['response'=>'Password must have 1 uppercase letter']);
        return;
    }
    elseif(!preg_match("#[a-z]+#",$_POST['password'])) {
        echo json_encode(['response'=>'Password must have 1 lowercase letter']);
        return;
    }
}
if(isset($_POST['confirmpassword'])){
    if(strlen($_POST['confirmpassword']) < 8 ) {
        echo json_encode(['response'=>'Confirm password less than 8']);
        return;
    }
    elseif(!preg_match("#[0-9]+#",$_POST['confirmpassword'])) {
        echo json_encode(['response'=>'Confirm password must contain numbers']);
        return;
    }
    elseif(!preg_match("#[A-Z]+#",$_POST['confirmpassword'])) {
        echo json_encode(['response'=>'Confirm password must have 1 uppercase letter']);
        return;
    }
    elseif(!preg_match("#[a-z]+#",$_POST['confirmpassword'])) {
        echo json_encode(['response'=>'Confirm password must have 1 lowercase letter']);
        return;
    }
}

if($_POST['password'] != $_POST['confirmpassword']){
    echo json_encode(['response'=>'Password doesn\' match']);
    return;
}
if(!isset($_POST['email'])){
    echo json_encode(['response'=>'Email is required']);
    return;
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
            echo json_encode(['response'=>$email.' exist in the system']);
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
        echo json_encode(['response'=>'1']);
        return ;
    }
?>
<?php
require_once '..\..\..\assets\contants\contants.php';
require_once ROOT_PATH.'middleware\isLoggedIn.php';
include_once ROOT_PATH.'assets\database\database.php';
$db = new Database();
header('Content-Type: application/json; charset=utf-8');
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
            if($data){
                if (password_verify($_POST['password'], $data['password'])) {
                    $_SESSION['user_id'] = $data['id'];
                    echo json_encode(['response'=>'1']);
                    return ;
                }
            }
        }
        echo json_encode(['response'=>'Email or Password is incorrect']);
    }
    return;
}
?>

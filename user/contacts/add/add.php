<?php 
    include_once dirname(__DIR__,3) .'\middleware\isNotLoggedIn.php';
    include_once dirname(__DIR__,3) . '\assets\database\database.php';
    $db = new Database();
    header('Content-Type: application/json; charset=utf-8');


    if(!isset($_POST['name'])){
        echo json_encode(['response'=>'Name is required']);
        return;
    }

    if (strlen($_POST['email'])>0 && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['response'=>'Invalid Email']);
        return;
    }
    $contact = [
        'id' => NULL,
        'user_id' => $_SESSION['user_id'],
        'name' => $_POST['name'],
        'company' => $_POST['company'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
    ];


    try{
        $sql = "INSERT INTO `contacts`(`id`, `user_id`, `name`, `company`, `phone`, `email`, `is_active`, `date_created`, `date_updated`) VALUES 
            (NULL,
            :user_id,
            :name,
            :company,
            :phone,
            :email,
            1,
            NOW(),
            NOW())";
        $query=$db->connect()->prepare($sql);
        $query->bindParam(':user_id', $contact['user_id']);
        $query->bindParam(':name', $contact['name']);
        $query->bindParam(':company', $contact['company']);
        $query->bindParam(':phone', $contact['phone']);
        $query->bindParam(':email', $contact['email']);
        $result = $query->execute();
        if($result){
            echo json_encode(['response'=>'1']);
            return ;
        }else{
            echo json_encode(['response'=>'Error data insert']);
            return ;
        }
    }catch (PDOException $e){
        return false;
    }
?>
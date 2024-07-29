<?php 
    include_once dirname(__DIR__,3) .'\middleware\isNotLoggedIn.php';
    include_once dirname(__DIR__,3) . '\assets\database\database.php';
    $db = new Database();
    header('Content-Type: application/json; charset=utf-8');


    if(!isset($_POST['id'])){
        echo json_encode(['response'=>'Id is required']);
        return;
    }
    $contact = [
        'id' => $_POST['id'],
        'user_id' => $_SESSION['user_id'],
        'name' => NULL,
        'company' => NULL,
        'phone' => NULL,
        'email' => NULL,
    ];

    try{
        $sql = "DELETE FROM `contacts` WHERE 
            id= :id AND user_id = :user_id";
        $query=$db->connect()->prepare($sql);
        $query->bindParam(':user_id', $contact['user_id']);
        $query->bindParam(':id', $contact['id']);
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
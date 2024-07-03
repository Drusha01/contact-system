<?php 
    session_start();
    if(isset($_SESSION['user_id'])){
        return header('location:\user\contact\index.php');
    }else{
    }
    


?>
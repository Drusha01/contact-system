<?php 
    session_start();
    if(isset($_SESSION['user_id'])){

    }else{
        return header('location:\user\authentication\login');
    }
?>
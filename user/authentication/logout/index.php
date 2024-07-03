<?php
    session_start();
    session_destroy();
    require_once '..\..\..\assets\contants\contants.php';
    require_once ROOT_PATH.'middleware\isNotLoggedIn.php';
?>
<?php 
    session_start();
    if (isset ($_GET['Logout'])){
        session_destroy();
        //unset($_SESSION['User']);
        header("location:../../index.html");
    }
     
?>
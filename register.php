<?php
require_once 'partial/header.php';



if(isset($_POST['register'])){
    echo $user->register($_POST);
}
if(isset($_SESSION['loggedIn'])){
    if($_SESSION['loggedIn']){
        header("Location: admin.php");
    }
}

?>


    <form method='post'>
        username:<input type="text" name="username">
        password:<input type="password" name="password">
        password conf:<input type="password" name="password-conf">
        <input type="submit" name="register" value="Register">
    </form>
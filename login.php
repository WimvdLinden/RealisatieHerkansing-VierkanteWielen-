<?php
require_once 'partials/header.php';

if(isset($_POST['login'])){
    echo $user->login($_POST);
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
        <input type="submit" name="login" value="Login">
    </form>

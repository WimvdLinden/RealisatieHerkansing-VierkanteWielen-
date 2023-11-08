<?php
require_once 'dbconfig.php';


class User extends dbconfig{

    function __construct(){

    }

    public function register($data){
        try{
            $username = $data['username'];
            $password = $data['password'];
            $passwordConf = $data['password-conf'];

            if($password != $passwordConf){
                throw new Exception("Wachtwoord verkeers");
            }

            $password = password_hash($password, PASSWORD_BCRYPT, ["cost"=> 12]);


            $sql = "INSERT INTO users (username, password, role)
            VALUES (:username, :password, 1)";

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            if(!$stmt->execute()){
                throw new Exception("Account couldnt be made. User already exists");
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function login($data){
    try{
        $username = $data['username'];
        $password = $data['password'];

        $sql = "SELECT * FROM users WHERE username = :username";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":username", $username);
        $results = $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);



        if(empty($user)) {
            throw new Exception("Wachtwoord wachtwoord verkeers");
        }

        if(password_verify($password, $user->password)){
            session_start();


            $_SESSION['role'] = $user->role;
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $user->username;
            $_SESSION['id'] = $user->id;

            if($_SESSION['role'] == 1){
              header("Location: admin.php");
            }else if($_SESSION['role'] ==2){
              header("Loaction: index.php");
            }
        }else{
            throw new Exception("Wachtwoord niet goed");
        }
    }catch(Exception $e){
       return $e->getMessage();
    }
    }

    public function logout(){
        $_SESSION = null;
        session_destroy();
        header("Location:index.php");
    }

}


?>

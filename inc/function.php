<?php
    function debug($var){
        echo "<pre>" . print_r($var,true) . "</pre>";
    }
    
    function str_random($length){
        $alphabet ="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        return substr( str_shuffle(str_repeat($alphabet , $length)) , 0, $length );
    }

    function logged_only(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['auth'])){
            $_SESSION['flash']['danger'] = "vous n'avez pas de le droit d'acceder a cette page";
            header("Location: login.php");
            exit();
        }
    }

    function reconnect_cookie(){

        require_once "db.php";

        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }

        if(!isset($con)){
            global  $con;
        }

        if(!isset($_SESSION['auth']) && isset($_COOKIE['remember'])){
            $remember_token = $_COOKIE['remember'];
            $parts = explode('==' , $remember_token);
            $user_id = $parts[0];
            $sql = $con->prepare("SELECT * FROM tp_users WHERE id = ? ");
            $sql->execute([$user_id]);
            $user = $sql->fetch();
            if($user){
                $expected = $user_id . "==" . $user->remember_token . sha1($user_id . $user->remember_token );
                if($expected == $remember_token){
                    $_SESSION['auth'] = $user;
                    setcookie('remember' ,  $remember_token , time() + 60 * 60 * 24 * 7 );
                }else{
                    setcookie('remember' , NULL , -1);
                }
            }else{
                setcookie('remember' , NULL , -1);
            }
        }
    }
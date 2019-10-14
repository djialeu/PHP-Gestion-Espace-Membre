<?php
    
    session_start();    
    require_once "inc/db.php";

    $user_id = $_GET['id'];
    $token = $_GET['token'];

    $sql = $con->prepare('SELECT * FROM tp_users WHERE id=?');
    $sql->execute([$user_id]);
    $user = $sql->fetch();

    if($user && $user->confirmation_token == $token){
        $result =  $con->prepare("UPDATE tp_users SET confirmation_token = NULL  , confirmed_at = NOW() WHERE id = ?")->execute([$user_id]);
        $_SESSION['flash']['success'] = "Votre compte a bien ete valide";
        $_SESSION['auth'] = $user;
        header('Location: account.php');
    }else{
        $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
        header('Location: login.php');
    }

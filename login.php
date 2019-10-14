<?php
    require_once "inc/function.php";
    require_once "inc/db.php";
    reconnect_cookie();
    if(isset($_SESSION['auth'])){
        header('Location: account.php');
        exit();
    }

    if(!isset($con)){
        global $con;
    }

    if(isset($_POST['send']) && !empty($_POST['name']) && !empty($_POST['password'])){
        $sql = $con->prepare("SELECT * FROM tp_users WHERE u_name =? OR email =? AND confirmed_at IS NOT NULL ");
        $sql->execute([$_POST['name'] , $_POST['name'] ]);
        $user = $sql->fetch();
        if(password_verify($_POST['password'] , $user->u_password)){
            $_SESSION['auth'] = $user;
            $_SESSION['flash']['success'] = 'Vous etes maintenant connecte';

            if($_POST['remember']){
                $remember_token = str_random(250);
                $con->prepare("UPDATE tp_users SET remember_token = ? WHERE id= ?")->execute([$remember_token , $user->id]);
                setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . $remember_token ) , time() + 60 * 60 * 24 * 7 );
            }
            header('Location: account.php');
            exit();
        }else{
            $_SESSION['flash']['danger'] = "Identifiant ou mot de passe incorrect";
        }

    }
?>

<?php

include 'inc/header.php';
?>

<h1 xmlns="http://www.w3.org/1999/html"> Connexion </h1>

<form action="" method="POST" >
    <div class="form-group" style=" margin: 30px; ">
        <label for=""> Pseudo ou email</label>
        <input type="text" name="name" class="form-control" required autofocus>
    </div>
    <div class="form-group" style=" margin: 30px; ">
        <label for=""> Mot de passe <a href="forget.php" class="nav-fill"> (Mot de passe oublie) </a> </label>
        <input type="password" name="password"  class="form-control" required autofocus>
    </div>

    <div class="form-group" style=" margin: 30px; ">
        <label class="form-check-label"> <input type="checkbox" name="remember" id="" value="1"/> Se souvenir de moi </label>
    </div>

    <div style=" text-align: center; " >
        <button type="submit" class="btn btn-primary" name="send" style=" height:50px; width:150px; "> <h3> Login </h3> </button>
    </div>
</form>


<?php
    include 'inc/footer.php';
?>
<?php
    if (isset($_GET['id']) && isset($_GET['token'])){
        require_once "inc/db.php";
        require_once "inc/function.php";
        $sql = $con->prepare("SELECT * FROM tp_users WHERE id=? AND reset_token IS NOT NULL AND reset_token = ?  AND reset_at > DATE_SUB(NOW() , INTERVAL 30 MINUTE )");
        $sql->execute([$_GET['id'] , $_GET['token']]);
        $user = $sql->fetch();
        if($user){
            if(isset($_POST['send']) && !empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm'] ){
                $password =  password_hash($_POST['password'] , PASSWORD_BCRYPT);
                $sql = $con->prepare("UPDATE tp_users SET u_password = ? , reset_at = NULL , reset_token = NULL")->execute([$password]);
                session_start();
                $_SESSION['flash']['success'] = "votre mot de passe a bien ete mofifie";
                $_SESSION['auth']  = $user;
                header("Location: account.php");
            }
        }else{
            session_start();
            $_SESSION['flash']['danger']  = "ce token n'est pas valide";
            header('Location: Login.php');
            exit();
        }
    }else{
        header('Location: Login.php');
        exit();
    }
?>
<?php include 'inc/header.php'; ?>


<h1> Reinitialisation mot de passe </h1>

<form action="" method="post">

    <div class="form-group" style="margin: 30px;">
        <label for="" class=""> Mot de Passe </label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="form-group" style="margin: 30px;">
        <label for="" class=""> Confirmation du mot de Passe </label>
        <input type="password" name="password_confirm" class="form-control">
    </div>

    <div style="text-align: center">
        <button class="btn btn-primary" name="send" type="submit" style=" height:5%; width:35%; " > <h3> Reinitialiser votre mot de passe </h3>  </button>
    </div>
</form>
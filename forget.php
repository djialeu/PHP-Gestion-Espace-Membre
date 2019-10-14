<?php
    session_start();
    include 'inc/header.php';
    require_once "inc/db.php";
    require_once "inc/function.php";
?>

<?php
if(isset($_POST['send']) && !empty($_POST['email'])){
    $sql = $con->prepare("SELECT * FROM tp_users WHERE email =? AND confirmed_at IS NOT NULL ");
    $sql->execute([ $_POST['email'] ]);
    $user = $sql->fetch();
    if($user){
        $reset_token = str_random(60);
        $con->prepare("UPDATE tp_users SET reset_token= ? , reset_at = NOW() WHERE id=?")->execute([$reset_token , $user->id]);
        $_SESSION['flash']['success'] = 'Les instructions du rappel de mot de passe vous ont ete envoyes par email';
        /*mail($_POST['mail'] , 'Reinitialisation de votre mot de passe' , "Afin de reinitialiser votre mot de passe veuillez s'il vous plait cliquer sur le lien ci dessous \n\n http://localhost/php/PHP%20Gestion%20Espace%20Membre/reset.php?id={$user->id}&token=$reset_token");*/
        header("Location: reset.php?id={$user->id}&token=$reset_token");
        //header('Location: login.php');
        exit();
    }else{
        $_SESSION['flash']['danger'] = "Aucun compte ne correspond a cette adresse";
    }

}
?>

    <h1> Mot de passe oublie </h1>

    <form action="" method="POST" >
        <div class="form-group" style=" margin: 30px; ">
            <label for=""> Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>
        <div style=" text-align: center; " >
            <button type="submit" class="btn btn-primary" name="send" style=" height:50px; width:150px; "> <h3> Login </h3> </button>
        </div>
    </form>


<?php
    include 'inc/footer.php';
?>
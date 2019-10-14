<?php require_once "inc/function.php"; ?>
<?php require_once "inc/db.php"; ?>

<?php

	if(isset($_POST['send'])){
		$error = array();
		if(empty($_POST['name']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['name'])){
			$error['name'] = "Pseudo non valide (caracteres alphanumerique uniquement)";
		}else{
			$sql = $con->prepare("SELECT id FROM tp_users WHERE u_name = ? ");
			$sql->execute([$_POST['name']]);
			$users = $sql->fetch();
			if($users){
				$error['name'] = "Pseudo indisponible";
			}
		}

		if(empty($_POST['mail']) || !filter_var($_POST['mail'] , FILTER_VALIDATE_EMAIL)){
			$error['email'] = "Email non valide";
		}else{
			$sql = $con->prepare("SELECT id FROM tp_users WHERE email = ? ");
			$sql->execute([$_POST['mail']]);
			$mails = $sql->fetch();
			if($mails){
				$error['email'] = "Email indisponible";
			}
		}

		if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
			$error['password'] = "vous devez entrer un mot de passe valide";
		}

		debug($error);

		if(empty($error)){	
		
			$sql =  $con->prepare("INSERT INTO tp_users (u_name , email , u_password , confirmation_token ) VALUES ( ? , ? , ? , ? )");
			$pwd = password_hash($_POST['password'] , PASSWORD_BCRYPT);
			$token = str_random(60);
			$sql->execute([$_POST['name'] , $_POST['mail'] , $pwd ,$token]);
			$user_id = $con->lastInsertId();
			/*mail($_POST['mail'] , 'Confirmation de votre compte' , "Afin de valider votre compte veuillez s'il vous plait cliquer sur le lien suivant \n\n http://localhost/php/PHP%20Gestion%20Espace%20Membre/confirm.php?id=$user_id&token=$token")*/
			$_SESSION['flash']['success']= 'un email de confirmation vous ete envoye';
            header("Location: confirm.php?id=$user_id&token=$token");
            //header("Location: login.php");
		}
	}

	
	
?>

<?php include "inc/header.php"; ?>

</br></br></br>
 <u><h1 style=" padding:20px; text-align: center; font-size:100px; "> INSCRIPTION </h1></u>

<form action="" method="POST" >
	<div class="form-group" style=" margin: 30px; ">
		<label for=""> Pseudo</label>
		<input type="text" name="name" class="form-control" required autofocus>
	</div>
	<div class="form-group" style=" margin: 30px; " >
		<label for=""> Email</label>
		<input type="email" name="mail"  class="form-control" required autofocus>
	</div>
	<div class="form-group" style=" margin: 30px; ">
		<label for=""> Mot de passe</label>
		<input type="password" name="password"  class="form-control" required autofocus>
	</div>
	<div class="form-group" style=" margin: 30px; ">
		<label for=""> Confirmer Votre mot de passe</label>
		<input type="password" name="password_confirm"  class="form-control" required autofocus>
	</div>
	<div style=" text-align: center; " >
		<button type="submit" class="btn btn-primary" name="send" style=" height:50px; width:150px; "> <h3> Register </h3> </button>
	</div>
</form>

<?php include "inc/footer.php";?>
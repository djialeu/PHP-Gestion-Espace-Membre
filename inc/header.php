<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Advanced test PHP</title>


  <!-- Theme CSS - Includes Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  	
    <a class="navbar-brand" href="index.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
          <?php if(isset($_SESSION['auth'])): ?>
              <li class="nav-item">
                  <a href="account.php" class="nav-link"> Mon compte </a>
              </li>
              <li class="nav-item">
                  <a href="logout.php" class="nav-link"> Se deconnecter </a>
              </li>
          <?php else: ?>
              <li class="nav-item active">
                  <a class="nav-link" href="register.php">S'inscrire<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="login.php">Se Connecter</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Aide</a>
              </li>
          <?php endif; ?>
      </ul>

       <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
  </div>
</nav>

<?php if(isset($_SESSION['flash'])):?>
    <?php foreach ($_SESSION['flash'] as $type => $message ): ?>
    <div class="alert alert-<?= $type ?>">
        <?= $message; ?>
    </div>
    <?php endforeach; ?>
    <?php unset($_SESSION['flash']) ?>
<?php endif; ?>


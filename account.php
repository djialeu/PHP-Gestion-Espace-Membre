<?php
    include 'inc/header.php';
    require_once 'inc/function.php';
    reconnect_cookie();
?>

<?php
    logged_only();
?>

<?php debug($_SESSION); ?>

<h1> Bonjour <?= $_SESSION['auth']->u_name ?> </h1>



<?php
    include 'inc/footer.php';
?>
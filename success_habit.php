<?php
/* Viser alle vellykkede meldinger for en registrert habit - Denne lar brukeren gå tilbake til profilen */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Success</title>
  <?php include 'css/css.html'; ?>
</head>
<body>
<div class="form">
    <h1><?php 'Vellykket'; ?></h1>
    <p>
    <?php
        if ( isset($_SESSION['melding']) AND !empty($_SESSION['melding']) ) {
          echo $_SESSION['melding'];
        }
        else {
          header ( "location: index.php");
        }
    ?>
    </p>
    <a href="profile.php"><button class="button button-block"/>Tilbake</button></a>
</div>
</body>
</html>

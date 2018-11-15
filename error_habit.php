<?php
/* Viser alle feilmeldinger */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Feil</title>
  <?php include 'css/css.html'; ?>
</head>
<body>
<div class="form">
    <h1>Feil</h1>
    <p>
    <?php
        if ( isset($_SESSION['melding']) AND !empty($_SESSION['melding']) ) {
          echo $_SESSION['melding'];
        }
          else {
            header( "location: index.php");
          }
    ?>
    </p>
    <a href="profile.php"><button class="button button-block"/>Tilbake til profilen</button></a>
</div>
</body>
</html>

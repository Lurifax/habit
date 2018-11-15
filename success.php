<?php
/* Viser alle vellykkede meldinger */
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
    <a href="index.php"><button class="button button-block"/>Home</button></a>
</div>
</body>
</html>

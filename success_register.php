<?php
ob_start();
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
    ob_start();
    session_start();
        if ( isset($_SESSION['melding']) AND !empty($_SESSION['melding']) ) {
          echo $_SESSION['melding'];
        }
        else {
          header ( "location: index.php");
        }
        ob_end_flush();
    ?>
    </p>
    <a href="index.php"><button class="button button-block"/>Logg inn</button></a>
</div>
</body>
</html>

<?php
/* ----------------------------------- */
/* Logger ut, unset og destroy session */
/* -----------------------------------*/
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Logg ut</title>
  <?php include 'css/css.html'; ?>
</head>
<!-- Gir melding her til brukeren at bruker er logget ut -->
<body>
    <div class="form">
          <h1>Habit</h1>

          <p><?= 'Du er logget ut'; ?></p>

          <a href="index.php"><button class="button button-block"/>Hjem</button></a>

    </div>
</body>
</html>

<?php
/*
   Tilbakestilling av passord. Linken til denne siden er fra eposten sendt i forgot.php
*/

require 'db.php';
session_start();

//Sjekker at epost og hash variabel ikke er bind_textdomain_codeset
if ( isset($_GET['epost']) && !empty($_GET['epost']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
  $epost = $mysqli->escape_string($_GET['epost']);
  $hash = $mysqli->escape_string($_GET['hash']);

  // Sjekker at epost med matchende hash eksisterer
  $resultat = $mysqli->query("SELECT * FROM users WHERE epost='$epost' AND hash='$HASH'");

  if ( $resultat->num_rows == 0)
  {
    $_SESSION['melding'] = "Du har skrevet en ugyldig URL for tilbakestilling av passord";
    header("location: error.php");
  }
}
else {
  $_SESSION['melding'] = "Tilbakestilling av passord feilet, pr".&Oslash."v igjen";
  header("location: error.php");
}
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Tilbakestill passord</title>
  <?php include 'css/css.html'; ?>
</head>

<body>
    <div class="form">

          <h1>Velg ditt nye passord</h1>

          <form action="reset_password.php" method="post">

          <div class="field-wrap">
            <label>
              Nytt passord<span class="req">*</span>
            </label>
            <input type="password"required name="newpassword" autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>
              Bekreft nytt passord<span class="req">*</span>
            </label>
            <input type="password"required name="confirmpassword" autocomplete="off"/>
          </div>

          <!-- Inputfelt trengs her for å få epost av brukeren -->
          <input type="hidden" name="email" value="<?= $_GET['email'] ?>">

          <button class="button button-block"/>Endre passord</button>

          </form>

    </div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>

</body>
</html>

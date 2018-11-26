<?php
session_start();
/*
   Tilbakestilling av passord. Linken til denne siden er fra eposten sendt i forgot.php
*/
require_once('./includes/dbconnect.php');
//Sjekker at epost og hash variabel ikke er bind_textdomain_codeset
if ( isset($_GET['epost']) && !empty($_GET['epost']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
  $epost = $connection->escape_string($_GET['epost']);
  $hash = $connection->escape_string($_GET['hash']);
  $id = $connection->escape_string($_GET['id']);

  // Sjekker at epost med matchende hash eksisterer
  $resultat = $connection->query("SELECT * FROM user WHERE epost='$epost' AND hash='$hash'");

  if ( $resultat->num_rows == 0)
  {
    $_SESSION['melding'] = "Du har skrevet en ugyldig URL for tilbakestilling av passord";
    header("location: error.php");
  }
} else {
  $_SESSION['melding'] = "Noe gikk galt!";
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
            <input type="password" required minlength="8" id="nyttpassord" autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>
              Bekreft nytt passord<span class="req">*</span>
            </label>
            <input type="password" required minlength="8" id="bekreftpassord" autocomplete="off" onkeyup="check();"/>
          </div>
          <span id="melding"></span>

          <!-- Inputfelt trengs her for å få epost av brukeren -->
          <input type="hidden" name="epost" value="<?php echo $epost?>">
          <input type="hidden" name="hash" value="<?php echo $hash ?>">
          <input type="hidden" name="id" value="<?php echo $id ?>">

          <input type="submit" class="button button-block" name="reset" value="Endre passord"/>

          </form>

    </div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
<script src="js/comparePw.js"></script>

</body>
</html>

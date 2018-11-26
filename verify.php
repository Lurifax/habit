<?php
header('application/x-www-form-urlencoded');
/* bekrefter brukerens epost, linken til denne siden
   er inkludert i register.php siden*/
session_start();
require_once('./includes/dbconnect.php');
// Sjekker at epost og hash variabler ikke er tomme
if(isset($_GET['epost']) && !empty($_GET['epost']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
  $epost = $connection->escape_string($_GET['epost']);
  $hash = $connection->escape_string($_GET['hash']);
  //Selecter bruker med tilsvarende epost og hash som ikke har aktivert kontoen (aktiv = 0)
  $resultat = $connection->query("SELECT * FROM user WHERE epost='$epost' AND hash='$hash' AND aktiv='0';");

  if ($resultat->num_rows == 0)
  {
    $_SESSION['melding'] = "Konto er allerede aktivert eller URL er ugyldig";
    header("location: error.php");
  }
  else {
    $_SESSION['melding'] = "Din konto er nå aktivert";
    //Setter brukerens konto til aktivert (aktiv = 1)
    $connection->query("UPDATE user SET aktiv='1' WHERE epost='$epost'");
    $_SESSION['aktiv'] = 1;
    header("location: success.php");
  }
}

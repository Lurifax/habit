<?php
/* Verifies registered user email, the link to this page
   is included in the register.php email message
*/
require 'db.php';
session_start();

// Sjekker at epost og hash variabler ikke er tomme
if(isset($_GET['epost']) && !empty($_GET['epost']) AND isset($_GET['hash']) && !empty($_GET['hash']))
{

  $epost = $mysqli->escape_string($_GET['epost']);
  $hash = $mysqli->escape_string($_GET['hash']);

  //Selecter bruker med tilsvarende epost og hash som ikke har aktivert kontoen (aktiv = 0)
  $resultat = $mysqli->query("SELECT * FROM users WHERE epost='$epost' and hash='$hash' AND aktiv='0'");

  if ( $resultat->num_rows == 0)
  {
    $_SESSION['melding'] = "Konto er allerede aktivert eller URL er ugyldig";

    header("location: error.php");
  }
  else {
    $_SESSION['melding'] = "Din konto er nå aktivert";

    //Setter brukerens konto til aktivert (aktiv = 1)
    $mysqli->query("UPDATE users SET aktiv='1' WHERE epost='$epost'") or die($mysqli->error);
    $_SESSION['active'] = 1;

    header("location: success.php");
  }
}

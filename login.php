<?php
/* Sjekker om brukeren finnes og om passord er gyldig */
//require 'db.php';

//Benytter escape for å beskytte mot SQL_injection
$epost = $mysqli->escape_string($_POST['epost']);

$resultat = $mysqli->query("SELECT * FROM user where epost='$epost'");

if ( $resultat->num_rows == 0) { //Brukeren eksisterer ikke
  $_SESSION['melding'] = "Bruker med denne eposten eksisterer ikke.";
  header("location: error.php");
}
else { //Brukeren eksisterer
  $bruker = $resultat->fetch_assoc();

  if ( password_verify($_POST['passord'], $bruker['passord']) ) {

    $_SESSION['id'] = $bruker['id'];
    $_SESSION['epost'] = $bruker['epost'];
    $_SESSION['fornavn'] = $bruker['fornavn'];
    $_SESSION['etternavn'] = $bruker['etternavn'];
    $_SESSION['aktiv'] = $bruker['aktiv'];

    //Her vet vi om brukeren er logget inn
    $_SESSION['loggetInn'] = true;

    header("location: profile.php");
  }
  else {
    $_SESSION['melding'] = "Du har skrevet inn feil passord, prøv igjen";
    header("location: error.php");
  }
}

?>

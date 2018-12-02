<?php
ob_start();
session_start();
require_once('./includes/dbconnect.php');

/*
   Registreringprosess, oppretter brukerinformasjon i databasen og sender
   aktiveringslenke til epost brukeren har benyttet.
 */

 //Setter session variabler for bruk i profile.php
$_SESSION['epost'] = $_POST['epost'];
$_SESSION['fornavn'] = $_POST['fornavn'];
$_SESSION['etternavn'] = $_POST['etternavn'];

// Benytter escape for å beskytte mot SQL injection
$fornavn = $connection->escape_string($_POST['fornavn']);
$etternavn = $connection->escape_string($_POST['etternavn']);
$epost = $connection->escape_string($_POST['epost']);
$passord = $connection->escape_string(password_hash($_POST['passord'], PASSWORD_DEFAULT));
$hash = $connection->escape_string( password_hash(rand(0,1000), PASSWORD_DEFAULT));


//Sjekker om bruker med epost allerede finnes i basename
$resultat = $connection->query("SELECT * FROM user where epost='$epost'");

//Brukeren finnes fra før hvis rader er større enn 0 og gir da melding om det.
if ( $resultat->num_rows == 1 ) {

  $_SESSION['melding'] = 'Epost er allerede registrert.';
  header("location: error.php");

}
else { //Epost er ikke registrert fra før, fortsetter å opprette brukeren

  //SQL for bruk til insert i tabellen 'user'. Aktiv kolonne er default 0 i tabellen user
  $sql = "INSERT INTO user (fornavn, etternavn, epost, passord, hash) "
          . "VALUES ('$fornavn', '$etternavn', '$epost', '$passord', '$hash')";

//Legger inn brukeren i databasen
if ( $connection->query($sql)){

  $_SESSION['aktiv'] = 0; // Verdien er 0 inntil brukeren klikker på tilsendt aktiveringslenke
  $_SESSION['loggetInn'] = true; // Slik at vi vet brukeren er logget inn
  $_SESSION['melding'] =
      "Aktiveringslenke er sendt til $epost, vennligst følg instruksen i mail for å aktivere brukerkontoen din.";
      //Sender aktiveringslenke (verify.php)
      $til    = $epost;
      $emne   = "Takk for din registering hos Habit, vennligst aktiver din konto";
      $melding    ='
      Hei ' . $fornavn .',

      Takk for at du registrerte deg på Habit.

      Klikk på aktiveringslenken under for å aktivere din brukerkonto:

        https://stianalexanderolsen.com/habit/verify.php?epost='.$epost.'&hash='.$hash;

        mail( $til, $emne, $melding );

        header("location: success_register.php");
}

else { //Dersom registreringen feiler vil det gis feilmelding
  $_SESSION['melding'] = 'Registering av din bruker mislyktes, prøv igjen';
  header("location: error.php");
  }
}
ob_end_flush();
?>

<?php
/*
   Registreringprosess, oppretter brukerinformasjon i databasen og sender
   aktiveringslenke til epost brukeren har benyttet.
 */

 //Setter session variabler for bruk i profile.php
$_SESSION['epost'] = $_POST['epost'];
$_SESSION['fornavn'] = $_POST['fornavn'];
$_SESSION['etternavn'] = $_POST['etternavn'];

// Benytter escape for å beskytte mot SQL injection
$fornavn = $mysqli->escape_string($_POST['fornavn']);
$etternavn = $mysqli->escape_string($_POST['etternavn']);
$epost = $mysqli->escape_string($_POST['epost']);
$passord = $mysqli->escape_string(password_hash($_POST['passord'], PASSWORD_DEFAULT));
$hash = $mysqli->escape_string( password_hash(rand(0,1000), PASSWORD_DEFAULT));


//Sjekker om bruker med epost allerede finnes i basename
$resultat = $mysqli->query("SELECT * FROM users where epost='$epost'") or die($mysqli->error());

//Brukeren finnes fra før hvis rader er større enn 0
if ( $result->num_rows > 0 ) {

  $_SESSION['melding'] = 'Epost er allerede registrert.';
  header("location: error.php");

}
else { //Epost er ikke registrert fra før, fortsetter å opprette brukeren

  //SQL for bruk til insert i tabellen 'users'. Aktiv kolonne er default 0 i tabellen users
  $sql = "INSERT INTO users (fornavn, etternavn, epost, passord, hash) "
          . "VALUES ('$fornavn', '$etternavn', '$epost', '$passord', '$hash')";

//Legger inn brukeren i databasen
if ( $mysqli->query($sql)){

  $_SESSION['aktiv'] = 0; // Verdien er 0 inntil brukeren klikker på tilsendt aktiveringslenke
  $_SESSION['loggetInn'] = true; // Slik at vi vet brukeren er logget inntil
  $_SESSION['melding'] =

      "Aktiveringslenke er sendt til $epost, vennligst følg instruksen i mail for å aktivere brukerkontoen din";

      //Sender aktiveringslenke (verify.php)
      $til    = $epost;
      $emne   = "Takk for din registering hos Habit, vennligst aktiver din konto";
      $melding    ='
      Hei ' . $fornavn .',

      Takk for at du registrerte deg på habit.

      Klikk på aktiveringslenken under for å aktivere din brukerkonto:

        http://localhost/prosjekt/verify.php?email='.$epost.'&hash='.$hash;

        mail( $til, $emne, $melding );

        header("location: profile.php");
}

else {
  $_SESSION['melding'] = 'Registering av din bruker mislyktes, prøv igjen';
  header("location: error.php");
  }
}

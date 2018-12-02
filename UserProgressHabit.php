<?php
session_start();
require ('./includes/dbconnect.php');

//Sjekker om brukeren er logget inn
if ( $_SESSION['loggetInn'] != 1) {
  $_SESSION['melding'] = "Logg inn for å se profilen din";
  header("location: error.php");
}
else {

$userId = $_SESSION['id'];
$fornavn = $_SESSION['fornavn'];
//lager spørring her mot arktivtabellen som har alle utførte habits
$resultat = $connection->query("SELECT * FROM archiveuserhabit WHERE userid = $userId");
$day = strtolower(date('l'));
}

//Bruker her switch-case for å endre fra engelsk til norsk dersom det er tilfellet
switch ($day) {
  case "monday":
    $day = "mandag";
    break;
  case "tuesday":
    $day = "tirsdag";
    break;
  case "wednesday":
    $day = "onsdag";
    break;
  case "thursday":
    $day = "torsdag";
    break;
  case "friday":
    $day = "fredag";
    break;
  case "saturday":
    $day = "lørdag";
    break;
  case "sunday":
    $day = "søndag";
    break;
}

// Sjekker her om det er noen habits registrert på brukeren som er utført, hvis ikke skrives det til bruker
if ($resultat->num_rows == 0) {
  echo "Ingen habits registrert eller utført. Opprett og utfør habits for å se din progresjon.";

// Hvis det er registrert habits på brukeren som er utført skrives disse ut i en tabell
} else {

$alleUtførteHabits = $connection->query("SELECT DISTINCT habitid, isDone, userid, habitname from archiveuserhabit where isDone = 1 and userid = $userId;");
  echo "<h2>Habitprogresjon for " . ucfirst($fornavn) . "</h2>";
  echo "<h3>Her ser du dine utførte habits.</h3>";
  echo "<h3>Du ser også hvilket endringsnivå du er på for habitene.</h3>";
  echo "<h3>Selv om du sletter aktive habits vil alle utførte habits lagres her.</h3>";
  echo "<table border='1'>
  <tr>
  <th>Habit</th>
  <th>Antall utført</th>
  <th>Endringsnivå</th>
  </tr>";

// Lager her oversikten i en tabell med utførte habits
// Viser her hvor mange ganger brukeren har utført habits. Dette hentes fra arkivtabellen.
  while($row = mysqli_fetch_array($alleUtførteHabits)) {
    $habitNavn = $row['habitname'];
    $antallUtført = $connection->query("SELECT COUNT(isDone) as total from archiveuserhabit where habitname = '$habitNavn' and userid = $userId");
    $antResultat = mysqli_fetch_assoc($antallUtført);
    echo "<tr>";
    echo "<td>" . $habitNavn . "</td>";
    echo "<td>" . $antResultat['total'] . "</td>";
    //Lager her en visning av hvor stort endringsnivået er ut fra hvor mange ganger man har utført en habit iløpet av en uke
    if ($antResultat['total'] > 4){
      echo "<td>Meget høyt</td>";
    }

    elseif($antResultat['total'] > 3) {
      echo "<td>Høyt</td>";
    }

    elseif($antResultat['total'] > 2) {
      echo "<td>Middels</td>";
    }

    elseif($antResultat['total'] > 1) {
      echo "<td>Lavt</td>";
    }

    elseif($antResultat['total'] > 0) {
      echo "<td>Meget lavt</td>";
    }

    echo "</tr>";
  }

  echo "</table>";
}
?>

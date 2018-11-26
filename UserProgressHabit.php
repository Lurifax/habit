<?php
session_start();
require_once('./includes/dbconnect.php');

$userId = $_SESSION['id'];
$fornavn = $_SESSION['fornavn'];
$resultat = $connection->query("SELECT * FROM archiveuserhabit WHERE userid = $userId");
$day = strtolower(date('l'));

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

// Sjekker her om det er noen habits registrert på brukeren, hvis ikke skrives det til bruker
if ($resultat->num_rows == 0) {
  echo "Ingen habits registrert eller utført. Opprett og utfør habits for å se din progresjon.";

// Hvis det er registrert habits på brukeren skrives alle disse ut
} else {
//$dagensHabits = $connection->query("SELECT userhabit.habitid, userhabit.day, habit.id, habit.name from userhabit inner JOIN habit on userhabit.habitid=habit.id where userhabit.userid = $userId");
$alleUtførteHabits = $connection->query("SELECT archiveuserhabit.habitid, archiveuserhabit.day, archiveuserhabit.isDone, habit.id, habit.name from archiveuserhabit inner JOIN habit on archiveuserhabit.habitid=habit.id where archiveuserhabit.day='$day' and archiveuserhabit.userid = $userId");
  echo "<h2>Alle utførte habits for " . ucfirst($fornavn) . "</h2>";
  echo "<table border='1'>
  <tr>
  <th>Habit</th>
  <th>Habit-dag</th>
  <th>Slett</th>
  </tr>";

// Lager her oversikten i en tabell med alle habits for brukeren
// Lager en form per rad for å bruke POST verdiene i deleteHabit.php
  while($row = mysqli_fetch_array($alleUtførteHabits)){
    $habitId = $row['id'];
    $habitDay = $row['day'];
    $inputUtfort = '';
    echo "<form action='deleteHabit.php' method='post' name='updateHabit'>";
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $habitDay . "</td>";
    echo "<td>" . "<input type='submit' value='Slett habit'></input>" . "</td>";
    echo "<input type='hidden' value='$habitId' name='habitId'></input>";
    echo "</tr>";
    echo "</form>";

  }

  echo "</table>";
}

?>

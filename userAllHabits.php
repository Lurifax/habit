<?php
session_start();
require_once('./includes/dbconnect.php');

$userId = $_SESSION['id'];
$fornavn = $_SESSION['fornavn'];
$resultat = $connection->query("SELECT * FROM userhabit WHERE userid = $userId");
$day = strtolower(date('l'));

// Sjekker her om det er noen habits registrert på brukeren, hvis ikke skrives det til bruker
if ($resultat->num_rows == 0) {
  echo "Ingen habits registrert. Opprett habits for å se dine habits.";

// Hvis det er registrert habits på brukeren skrives alle disse ut
} else {
$dagensHabits = $connection->query("SELECT userhabit.habitid, userhabit.day, habit.id, habit.name from userhabit inner JOIN habit on userhabit.habitid=habit.id where userhabit.userid = $userId");
  echo "<h2>Alle habits for " . ucfirst($fornavn) . "</h2>";
  echo "<h3>Her ser du alle dine registrerte habits.</h3>";
  echo "<h3>Om du ønsker å slette en habit for følgende dager kan det gjøres her.</h3>";
  echo "<h3>Merk at dersom du sletter en habit med flere dager vil habiten for alle dagene slettes.</h3>";
  echo "<table border='1'>
  <tr>
  <th>Habit</th>
  <th>Habit-dag</th>
  <th>Slett</th>
  </tr>";

// Lager her oversikten i en tabell med alle habits for brukeren
// Lager en form per rad for å bruke POST verdiene i deleteHabit.php
  while($row = mysqli_fetch_array($dagensHabits)){
    $habitId = $row['id'];
    $habitDay = $row['day'];
    $inputUtfort = '';
    echo "<form action='deleteHabit.php' method='post' name='updateHabit'>";
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $habitDay . "</td>";
    echo "<td>" . "<input type='submit' value='&#10060;Slett habit'></input>" . "</td>";
    echo "<input type='hidden' value='$habitId' name='habitId'></input>";
    echo "</tr>";
    echo "</form>";

  }

  echo "</table>";
}

?>

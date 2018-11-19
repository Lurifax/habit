

<?php
echo "<meta charset='utf-8'>";
require 'db.php';

$userId = $_SESSION['id'];
$fornavn = $_SESSION['fornavn'];
$resultat = $mysqli->query("SELECT * FROM USERHABIT WHERE USERID = $userId");
$day = strtolower(date('l'));

// Sjekker her om det er noen habits registrert på brukeren, hvis ikke skrives det til bruker
if ($resultat->num_rows == 0) {
  echo "Ingen habits registrert. Opprett habits for å se dine habits.";


// Hvis det er registrert habits på brukeren skrives alle disse ut
} else {
$dagensHabits = $mysqli->query("SELECT userhabit.habitid, userhabit.day, habit.id, habit.name from userhabit inner JOIN habit on userhabit.habitid=habit.id where userhabit.userid = $userId") or die ($mysqli->error());
  //$dagensHabits = $mysqli->query("SELECT userhabit.habitid, userhabit.day, userhabit.isDone, habit.id, habit.name from userhabit inner JOIN habit on userhabit.habitid=habit.id where userhabit.day='$day' and userhabit.userid = $userId") or die ($mysqli->error());
  echo "<h2>Alle habits for " . ucfirst($fornavn) . "</h2>";
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
    echo "<td>" . "<input type='submit' value='Slett habit'></input>" . "</td>";
    echo "<input type='hidden' value='$habitId' name='habitId'></input>";
    echo "</tr>";
    echo "</form>";

  }

  echo "</table>";
}

/*
$resultat = $mysqli->query("SELECT userhabit.habitid, userhabit.day, habit.id, habit.name from userhabit inner JOIN habit on userhabit.habitid=habit.id where userhabit.userid = $userId") or die ($mysqli->error());
//$resultat = $mysqli->query("SELECT * FROM USERHABIT WHERE USERID = $id");


if ($resultat->num_rows == 0) {
  echo "Ingen habits registrert";
}
else {
  $getUserHabits = $resultat->fetch_assoc();

  echo "<h2>Alle dine habits</h2>";
  echo "<table border='1'>
  <tr>
  <th>Habitdag</th>
  <th>Habit</th>
  </tr>";

  while($rad = mysqli_fetch_array($resultat)){
    echo "<tr>";
    echo "<td>" . $rad['name'] . "</td>";
    //echo "<td>" . $rad['habitId'] . "</td>";
    echo "<td>" . $rad['day'] . "</td>";
    //echo "<td><input type='checkbox'>" . $rad['isDone'] . "</input></td>";
    echo "</tr>";
  }
  echo "</table>";
}

*/


/* Henter navn på dagen idag og konverterer fra engelsk til norsk dersom det er engelsk på server */
/*
$dagenIdag = date('l');
switch ($dagenIdag) {
  case "Monday":
    $dagenIdag = 'mandag';
    break;
  case "Tuesday":
    $dagenIdag = 'tirsdag';
    break;
  case "Wednesday":
    $dagenIdag = 'onsdag';
    break;
  case "Thursday":
    $dagenIdag = 'torsdag';
    break;
  case "Friday":
    $dagenIdag = 'fredag';
    break;
  case "Saturday":
    $dagenIdag = 'lordag';
    break;
  case "Sunday":
    $dagenIdag = 'sondag';
    break;

  default:
}




$dagensHabits = $mysqli->query("SELECT * FROM HABIT WHERE ID = $id");
echo "<h2>Dagens habits</h2>";
echo "<table border='1'>
<tr>
<th>Kategori</th>
<th>Habit</th>
<th>Habit-dag</th>
<th>Habit-utført</th>
</tr>";

  while($row = mysqli_fetch_array($dagensHabits)){
    echo "<tr>";
    echo "<td>" . $row['kategori'] . "</td>";
    echo "<td>" . $row['habit'] . "</td>";
    echo "<td>" . $row['habit_dag'] . "</td>";
    echo "<td>" . $row['habit_ferdig'] . "</td>";
    echo "</tr>";

  }

echo "</table>";
d

*/


?>

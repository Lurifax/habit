<?php
echo "<meta charset='utf-8'>";
require 'db.php';



//Setter userid og sjekker med $resultat om det er registrerte habits på brukeren.
$userId = $_SESSION['id'];
$fornavn = $_SESSION['fornavn'];
$resultat = $mysqli->query("SELECT * FROM USERHABIT WHERE USERID = $userId");
$day = strtolower(date('l'));

// Sjekker her om det er noen habits registrert på brukeren, hvis ikke skrives det til bruker
if ($resultat->num_rows == 0) {
  echo "Ingen habits registrert. Opprett habits for å se dine habits.";

// Hvis det er registrert habits for dagen idag skrives tabell med habits ut
}else {
  $dagensHabits = $mysqli->query("SELECT userhabit.habitid, userhabit.day, userhabit.isDone, habit.id, habit.name from userhabit inner JOIN habit on userhabit.habitid=habit.id where userhabit.day='$day' and userhabit.userid = $userId") or die ($mysqli->error());
  echo "<h2>Dagens habits for " . ucfirst($fornavn) . "</h2>";
  echo "<table border='1'>
  <tr>
  <th>Habit</th>
  <th>Habit-dag</th>
  <th>Habit-status</th>
  <th>Ferdig?</th>
  </tr>";

// Lager her oversikten i en tabell med dagens habits
// Lager en form per rad for å bruke POST verdiene i updateHabit.php
  while($row = mysqli_fetch_array($dagensHabits)){
    $inputEditable = "<td>" . "<input type='submit' value='Utfort'></input>" . "</td>";
    $inputDisabled = "<td>" . "<input type='submit' value='Utfort' disabled></input>" . "</td>";
    $isDone = $row['isDone'];
    $habitId = $row['id'];
    $habitDay = $row['day'];
    $inputUtfort = '';
    echo "<form action='updateHabit.php' method='post' name='updateHabit'>";
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $habitDay . "</td>";
    // Endrer her verdiene som lagres i databasen (0,1) til mer forståelige statuser
    switch ($isDone) {
      case "0":
        $isDone = 'Ikke utfort';
        $inputUtfort = $inputEditable;
        break;
      case "1":
        $isDone = 'Utfort';
        $inputUtfort = $inputDisabled;
        break;
        default:
      }
    echo "<td>" . $isDone . "</td>";
    //echo "<td>" . "<input type='submit' value='Utfort'></input>" . "</td>";
    echo $inputUtfort;
    echo "<input type='hidden' value='$habitId' name='habitId'></input>";
    echo "<input type='hidden' value='$habitDay' name='habitDay'></input>";
    echo "</tr>";
    echo "</form>";

  }

  echo "</table>";
}


?>

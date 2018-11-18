<?php
echo "<meta charset='utf-8'>";
require 'db.php';



//Setter userid og sjekker med $resultat om det er registrerte habits på brukeren.
$userId = $_SESSION['id'];
$resultat = $mysqli->query("SELECT * FROM USERHABIT WHERE ID = $userId");



if ($resultat->num_rows == 0) {
  echo "Ingen habits registrert";
}
else {
  $day = date('l');
  $dagensHabits = $mysqli->query("SELECT userhabit.habitid, userhabit.day, userhabit.isDone, habit.id, habit.name from userhabit inner JOIN habit on userhabit.habitid=habit.id where userhabit.day='$day' and userhabit.userid = $userId") or die ($mysqli->error());
  echo "<h2>Dagens habits</h2>";
  echo "<table border='1'>
  <tr>
  <th>Id</th>
  <th>Habit</th>
  <th>Habit-dag</th>
  <th>Habit-status</th>
  <th>Ferdig?</th>
  </tr>";

// Lager her oversikten i en tabell med dagens habits







  while($row = mysqli_fetch_array($dagensHabits)){
    $isDone = $row['isDone'];
    $habitId = $row['id'];
    echo "<form action='updateHabit.php' method='post' name='updateHabit'>";
    echo "<tr>";
    echo "<td>" . $habitId . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['day'] . "</td>";
    // Endrer her verdiene som lagres i databasen (0,1) til mer forståelige statuser
    switch ($isDone) {
      case "0":
        $isDone = 'Ikke utfort';
        break;
      case "1":
        $isDone = 'Utfort';
        break;
        default:
      }
    echo "<td>" . $isDone . "</td>";
    echo "<td>" . "<input type='submit' value='Utfort'></input>" . "</td>";
    echo "<input type='hidden' value='$habitId' name='habitId'></input>";
    echo "</tr>";
    echo "</form>";

  }

  echo "</table>";
}



?>

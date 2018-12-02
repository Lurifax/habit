<?php
//header('Content-Type: application/x-www-form-urlencoded; charset=utf-8');
//setlocale (LC_TIME, "no_NO");
require './includes/dbconnect.php';

//Setter userid og sjekker med $resultat om det er registrerte habits på brukeren.
$userId = $_SESSION['id'];
$fornavn = $_SESSION['fornavn'];
$resultat = $connection->query("SELECT * FROM userhabit WHERE userid = $userId");
$day = strtolower(date(l));

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

// Lager her spørring som spør om brukeren har habits lagret på brukeren i basen på denne dagen
$dagUtenHabit = $connection->query("SELECT * FROM userhabit WHERE userid = $userId AND day = '$day'");

// Sjekker her om det er noen habits registrert på brukeren, hvis ikke skrives det til bruker
if ($resultat->num_rows == 0) {
  echo "Ingen habits registrert. Opprett habits for å se dine habits.";

// Sjekker her om det er habits registrert på en annen dag enn idag, hvis ja skrives det ut til brukeren
} elseif ($dagUtenHabit->num_rows == 0) {
  echo "<center>Du har ingen habits å utføre for idag.</center>";

// Hvis det er registrert habits for dagen idag skrives tabell med habits ut
}else {
  $dagensHabits = $connection->query("SELECT userhabit.habitid, userhabit.day, userhabit.isDone, habit.id, habit.name from userhabit inner JOIN habit on userhabit.habitid=habit.id where userhabit.day='$day' and userhabit.userid = $userId");
  echo "<h2>Dagens habits for " . ucfirst($fornavn) . "</h2>";
  echo "<table border='1'>
  <tr>
  <th>Habit</th>
  <th>Habit-dag</th>
  <th>Habit-status</th>
  <th>&#x2714;</th>
  </tr>";

// Lager her oversikten i en tabell med dagens habits
// Lager en form per rad for å bruke POST verdiene i updateHabit.php
  while($row = mysqli_fetch_array($dagensHabits)){
    $inputEditable = "<td>" . "<input type='submit' id='ikkeutfort' value='&#x2714;'></input>" . "</td>";
    $inputDisabled = "<td>" . "<input type='submit' value='&#x2714;' disabled></input>" . "</td>";
    $isDone = $row['isDone'];
    $habitId = $row['id'];
    $habitDay = $row['day'];
    $habitName = $row['name'];
    $inputUtfort = '';
    echo "<form action='updateHabit.php' method='post' name='updateHabit'>";
    echo "<tr>";
    echo "<td>" . $habitName . "</td>";
    echo "<td>" . $habitDay . "</td>";
    // Endrer her verdiene som lagres i databasen (0,1) til mer forståelige statuser
    switch ($isDone) {
      case "0":
        $isDone = 'Ikke utført';
        $inputUtfort = $inputEditable;
        break;
      case "1":
        $isDone = 'Utført';
        $inputUtfort = $inputDisabled;
        break;
        default:
      }
    echo "<td>" . $isDone . "</td>";
    //echo "<td>" . "<input type='submit' value='Utfort'></input>" . "</td>";
    echo $inputUtfort;
    echo "<input type='hidden' value='$habitId' name='habitId'></input>";
    echo "<input type='hidden' value='$habitDay' name='habitDay'></input>";
    echo "<input type='hidden' value='$habitName' name='habitName'></input>";
    echo "</tr>";
    echo "</form>";

  }

  echo "</table>";
}


?>

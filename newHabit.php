<?php
//Starter session
session_start();
//Tar inn databasekobling
require_once('./includes/dbconnect.php');

//Oppretter variabler til bruk
$userId = $_SESSION['id'];
$habit = $_POST['habit'];
$days = $_POST['allDays'];

//Sjekk om det finnes likt gjøremål
//$resultat = $connection->query("SELECT * FROM habit WHERE name='$habit'");
$resultat = $connection->query("SELECT habit.name, userhabit.userid from habit inner join userhabit on habit.id=userhabit.habitid where habit.name='$habit' and userhabit.userid=$userId;");

//Lager funksjoner for vellykket eller mislykket inserter
function success_HabitSuksessfyltRegistrert($habit) {
  $_SESSION['melding'] = 'Habiten ' . $habit . ' er registrert';
  header("location: success_habit.php");
}

function error_HabitAlleredeRegistrert() {
  $_SESSION['melding'] = 'Feil under registrering av habiten. Habiten er allerede registrert din bruker.';
  header("location: error_habit.php");
}

//habit finnes fra før om resultat er større enn 0
if ($resultat->num_rows > 0 ) {

  while($rad = mysqli_fetch_array($resultat)){
  error_HabitAlleredeRegistrert();
  }
} else {

  // habiten finnes ikke fra før, inserter i databasen
  $sqlHabit = "INSERT INTO habit (name) "
  . "VALUES ('$habit')";

  $connection->query($sqlHabit);
  $habitId = $connection->insert_id;

//Løkke som oppretter flere habits på dagen(e) som er valgt. Kan bli valgt flere dager samtidig.
  foreach($days as $day){
    $sqlUserHabit = "INSERT INTO userhabit (userId, habitId, day) "
    . "VALUES ('$userId', '$habitId', '$day')";
      $connection->query($sqlUserHabit);
  }
success_HabitSuksessfyltRegistrert($habit);
}
?>

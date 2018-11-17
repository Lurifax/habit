<?php
//Starter session
session_start();

//Tar inn databasekobling
require "db.php";

//Oppretter variabler til bruk
$userId = $_SESSION['id'];
$habit = $_POST['habit'];
$days = $_POST['allDays'];

//Lager funksjoner for vellykket eller mislykket inserter
function success_HabitSuksessfyltRegistrert() {
  $_SESSION['melding'] = 'Habiten ' . $habit . ' er registrert';
  header("location: success_habit.php");
}

function error_HabitAlleredeRegistrert() {
  $_SESSION['melding'] = 'Feil under registrering av habiten. Habiten er allerede registrert din bruker.';
  header("location: error_habit.php");
}

//Sjekk om det finnes likt gjøremål
$resultat = $mysqli->query("SELECT * FROM HABIT WHERE NAME='$habit'") or die ($mysqli->error());





//habit finnes fra før om resultat er større enn 0
if ($resultat->num_rows > 0 ) {

  while($rad = mysqli_fetch_array($resultat)){
  error_HabitAlleredeRegistrert();
  }
} else {

  // habiten finnes ikke fra før, inserter i databasen
  $sqlHabit = "INSERT INTO habit (name) "
  . "VALUES ('$habit')";

  $mysqli->query($sqlHabit);
  $habitId = $mysqli->insert_id;

//Løkke som oppretter flere habiten på dagen(e) som er valgt. Kan bli valgt flere dager samtidig.
  foreach($days as $day){
    $sqlUserHabit = "INSERT INTO userhabit (userId, habitId, day) "
    . "VALUES ('$userId', '$habitId', '$day')";
      $mysqli->query($sqlUserHabit);
  }
success_HabitSuksessfyltRegistrert();
}




?>

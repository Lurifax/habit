<?php

session_start();
require 'db.php';

// Setter userid og habitId
$userId = $_SESSION['id'];
$habitId = $_POST['habitId'];

//Hvis brukeren trykker slett på en habit i userAllHabits.php vil POST-variabel settes
if (isset($_POST['habitId'])) {
  //Lager her SQL'er som sletter habits fra databasen på en shady måte dessverre... Må rydde opp i constraints for å gjøre dette skikkelig
  $deleteHabitFromArchive= $mysqli->query("DELETE FROM ARCHIVEUSERHABIT WHERE USERID = $userId AND HABITID = $habitId") or die ($mysqli->error());
  $deleteHabitFromUserHabit = $mysqli->query("DELETE FROM USERHABIT WHERE USERID = $userId AND HABITID = $habitId") or die ($mysqli->error());
  $deleteHabitFromHabit = $mysqli->query("DELETE FROM HABIT WHERE ID = $habitId") or die ($mysqli->error());
  $mysqli->query($deleteHabitFromArchive);
  $mysqli->query($deleteHabitFromUserHabit);
  $mysqli->query($deleteHabitFromHabit);
  header("location: changeHabits.php");
}


?>

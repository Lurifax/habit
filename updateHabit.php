<?php
session_start();
ob_start();
require_once('./includes/dbconnect.php');

// Setter userid og sjekker med $resultat om det er registrerte habits på brukeren.
$userId = $_SESSION['id'];
$habitId = $_POST['habitId'];
$habitDay = $_POST['habitDay'];
$habitName = $_POST['habitName'];

// Oppdaterer isDone i tabellen userhabit for den habitten brukeren har satt som 'utført'.
// Inserter i tillegg et innslag av den aktuelle habiten i archiveuserhabit tabellen for lagring til bruk av statistikk og progresjon

if (isset($_POST['habitId'])) {

  $updateHabitDone = $connection->query("UPDATE userhabit SET isdone = 1 WHERE userid = $userId AND day ='$habitDay'  AND habitid = $habitId");
  $archiveHabitAsDone = $connection->query("INSERT INTO archiveuserhabit (userid, habitid, day, habitname, isDone) VALUES('$userId','$habitId','$habitDay', '$habitName',1)");
  $connection->query($updateHabitDone);
  $connection->query($archiveHabitAsDone);
  header("location: profile.php");
}
ob_end_flush();
?>

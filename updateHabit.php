<?php

session_start();
require 'db.php';

// Setter userid og sjekker med $resultat om det er registrerte habits på brukeren.
$userId = $_SESSION['id'];
$habitId = $_POST['habitId'];
$habitDay = $_POST['habitDay'];

// Oppdaterer isDone i tabellen userhabit for den habitten brukeren har satt som 'utført'.
// Inserter i tillegg et innslag av den aktuelle habiten i archiveuserhabit tabellen for lagring til bruk av statistikk og progresjon

if (isset($_POST['habitId'])) {
  $updateHabitDone = $mysqli->query("UPDATE USERHABIT SET isDONE = 1 WHERE USERID = $userId AND HABITID = $habitId") or die ($mysqli->error());
  $archiveHabitAsDone = $mysqli->query("INSERT INTO ARCHIVEUSERHABIT (USERID, HABITID, DAY) VALUES('$userId','$habitId','$habitDay')") or die ($mysqli->error());
  $mysqli->query($updateHabitDone);
  $mysqli->query($archiveHabitAsDone);
  header("location: profile.php");
}

/*

// Lager connection til basen
$conn = new mysqli($host,$user,$pass,$db);
$updateHabitDone = $mysqli->query("UPDATE USERHABIT SET isDONE = 1 WHERE USERID = $userId AND HABITID = $habitId") or die ($mysqli->error());


// Funksjon for å oppdatere habit som utført
function updateHabit(){
  if ($conn->query($updateHabitDone) === TRUE) {
  $mysqli->query($updateHabitDone);
  header("location: profile.php");
    }else {
      header("location: error.php");
    }
}

// Sjekker om post er satt
if (isset($_POST['updateHabit'])) {
  updateHabit();
}


*/



?>
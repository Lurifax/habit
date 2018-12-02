<?php
session_start();
require_once('./includes/dbconnect.php');

// Setter userid og habitId
$userId = $_SESSION['id'];
$habitId = $_POST['habitId'];

//Hvis brukeren trykker slett på en habit i userAllHabits.php vil POST-variabel settes
if (isset($_POST['habitId'])) {
  //Lager her SQL'er som sletter habits registrert på brukeren. Den sletter dog ikke utførte og arkiverte habits
  //Disse er fortsatt lagret i archiveuserhabits for progresjonsvisning og statistikk.
  $deleteHabitFromUserHabit = $connection->query("DELETE FROM userhabit WHERE userid = $userId AND habitid = $habitId");
  $deleteHabitFromHabit = $connection->query("DELETE FROM habit WHERE id = $habitId");
  $connection->query($deleteHabitFromUserHabit);
  $connection->query($deleteHabitFromHabit);
  header("location: changeHabits.php");
}


?>

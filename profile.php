<?php
// Setter session med brukeren dersom den eksisterer
session_start();

if ( $_SESSION['loggetInn'] != 1) {
  $_SESSION['melding'] = "Logg inn for å se profilen din";
  header("location: error.php");
}
else {
  $id = $_SESSION['id'];
  $fornavn = $_SESSION['fornavn'];
  $etternavn = $_SESSION['etternavn'];
  $epost = $_SESSION['epost'];
  $aktiv = $_SESSION['aktiv'];
}


// Kaller oppp newHabit.php dersom man velger å registrere my habit
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (isset($_POST['newHabit'])) {
    require 'newHabit.php';
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Habit - Profilen for <?php echo $fornavn ?></title>
  <!--<?php include 'css/css.html'; ?> -->
</head>

<body>

<div class="dagensHabits">

<?php
include "UserTodayHabits.php";
?>

</div>


<div class="nyHabit">
    <!-- Opprett ny habit -->
    <h2>Opprett ny habit for <?php echo ucfirst($fornavn); ?></h2>
    <form action="newHabit.php" method="post" autocomplete="off" id="newHabit">
    <p>
      <label>Velg dag onsket for habiten</label>
      <input type="checkbox" name="allDays[]" value="monday" >Mandag</input>
      <input type="checkbox" name="allDays[]" value="tuesday" >Tirsdag</input>
      <input type="checkbox" name="allDays[]" value="wednesday" >Onsdag</input>
      <input type="checkbox" name="allDays[]" value="thursday" >Torsdag</input>
      <input type="checkbox" name="allDays[]" value="friday" >Fredag</input>
      <input type="checkbox" name="allDays[]" value="saturday" >Lørsdag</input>
      <input type="checkbox" name="allDays[]" value="sunday" >Søndag</input>
      <br /><p>

      <label>Hva er din habit?</label><br />
      <input type="text" name="habit" required/><br /><p>
      <input type="submit" name="newHabit">
  </form>
</div>

<!-- Gå til brukerens oversikt over habits for redigering-->
<div>
  <a href="changeHabits.php">
  <input type="button" value="Se/endre dine habits" />
</a>
  <p>
</div>

<div>
  <a href="progressHabit.php">
  <input type="button" value="Habitprogresjon" />
</a>
  <p>
</div>



<div>
<!-- Diverse velkomstmeldinger - Beholder disse inntil videre for å se om de skal brukes til slutt -->
  <!--<h2>Velkommen <?php echo $fornavn; ?></h1>
    <h2><?php echo $fornavn. " " . $etternavn; ?></h2>
    <h3><?php echo $epost; ?></h3>
    <h3><?php echo $id; ?></h3>-->

    <!-- Logoutknapp -->
    <a href="logout.php"><button class="button button" name="logout"/>Log Out</button></a>
  </div>

    <p>
    <?php
    /*Gir melding om at brukeren ikke er aktivert dersom aktiv=0 */
    if (!$aktiv ) {
      echo
      '<div class="info">
      Kontoen din er ikke aktivert. Vennligst aktiver kontoen din
      ved hjelp av instruksene i mailen sendt til '.$epost.
      '</div>';
    }
    ?>
  </p>


<!-- Diverse javascript for feilhåndtering og styling-->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="js/index.js"></script>
  <script src="js/errorHandler.js"></script>
  <script src="js/updateHabit.js"></script>



</body>

</html>

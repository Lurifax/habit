<?php
/* Setter session med brukeren dersom den eksisterer */
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


/* Kaller oppp newHabit.php dersom man velger å registrere my habit  */
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
  <title>Habit - Se/Endre Habits for <?php echo $fornavn ?></title>
  <!--<?php include 'css/css.html'; ?> -->
</head>


<body>
<!--Brukerens habits-->
  <div class="dineHabits">
    <?php
        include "userHabits.php";
        ?>
      </div>

      <div>
        <a href="profile.php">
        <input type="button" value="Tilbake til profilen" />
      </a><p>
      </div>
<div>
<!-- Diverse velkomstmeldinger - Beholder disse inntil videre -->
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


<!-- Beholder disse inntil videre til sluttstyling skal gjøres på prosjektet -->
<!--
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
<script src="errorHandler.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
-->

</body>
</html>

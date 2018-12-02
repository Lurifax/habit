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

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Habit - Alle utførte habits for <?php echo $fornavn ?></title>
  <link rel="stylesheet" type="text/css" href="css\changeHabits.css">
</head>


<body>
<div class="wrapper">
<!--Brukerens habits-->
  <div class="dineHabits">
    <?php
        include 'userProgressHabit.php';
        ?>

      </div>

      <div style="text-align:center;">
        <a href="profile.php">
        <input type="button" value="Tilbake til profilen" />
      </a><p>


    <!-- Logoutknapp -->
    <a href="logout.php"><button class="button button" name="logout"/>Logg ut</button></a>
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
</div>
<!-- Beholder disse inntil videre til sluttstyling skal gjøres på prosjektet -->
<!--
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
<script src="errorHandler.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
-->

</body>
</html>

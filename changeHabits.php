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
  <title>Habit - Se/Endre Habits for <?php echo $fornavn ?></title>
  <link rel="stylesheet" type="text/css" href="css\changeHabits.css">
</head>


<body>
<!--Brukerens habits-->
<div class="wrapper">
  <div class="dineHabits">
    <?php
        include "userAllHabits.php";
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

</body>
</html>

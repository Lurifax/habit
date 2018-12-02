<?php
//Setter til norsk bokmål om det ikke er satt på server
setlocale (LC_TIME, "no_NO");
// Setter session med brukeren dersom den eksisterer
session_start();

//Sjekker her om brukeren er logget inn, hvis ikke blir bruker sendt til error.
if ( $_SESSION['loggetInn'] != 1) {
  $_SESSION['melding'] = "Logg inn for å se profilen din";
  header("location: error.php");
} //Setter her session variabler for brukeren om bruker er logget inn.
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
  <title>Habit - Profilen for <?php echo ucfirst($fornavn); ?></title>
  <link rel="stylesheet" type="text/css" href="css/profile.css">
</head>

<body>
<!-- Lager her en divwrapper for alt innhold-->
<div class="wrapper">
<div class="dagensHabits">


<?php
//inkluderer her dagens habits som skal utføres for brukeren basert på hvilken dag det er.
include "UserTodayHabits.php";
?>

</div>

<!-- Her har brukeren muligheten til å registrere en ny habit-->
<div class="nyHabit">
    <!-- Opprett ny habit -->
    <h2>Opprett ny habit for <?php echo ucfirst($fornavn); ?></h2>
    <form action="newHabit.php" method="post" autocomplete="off" id="newHabit">
    <p>
      <label>Velg dag ønsket for habiten</label><br>
      <!-- Brukeren velger her hvilke dager som skal gjelde for habiten-->
      <!-- Dersom ingen dager velges gis det feilmelding ved hjelp av javascript-->
      <input type="checkbox" name="allDays[]" value="mandag" id="mandag" >Mandag</input><br />
      <input type="checkbox" name="allDays[]" value="tirsdag" id="tirsdag" >Tirsdag</input><br />
      <input type="checkbox" name="allDays[]" value="onsdag" id="onsdag" >Onsdag</input><br />
      <input type="checkbox" name="allDays[]" value="torsdag" id="torsdag" >Torsdag</input><br />
      <input type="checkbox" name="allDays[]" value="fredag" id="fredag" >Fredag</input><br />
      <input type="checkbox" name="allDays[]" value="lørdag" id="lørdag" >Lørdag</input><br />
      <input type="checkbox" name="allDays[]" value="søndag" id="søndag" >Søndag</input><br />
      <br /><p>

      <!-- Brukeren skriver her inn sin habit-->
      <label>Hva er din habit?</label><br />
      <input type="text" name="habit" required/><br /><p>

      <?php
      // Her tas det en sjekk på om brukeren har aktivert kontoen
      // Hvis ikke blir 'Lagre habit' disabled og rød
        $sql = "SELECT * FROM user WHERE id = $id AND epost='$epost' AND aktiv=1";
        $resultat = $connection->query($sql);
        if ($resultat->num_rows == 1){
        echo "<input type='submit' name='newHabit' value='Lagre habit'/>";
      } else {
      echo "<input type='submit' name='newHabit' style='background-color:#66131c;' value='Lagre habit' disabled/>";
      }
      ?>
  </form>
</div>
<p>
<br>

<!-- Går til brukerens oversikt over habits hvor brukeren kan slette habits som er registrert-->
<div class="habitSettings">
  <a href="changeHabits.php">
  <input type="button" value="Se/slett dine habits" />
</a>
  <p>

<!-- Går til brukerens oversikt over progresjon for utførte habits -->
  <a href="progressHabit.php">
  <input type="button" value="Habitprogresjon" />
</a>
  <p>
</div>
<div class="logout">

    <!-- Logoutknapp -->
    <a href="logout.php"><button class="button button" name="logout"/>Logg ut</button></a>
  </div>
    <br/>
    <p>
    <?php
    /*Gir melding om at brukeren ikke er aktivert dersom aktiv=0 */
    if (!$aktiv ) {
      echo
      '<div class="info">
      Kontoen din er ikke aktivert. Du kan derfor ikke lagre habits enda. Vennligst aktiver kontoen din
      ved hjelp av instruksene i mailen sendt til '.$epost.
      '</div>';
    }
    ?>
  </p>


<!-- Javascript for feilhåndtering og styling-->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="js/index.js"></script>
  <script src="js/errorHandler.js"></script>

</div>
</body>
</html>

<?php
/* Resetter passord og sender en link for reset */
require './includes/dbconnect.php';
session_start();

//Sjekker om skjema er sendt med method="POST"
if ( $_SERVER['REQUEST_METHOD'] == 'POST') {
  $epost = $connection->escape_string($_POST['epost']);
  $resultat = $connection->query("SELECT * FROM user WHERE epost='$epost'");

  if ($resultat->num_rows == 0) //brukeren eksisterer ikke
  {
    $_SESSION['melding'] = "Bruker med den mailen finnes ikke";
    header("location: error.php");
  }
  else { //brukeren eksisterer

    $bruker = $resultat->fetch_assoc();
    $epost = $bruker['epost'];
    $hash = $bruker['hash'];
    $fornavn = $bruker['fornavn'];
    $id = $bruker['id'];

    // Melding som skal vises når mail sendes
    $_SESSION['melding'] = "<p>Vennligst sjekk din epost <span>$epost</span>"
    . " for en aktiveringslenke med instruks for å tilbakestille ditt passord</p>";

    // Sender reset passord eposten
    $til    = $epost;
    $emne   = 'Habit - Tilbakestill ditt passord';
    $melding = '
    Hei ' . $fornavn. ',

    Du har bedt om å tilbakestille ditt passord. Vennligst benytt lenken under for å tilbakestille ditt passord:
      https://stianalexanderolsen.com/habit/reset.php?epost='.$epost.'&hash='.$hash.'&id='.$id;

      mail($til, $emne, $melding);

      header("location: success.php");
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Tilbakestill passord</title>
  <?php include 'css/css.html'; ?>
</head>
<body>

  <div class="form">

    <h1>Tilbakestill passord</h1>

    <form action="forgot.php" method="post">
     <div class="field-wrap">
      <label>
        Epost<span class="req">*</span>
      </label>
      <input type="email"required autocomplete="off" name="epost"/>
    </div>
    <button class="button button-block"/>Tilbakestill</button>
    </form>
  </div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>

</html>

<?php
/* Hovedside med login og registrer */
session_start();
//require_once('./includes/dbconnect.php');

$page='dbconnect.php';
if (!preg_match("#\.\./#",$page) AND
preg_match("#^[-a-z0-9_.]+$#i",$page) AND
  file_exists("includes/$page") ) {
    include("includes/$page");
} else {
  print "Invalid page requested. The attempt has been logged.";
  # Her kan du kode en rutine som logger forsøket på å gå rundt systemet ditt!
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Habit</title>
  <?php include 'css/css.html'; ?>
</head>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (isset($_POST['login'])) { //logg inn

    require 'login.php';
  }

  elseif (isset($_POST['register'])) { //registrering av bruker

    require 'register.php';
  }
}
?>
<body>
  <div class="form">

      <ul class="tab-group">
        <li class="tab"><a href="#signup">Registrer deg</a></li>
        <li class="tab active"><a href="#login">Logg inn</a></li>
      </ul>

      <div class="tab-content">

         <div id="login">
          <h1>Habit</h1>
          <form action="login.php" method="post" autocomplete="off">
            <div class="field-wrap">
            <label>
              Epost<span class="req">*</span>
            </label>
            <input type="email" required autocomplete="off" name="epost"/>
          </div>

          <div class="field-wrap">
            <label>
              Passord<span class="req">*</span>
            </label>
            <input type="password" required autocomplete="off" name="passord"/>
          </div>

          <p class="forgot"><a href="forgot.php">Glemt passord?</a></p>
          <button class="button button-block" name="login" />Logg inn</button>
          </form>
        </div>

        <div id="signup">
          <h1>Registrer deg</h1>

          <form action="register.php" method="post" autocomplete="off">

          <div class="top-row">
            <div class="field-wrap">
              <label>
                Fornavn<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name='fornavn' />
            </div>

            <div class="field-wrap">
              <label>
                Etternavn<span class="req">*</span>
              </label>
              <input type="text"required autocomplete="off" name='etternavn' />
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Epost<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name='epost' />
          </div>

          <div class="field-wrap">
            <label>
              Passord<span class="req">*</span>
            </label>
            <input type="password" required minlength="8" autocomplete="off" name='passord'/>
          </div>
          <button type="submit" class="button button-block" name="register" />Registrer deg</button>
          </form>

        </div>
      </div>

</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>

</body>
</html>

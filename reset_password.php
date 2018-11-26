<?php
header('application/x-www-form-urlencoded');
require_once('./includes/dbconnect.php');
session_start();
// Make sure the form is being submitted with method="post"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//if (isset($_POST['reset'])) {

        $nyttpassord = password_hash($_POST['nyttpassord'], PASSWORD_DEFAULT);

        // We get $_POST['email'] and $_POST['hash'] from the hidden input field of reset.php form
        $epost = $connection->escape_string($_POST['epost']);
        $hash = $connection->escape_string($_POST['hash']);
        $id = $connection->escape_string($_POST['id']);

        $sql = "UPDATE user SET passord='$nyttpassord', hash='$hash' WHERE id='$id'";


        if ($connection->query($sql) ) {
        $_SESSION['melding'] = "Ditt passord er nå endret!";
        header("location: success.php");
    }
    else {
        $_SESSION['melding'] = "Noe gikk galt!";
        header("location: error.php");
    }
}

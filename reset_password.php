<?php

require_once('./includes/dbconnect.php');
session_start();

// Sjekker at form benytter POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        $nyttpassord = password_hash($_POST['nyttpassord'], PASSWORD_DEFAULT);

        // Henter epost, hash og id fra hidden inputfelt
        $epost = $connection->escape_string($_POST['epost']);
        $hash = $connection->escape_string($_POST['hash']);
        $id = $connection->escape_string($_POST['id']);

        $sql = "UPDATE user SET passord='$nyttpassord', hash='$hash' WHERE id='$id'";

        //Utfører her oppdatering av passord
        if ($connection->update($sql) === TRUE){
        $_SESSION['melding'] = "Ditt passord er nå endret!";
        header("location: success.php");
      } else {
        //Sender brukeren til error om request_method ikke er satt
        $_SESSION['melding'] = "Noe gikk galt!";
        header("location: error.php");
      }
    }

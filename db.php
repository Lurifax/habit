<?php
// Databasetilkobling

require 'secrets.php';

$host = $hostHabit;
$user = $userHabit;
$pass = $passHabit;
$db = $dbHabit;
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

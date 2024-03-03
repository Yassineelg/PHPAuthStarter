<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpauthstarter";

try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connexion to the database failed: " . $e->getMessage();
}

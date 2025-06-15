<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kisisel_gelisim";

$mysqli = new mysqli($servername, $username, $password, $dbname);
if ($mysqli->connect_error) {
    die("Bağlantı hatası: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8");
?>

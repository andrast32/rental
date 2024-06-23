<?php 
$host       = "localhost";
$username   = "root";
$password   = "";
$database   = "rental";

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Koneksi kedatabase gagal :" . $mysqli->connect_error);
}
?>
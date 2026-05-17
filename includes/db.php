<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "zegowska_szama";

$conn = new mysqli($host, $user, $pass, $dbname);

if($conn->connect_error){
    die("Blad polaczenia: " . $conn->connect_error);
}

?>
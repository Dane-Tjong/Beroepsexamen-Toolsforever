<?php
$servername = "localhost";
$dbname = "tjong_a_hunt_com_Toolsforever";
$username = "tjong_a_hung_com_Toolsforever";
$password = "3zXi4hQKoXqL";
$charset = "utf8mb4";
$opt = [PDO::ATTR_CASE => PDO::CASE_LOWER, PDO::ATTR_EMULATE_PREPARES => TRUE, PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING];
$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=$charset", $username, $password, $opt);
?>
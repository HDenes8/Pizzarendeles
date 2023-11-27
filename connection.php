<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "pizza"; 
try {
    $conn = new PDO("mysql:host=$host;dbname=$database","$username","$password");  // kapcsolódás
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  // hibákra kivételt dobjon
  } catch (PDOException $e){
    echo "<p class=\"error\">Adatbázis kapcsolódási hiba: {$e->getMessage()}</p>\n";
    die();
  } catch (Throwable $e){
    echo "<p class=\"error\">Ismeretlen hiba: {$e->getMessage()}</p>\n";
    die();
  }


<?php
    include("connection.php");
    $id = $_GET['id'];
    $sql = "SELECT * FROM rendelesek WHERE id = '$id'";
    $result = $conn->prepare($sql);
    $result->execute();
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "Pizzanév: ";
    echo "{$row['pizzanev']}";
    echo "<br><br>";
    echo "Feltét: ";
    echo $row['feltetnev'];
    echo "<br><br>";
    echo "Méret: ";
    echo $row['meret'];
    echo "<br><br>";
    echo "Mennyiség: ";
    echo $row['mennyiseg'];
    echo "<br><br>";
    echo "Ár: ";
    echo $row['ar'];
    echo "<br><br>";
    echo "Rendelés ideje: ";
    echo $row['rendeles_ideje'];
    echo "<br><br>";
    echo "Szállítási cím: ";
    echo $row['szallitasi_cim'];
    echo "<br><br>";
    echo "Telefonszám: ";
    echo $row['telefonszam'];
    echo "<br><br>";
    echo "Kézbesítés: ";
    echo $row['kezbesites_statusz'];
    echo "<br><br>";
    echo "Kiszállítás ideje: ";
    echo $row['kiszallitas_ideje'];
    

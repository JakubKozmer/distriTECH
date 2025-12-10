<?php
include("config.php"); // Tento súbor by mal obsahovať databázové pripojenie - $servername, $username, $password a $dbname

// Pripojenie k databáze
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kontrola pripojenia
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL dotaz pre výber všetkých položiek z tabuľky
$sql = "SELECT id, pc, nazov, vyrobca, popis, kusov, cena, kod FROM ntovar";
$result = mysqli_query($conn, $sql);

// Kontrola, či výsledok dotazu obsahuje riadky
if (mysqli_num_rows($result) > 0) {
    // Výpis dát z každého riadku
    while($row = mysqli_fetch_assoc($result)) {
        echo "ID: " . $row["id"] . " - PC: " . $row["pc"]. " - Názov: " . $row["nazov"]. " - Výrobca: " . $row["vyrobca"]. " - Popis: " . $row["popis"]. " - Kusov: " . $row["kusov"]. " - Cena: " . $row["cena"]. " - Kód: " . $row["kod"]. "<br>";
    }
} else {
    echo "0 výsledkov";
}

// Zatvorenie pripojenia
mysqli_close($conn);
?>

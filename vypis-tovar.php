<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
<head>
    <title>Vyhľadávanie</title>
    <link href="style.css" rel=stylesheet type=text/css>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }
        table {
            width: 700px;
            border-collapse: separate;
            border-spacing: 0;
            margin: 20px auto;
            background-color: #fff;
            border: 2px solid #ccc;
            border-radius: 5px;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #e6ccff;
            border-bottom: 3px solid #aaa;
            text-transform: uppercase;
            font-size: 14px;
        }
        tr {
            border-bottom: 1px solid #ccc;
        }
        tr:hover {
            background-color: #e6f7ff;
        }
        .item-row {
            border: 2px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }
        a {
            color: #0066cc;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; margin-bottom: 30px;">Zoznam Tovarov</h1>
    <?php
    echo "<table border='0'>";
    include ("config2.php");   
    include ("config.php");
 
    $var = mysqli_connect("$servername","$username","$password","$dbname") or die ("connect error");
    $sql = "SELECT id, pc, nazov, vyrobca, popis, kusov, cena, kod FROM ntovar";
    $result = mysqli_query($var, $sql) or exit ("chybný dotaz");
 
    // Hlavička tabuľky
    echo "<tr>
    <th>Mesto</th>
    <th>Názov</th>
    <th>Výrobca</th>
    <th>Popis</th>
    <th>Kusov</th>
    <th>Cena</th>
    <th>Kód</th>
    <th>Akcie</th>
</tr>";

// Načítanie hodnôt do poľa
while($row = mysqli_fetch_assoc($result))
{ 
    $id = $row['id'];
    $pc = $row['pc'];
    $nazov = $row['nazov'];
    $vyrobca = $row['vyrobca'];
    $popis = $row['popis'];
    $kusov = $row['kusov'];
    $cena = $row['cena'];
    $kod = $row['kod'];

    // Výpis hodnôt
    echo "<tr class='item-row'>
        <td><b>$pc</b></td>
        <td><b>$nazov</b></td>
        <td><b>$vyrobca</b></td>
        <td><b>$popis</b></td>
        <td><b>$kusov</b></td>
        <td><b>$cena &euro;</b></td>
        <td><b>$kod</b></td>
        <td><a href='index.php?menu=12&id=$id'>Upraviť</a> | <a href='zmazanietov.php?id=$id' style='color: red;'>Zmazať</a></td>
    </tr>";
}
echo "</table>";
?>
</body>
</html>

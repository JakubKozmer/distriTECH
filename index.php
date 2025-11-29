<?php
include("config.php");

// Test pripojenia
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
<title>Distribuovaná databáza - Autá</title>

<style>
    body {
        margin: 0;
        padding: 0;
        background: #e6e6e6; /* jemné sivé pozadie */
        font-family: Arial, sans-serif;
        color: #000; /* čierny text */
    }

    .header {
        width: 100%;
        padding: 20px;
        background: #444; 
        color: white;
        text-align: center;
        font-size: 28px;
        font-weight: bold;
    }

    .layout {
        display: flex;
        height: calc(100vh - 80px); /* fullscreen */
    }

    /* MENU – sivé pozadie + tmavý text */
    .menu {
        width: 250px;
        background: #ccc; /* podklad ponechaný */
        padding: 20px;
        overflow-y: auto;
        color: #222; /* tmavší text */
        font-size: 16px;
    }

    .menu a {
        color: #222; /* tmavý text linkov */
        text-decoration: none;
        font-weight: bold;
        display: block;
        margin-bottom: 10px;
    }

    .menu a:hover {
        color: #000; /* ešte tmavší pri hover */
        text-decoration: underline;
    }

    .content {
        flex: 1;
        padding: 20px;
        background: #f8f8f8;
        overflow-y: auto;
        color: black;
    }
</style>

</head>

<body>

<div class="header">
    Distribuovaná databáza – Auta
</div>

<div class="layout">

    <!-- MENU -->
    <div class="menu">
        <?php include("menu.php"); ?>
    </div>

    <!-- OBSAH -->
    <div class="content">
        <?php
        $m = isset($_GET["menu"]) ? intval($_GET["menu"]) : 8;

        switch ($m) {
            case 2: include("pridaj-auto.php"); break;
            case 7: include("pridaj-auto-ok.php"); break;
            case 4: include("synchro.php"); break;
            case 8: include("vypis-auto.php"); break;
            case 10: include("edit-auto.php"); break;
            case 11: include("edit-auto-ok.php"); break;
            case 12: include("zmaz-auto.php"); break;
            default: include("vypis-auto.php"); break;
        }
        ?>
    </div>

</div>

</body>
</html>

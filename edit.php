<?php
include("config.php");
include("config2.php"); // Konfigurácia pre vzdialenú databázu
include("config3.php"); // Konfigurácia pre ďalšiu vzdialenú databázu
 
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Získanie dát z formulára
    $id = $_POST['id'];
    $pc = $_POST['pc'];
    $nazov = $_POST['nazov'];
    $vyrobca = $_POST['vyrobca'];
    $popis = $_POST['popis'];
    $kusov = $_POST['kusov'];
    $cena = $_POST['cena'];
    $kod = $_POST['kod'];
 
    // Pripojenie k lokálnej databáze
    $conn = new mysqli($servername, $username, $password, $dbname);
 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 
    // Korektné typy pre bind_param
    $sql = "UPDATE ntovar SET pc = ?, nazov = ?, vyrobca = ?, popis = ?, kusov = ?, cena = ?, kod = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
 
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
 
    // Typy parametrov: pc (s), nazov (s), vyrobca (s), popis (s), kusov (i), cena (s), kod (s), id (i)
    $stmt->bind_param("ssssissi", $pc, $nazov, $vyrobca, $popis, $kusov, $cena, $kod, $id);
 
    if ($stmt->execute()) {
 
        // Synchronizácia so vzdialenou databázou
        $conn_remote = new mysqli($remote_servername, $remote_username, $remote_password, $remote_dbname);
 
        if ($conn_remote->connect_error) {
            // Ak sa nedá pripojiť k vzdialenej databáze, uloží SQL príkaz na neskoršie vykonanie
            $failed_sql = $sql . " -- " . json_encode([$pc, $nazov, $vyrobca, $popis, $kusov, $cena, $kod, $id]) . "\n";
            file_put_contents('failed_transactions.txt', $failed_sql, FILE_APPEND);
            echo "<script>alert('Vzdialená databáza je neprístupná. SQL príkaz uložený.');</script>";
        } else {
            // Príprava a vykonanie SQL na vzdialenej databáze
            $stmt_remote = $conn_remote->prepare($sql);
            if ($stmt_remote === false) {
                die("Error preparing statement for remote: " . $conn_remote->error);
            }
 
            $stmt_remote->bind_param("ssssissi", $pc, $nazov, $vyrobca, $popis, $kusov, $cena, $kod, $id);
 
            if (!$stmt_remote->execute()) {
                // Ak zlyhá vzdialená aktualizácia, uloží SQL príkaz
                $failed_sql = $sql . " -- " . json_encode([$pc, $nazov, $vyrobca, $popis, $kusov, $cena, $kod, $id]) . "\n";
                file_put_contents('failed_transactions.txt', $failed_sql, FILE_APPEND);
                echo "<script>alert('Synchronizácia s vzdialenou databázou zlyhala. SQL príkaz uložený.');</script>";
            }
 
            $stmt_remote->close();
        }
        $conn_remote->close();
 
        // Synchronizácia so vzdialenou databázou2
        $conn_remote2 = new mysqli($remote_servername2, $remote_username2, $remote_password2, $remote_dbname2);
 
        if ($conn_remote2->connect_error) {
            // Ak sa nedá pripojiť k vzdialenej databáze, uloží SQL príkaz na neskoršie vykonanie
            $failed_sql = $sql . " -- " . json_encode([$pc, $nazov, $vyrobca, $popis, $kusov, $cena, $kod, $id]) . "\n";
            file_put_contents('failed_transactions.txt', $failed_sql, FILE_APPEND);
            echo "<script>alert('Vzdialená databáza 2 je neprístupná. SQL príkaz uložený.');</script>";
        } else {
            // Príprava a vykonanie SQL na vzdialenej databáze
            $stmt_remote = $conn_remote2->prepare($sql);
            if ($stmt_remote === false) {
                die("Error preparing statement for remote: " . $conn_remote2->error);
            }
 
            $stmt_remote->bind_param("ssssissi", $pc, $nazov, $vyrobca, $popis, $kusov, $cena, $kod, $id);
 
            if (!$stmt_remote->execute()) {
                // Ak zlyhá vzdialená aktualizácia, uloží SQL príkaz
                $failed_sql = $sql . " -- " . json_encode([$pc, $nazov, $vyrobca, $popis, $kusov, $cena, $kod, $id]) . "\n";
                file_put_contents('failed_transactions.txt', $failed_sql, FILE_APPEND);
                echo "<script>alert('Synchronizácia s vzdialenou databázou 2 zlyhala. SQL príkaz uložený.');</script>";
            }
 
            $stmt_remote->close();
        }
        $conn_remote2->close();
 
    } else {
        echo "<script>alert('Chyba: " . addslashes($stmt->error) . "');</script>";
    }
    echo "<script>window.location.href = 'index.php?menu=8';</script>";
 
    $stmt->close();
    $conn->close();
 
} else {
    // Získanie dát z databázy na predvyplnenie formulára
    $id = $_GET['id'];
 
    $conn = new mysqli($servername, $username, $password, $dbname);
 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 
    $sql = "SELECT * FROM ntovar WHERE id = ?";
    $stmt = $conn->prepare($sql);
 
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
 
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
 
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
 
        <!DOCTYPE html>
        <html lang="sk">
        <head>
            <meta charset="UTF-8">
            <title>Editácia záznamu</title>
            <style>
        /* Štýl pre modálne okno */
        .modal {
            display: block;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6); /* Tmavšie pozadie */
        }
 
        .modal-content {
            background-color: #FFFFFF; /* Svetlé pozadie */
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #ddd; /* Jemnejšia farba okraja */
            width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15); /* Jemnejší tieň */
            border-radius: 8px; /* Zaoblené rohy */
        }
 
        .close {
            color: #213A58; /* Tmavý text */
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
 
        .close:hover,
        .close:focus {
            color: #46DFB1; /* Svetlá zelená farba pri hover */
            text-decoration: none;
            cursor: pointer;
        }
 
        input[type="text"], input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 10px; /* Väčšie odsadenie */
            margin: 10px 0; /* Väčšie medzery */
            box-sizing: border-box;
            border: 1px solid #7a7979; /* Jemné ohraničenie */
            border-radius: 4px; /* Zaoblené rohy */
            font-size: 14px; /* Kontrastné písmo */
        }
 
        input[type="submit"] {
            background-color: #09D1C7; /* Svetlá tyrkysová */
            color: #FFFFFF; /* Biely text */
            border: none;
            cursor: pointer;
            border-radius: 4px; /* Zaoblené rohy */
            transition: background-color 0.3s ease; /* Efekt pri hover */
        }
 
        input[type="submit"]:hover {
            background-color: #46DFB1; /* Svetlá zelená pri hover */
        }
        </style>
        </head>
        <body>
        <div class="modal">
            <div class="modal-content">
                <span class="close" onclick="window.location.href = 'index.php?menu=8';">&times;</span>
                <form action="edit.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <b>Mesto:</b> <input name="pc" type="text" value="<?php echo $row['pc']; ?>"><br>
                    Názov: <input name="nazov" type="text" value="<?php echo $row['nazov']; ?>"><br>
                    Výrobca: <input name="vyrobca" type="text" value="<?php echo $row['vyrobca']; ?>"><br>
                    Popis: <input name="popis" type="text" value="<?php echo $row['popis']; ?>"><br>
                    Kusov: <input name="kusov" type="number" value="<?php echo $row['kusov']; ?>"><br>
                    Cena: <input name="cena" type="text" value="<?php echo $row['cena']; ?>"><br>
                    Kód: <input name="kod" type="text" value="<?php echo $row['kod']; ?>"><br>
                    <input type="submit" value="Uložiť zmeny">
                </form>
            </div>
        </div>
        </body>
        </html>
 
        <?php
    } else {
        echo "<script>alert('Záznam nenájdený.'); window.location.href = 'index.php?menu=8';</script>";
    }
 
    $stmt->close();
    $conn->close();
}
?>

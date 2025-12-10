<?php
include("config.php");
include("config2.php"); // Pridanie konfigurácie pre vzdialenú databázu
include("config3.php"); // Pridanie konfigurácie pre ďalšiu vzdialenú databázu
 
 
if (isset($_GET['id'])) {
    $id = $_GET['id'];
 
    // Vymazanie záznamu z lokálnej databázy
    $conn = new mysqli($servername, $username, $password, $dbname);
 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 
    $sql = "DELETE FROM ntovar WHERE id = ?";
    $stmt = $conn->prepare($sql);
 
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
 
    $stmt->bind_param("i", $id);
 
    if ($stmt->execute()) {
        // Pokus o vymazanie záznamu aj zo vzdialenej databázy
        $remote_conn = new mysqli($remote_servername, $remote_username, $remote_password, $remote_dbname);
 
        if ($remote_conn->connect_error) {
            // Logovanie neúspešného pokusu do súboru
            file_put_contents('failed_transactions.txt', "DELETE FROM ntovar WHERE id = $id;\n", FILE_APPEND);
        } else {
            $remote_sql = "DELETE FROM ntovar WHERE id = ?";
            $stmt_remote = $remote_conn->prepare($remote_sql);
 
            if ($stmt_remote === false) {
                // Logovanie chyby pri príprave SQL príkazu
                file_put_contents('failed_transactions.txt', "DELETE FROM ntovar WHERE id = $id;\n", FILE_APPEND);
            } else {
                $stmt_remote->bind_param("i", $id);
                if (!$stmt_remote->execute()) {
                    // Logovanie chyby pri vykonaní SQL príkazu
                    file_put_contents('failed_transactions.txt', "DELETE FROM ntovar WHERE id = $id;\n", FILE_APPEND);
                }
                $stmt_remote->close();
            }
            $remote_conn->close();
 
        }
 
 
        //vymazanie z dabazy config3
        $remote_conn2 = new mysqli($remote_servername2, $remote_username2, $remote_password2, $remote_dbname2);
 
        if ($remote_conn2->connect_error) {
            // Logovanie neúspešného pokusu do súboru
            file_put_contents('failed_transactions.txt', "DELETE FROM ntovar WHERE id = $id;\n", FILE_APPEND);
        } else {
            $remote_sql = "DELETE FROM ntovar WHERE id = ?";
            $stmt_remote = $remote_conn2->prepare($remote_sql);
 
            if ($stmt_remote === false) {
                // Logovanie chyby pri príprave SQL príkazu
                file_put_contents('failed_transactions.txt', "DELETE FROM ntovar WHERE id = $id;\n", FILE_APPEND);
            } else {
                $stmt_remote->bind_param("i", $id);
                if (!$stmt_remote->execute()) {
                    // Logovanie chyby pri vykonaní SQL príkazu
                    file_put_contents('failed_transactions.txt', "DELETE FROM ntovar WHERE id = $id;\n", FILE_APPEND);
                }
                $stmt_remote->close();
            }
            $remote_conn2->close();
        }
    }
 
    echo "<script>window.location.href = 'index.php?menu=8';</script>";
 
    $stmt->close();
    $conn->close();
} else {
    // Presmerovanie, ak nie je zadané ID
    echo "<script>alert('ID záznamu nie je špecifikované.'); window.location.href = 'index.php?menu=8';</script>";
}
?>

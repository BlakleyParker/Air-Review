<?php
/**
 * Class: csci303
 * User: Blake
 * Date: 3/23/2021
 * Time: 10:46 AM
 */

function checkdup($pdo, $sql, $field) {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $field);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function checkLogin()
{
    if (!isset($_SESSION['ID'])) {
        echo "<p class='error'>This page requires authentication.  Please log in to view details.</p>";
        require_once "footer.php";
        exit();
    }
}

function checkAdmin()
{
    //check login
    if (isset($_SESSION['ID']) && $_SESSION['status'] != 1) {
        echo "<p class='error'>This page requires administrative authentication.</p>";
        require_once "footer.php";
        exit();
    }
}

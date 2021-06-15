<?php
/**
 * Class: csci303
 * User: Blake
 * Date: 3/2/2021
 * Time: 10:55 AM
 */

session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');


require_once "connect.php";
require_once "functions.php";

$currentFile = basename($_SERVER['SCRIPT_FILENAME']);
$rightNow = time();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Final Project - Blakley Parker</title>
    <link rel="stylesheet" href="includes/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>

</head>
<body>
<header>
    <h1>Air Review - Blakley Parker</h1>
    <nav>
        <div class="topnav">
            <?php

            if (isset($_SESSION['ID']) && $_SESSION['status'] == 1) {
            echo ($currentFile == "index.php") ? "<a class='active' href='index.php'>Home</a>" : "<a href='index.php'>Home</a>";
            echo ($currentFile == "login.php") ? "<a class='active' href='login.php'>User Information</a>" : "<a href='login.php'>User Information</a>";
            echo ($currentFile == "viewairports.php") ? "<a class='active' href='viewairports.php'>View Airports</a>" : "<a href='viewairports.php'>View Airports</a>";
            echo ($currentFile == "searchairport.php") ? "<a class='active' href='searchairport.php'>Search Airport</a>" : "<a href='searchairport.php'>Search Airport</a>";
            echo ($currentFile == "updateusers.php") ? "<a class='active' href='updateusers.php'>Update Account</a>" : "<a href='updateusers.php'>Update Account</a>";
            echo ($currentFile == "addairport.php") ? "<a class='active' href='addairport.php'>Add Airport</a>" : "<a href='addairport.php'>Add Airport</a>";
            echo ($currentFile == "viewusers.php") ? "<a class='active' href='viewusers.php'>Update User Status</a>" : "<a href='viewusers.php'>Update User Status</a>";
            echo ($currentFile == "logout.php") ? "<a class='active' href='logout.php'>Logout</a>" : "<a href='logout.php'>Logout</a>";
            } elseif (isset($_SESSION['ID'])) {
            echo ($currentFile == "index.php") ? "<a class='active' href='index.php'>Home</a>" : "<a href='index.php'>Home</a>";
            echo ($currentFile == "login.php") ? "<a class='active' href='login.php'>User Information</a>" : "<a href='login.php'>User Information</a>";
            echo ($currentFile == "viewairports.php") ? "<a class='active' href='viewairports.php'>View Airports</a>" : "<a href='viewairports.php'>View Airports</a>";
            echo ($currentFile == "searchairport.php") ? "<a class='active' href='searchairport.php'>Search Airport</a>" : "<a href='searchairport.php'>Search Airport</a>";
            echo ($currentFile == "updateusers.php") ? "<a class='active' href='updateusers.php'>Update Account</a>" : "<a href='updateusers.php'>Update Account</a>";
            echo ($currentFile == "logout.php") ? "<a class='active' href='logout.php'>Logout</a>" : "<a href='logout.php'>Logout</a>";
            }
            else {
            echo ($currentFile == "index.php") ? "<a class='active' href='index.php'>Home</a>" : "<a href='index.php'>Home</a>";
            echo ($currentFile == "viewairports_notloggedin.php") ? "<a class='active' href='viewairports.php'>View Airports</a>" : "<a href='viewairports_notloggedin.php'>View Airports</a>";
            echo ($currentFile == "searchairport.php") ? "<a class='active' href='searchairport.php'>Search Airport</a>" : "<a href='searchairport.php'>Search Airport</a>";
            echo ($currentFile == "login.php") ? "<a class='active' href='login.php'>Login</a>" : "<a href='login.php'>Login</a>";
            }
            ?>

        </div>
    </nav>
</header>
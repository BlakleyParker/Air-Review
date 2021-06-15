<?php
/**
 * Class: csci303
 * User: Blake
 * Date: 3/1/2021
 * Time: 11:11 AM
 */


//Connect to DB
//edited out for GitHub repo
$connString = "mysql:host=localhost;dbname=";
$user = "";
$pass = "";
$pdo = new PDO($connString, $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
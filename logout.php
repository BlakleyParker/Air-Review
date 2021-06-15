<?php
/**
 * Class: csci303
 * User: Blake
 * Date: 4/29/2021
 * Time: 11:23 AM
 */


session_start();
session_unset();
session_destroy();
header("Location: confirm.php?state=1");
exit();
<?php
include "function.php";
$pagetitle = "Dashboard";
include "head.php";
include "header.php";

if (!isset($_SESSION['username'])) {
    header('Location: login.php?error=access');
    exit;
}

echo "<h1>UNDER CONSTRUCTION</h1>";
?>
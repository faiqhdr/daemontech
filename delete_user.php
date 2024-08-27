<?php
session_start();
include 'connection.php';
if (!isset($_SESSION["login"])){
    header("Location: 01_sbms_login.php");
    exit;
}
$userID = $_GET['userID'];

if (isset($userID)) {
    mysqli_query($connection, "DELETE FROM user WHERE userID='$userID'");
}

header('location: 04_sbms_admin.php');
?>
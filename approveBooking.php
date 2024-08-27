<?php
include 'connection.php';

$bookingID = $_GET['id'];

if (isset($bookingID)) {
    mysqli_query($connection, "UPDATE booking SET status='APPROVED' WHERE bookingID='$bookingID'");
}

header('location: 03_sbms_spacemanager.php');
?>
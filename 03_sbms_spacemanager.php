<?php
    session_start();
    include ('connection.php'); 
    if (!isset($_COOKIE['id']) && !isset($_COOKIE['pass'])) {
        echo "<script>alert('Cookie Timeout!');
        window.location='logout.php';
        </script>";
    }
    if (!isset($_SESSION["login"])){
        header("Location: 01_sbms_login.php");
        exit;
    }
    $userID = $_SESSION["userID"];
    $name = $_SESSION["fullName"];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Approval Page | Space Booking Management System</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Title</title>
    <link rel="stylesheet" href="style_spacemanager.css">
</head>

<body>
    <nav>
        <a href="#" class="left-nav">
            <h3>Daemon Tech <i class="icon">SBMS</i></h3>
        </a>
        <div class="right-nav">
            <?php 
                if ($_SESSION["level"] == "ADMIN") {
                    ?>
            <a class="login" href="04_sbms_admin.php">Admin Menu</a>
            <?php } else {?>
            <a class="login" href="edit_profile.php?id=<?= $userID ?>"><?= $name ?></a>
            <?php } ?>
            <a class="login" href="report.php">Booking Report</a>
            <a class="login" href="logout.php">Logout</a>
        </div>
    </nav>
    <div id="box">
        <h2>
            Pending Approval
        </h2>
        <sub>
            <br>
            <br>
            <div class="Pending_Approval">
                <form action="" method="POST">
                    <table>
                        <?php 
                        $select = mysqli_query($connection, 
                        "SELECT b.*, u.fullName, r.description, d.period FROM booking AS b 
                        JOIN user AS u ON b.identificationNo = u.userID 
                        JOIN room AS r ON b.roomType = r.roomID
                        JOIN duration AS d ON b.duration = d.durationID 
                        WHERE status = 'WAITING'");
                        if (mysqli_num_rows($select)>0) {
                            while ($data = mysqli_fetch_array($select)) {
                        ?>
                        <tr>
                            <td><b>Date submitted</b></td>
                            <td colspan="2">
                                <p><span id="datetime"><?= $data['date_submitted']?></span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Details</b>
                            </td>
                            <td>
                                Matric Number<br>
                                Name<br>
                                Check-In date<br>
                                Check-In time<br>
                                Duration<br>
                                Room Type
                            </td>
                            <td>
                                : <?= $data['identificationNo']?><br>
                                : <?= $data['fullName']?><br>
                                : <?= $data['checkinDate']?><br>
                                : <?= $data['checkinTime']?><br>
                                : <?= $data['period']?><br>
                                : <?= $data['description']?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="Pending_button">
                                    <center>
                                        <a class="Approve_Booking" href="approveBooking.php?id=<?= $data['bookingID']?>" onclick="return confirm('Confirm approval');">Approve</a>
                                        &nbsp;
                                        <a class="Reject_Booking" href="rejectBooking.php?id=<?= $data['bookingID']?>" onclick="return confirm('Confirm rejection');">Reject</a>
                                    </center>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            }
                        }
                        ?>
                    </table>
                </form>
            </div>
        </sub>
    </div>
</body>

</html>

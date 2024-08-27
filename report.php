<?php
session_start();
include ('connection.php'); 
if (!isset($_COOKIE['id']) && !isset($_COOKIE['pass'])) {
    echo "<script>alert('Cookie Timeout!');
    window.location='logout.php';
    </script>";
}
$idSelect = $_SESSION["userID"];
$name = $_SESSION['fullName'];
if (!isset($_SESSION["login"])){
    header("Location: 01_sbms_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Booking Report | Space Booking Management System</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_admin.css">
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
            <?php 
                } else if($_SESSION["level"] == "LECTURER") {
            ?>
            <a class="login" href="edit_profile.php?id=<?= $idSelect ?>"><?= $name ?></a>
            <a class="login" href="02_sbms_lecturer.php">Lecturer Menu</a>
            <?php 
                } else if($_SESSION["level"] == "SPACEMANAGER") {
            ?>
            <a class="login" href="edit_profile.php?id=<?= $idSelect ?>"><?= $name ?></a>
            <a class="login" href="03_sbms_spacemanager.php">Space Manager Menu</a>
            <?php } ?>
            <a class="login" href="logout.php">Logout</a>
        </div>
    </nav>

    <div id="box">

    <h2>Booking Report</h2>
      <table border="1">
            <tr>
                  <td colspan="6">
                        <form method="post">
                              <input type="text" name="searchKey" placeholder="Enter Search Term" style="margin-left: 6px; border-radius: 0.6em; border-color: white;">
                                  <select name="colChoice" id="" autocomplete="on">
                                      <option value="checkinDate">Check-in Date</option>
                                      <option value="checkinTime">Check-in Time</option>
                                      <option value="d.period">Duration</option>
                                      <option value="r.description">Room Type</option>
                                      <option value="status">Status</option>
                                  </select>
                              <input type="submit" name="search" value="Search">
                        </form>
                  </td>
            </tr>
            <tr>
                  <th>Identification No</th>
                  <th>Check-in Date</th>
                  <th>Check-in Time</th>
                  <th>Duration</th>
                  <th>Room Type</th>
                  <th>Status</th>
            </tr>
            <?php
            if ($_SESSION['level'] == "LECTURER") {
                  if (isset($_POST['search'])) {
                    $choice = $_POST['colChoice'];
                    $term = $_POST['searchKey'];
                    $select = "SELECT b.*, r.description, d.period FROM booking AS b 
                    JOIN room AS r ON b.roomType = r.roomID 
                    JOIN duration AS d ON b.duration = d.durationID 
                    WHERE identificationNo = '$idSelect'
                    AND $choice LIKE '%$term%'
                    ORDER BY b.roomType ASC, b.checkinDate ASC, b.checkinTime ASC";
                  }
                  else
                  $select = "SELECT b.*, r.description, d.period FROM booking AS b 
                  JOIN room AS r ON b.roomType = r.roomID 
                  JOIN duration AS d ON b.duration = d.durationID 
                  WHERE identificationNo = '$idSelect'
                  ORDER BY b.roomType ASC, b.checkinDate ASC, b.checkinTime ASC";
            }
            else {
                 if (isset($_POST['search'])) {
                    $choice = $_POST['colChoice'];
                    $term = $_POST['searchKey'];
                    $select = "SELECT b.*, r.description, d.period FROM booking AS b 
                    JOIN room AS r ON b.roomType = r.roomID 
                    JOIN duration AS d ON b.duration = d.durationID 
                    WHERE $choice LIKE '%$term%'
                    ORDER BY b.roomType ASC, b.checkinDate ASC, b.checkinTime ASC";
                 }
                 else
                 {
                    $select = "SELECT b.*, r.description, d.period FROM booking AS b 
                    JOIN room AS r ON b.roomType = r.roomID 
                    JOIN duration AS d ON b.duration = d.durationID 
                    ORDER BY b.roomType ASC, b.checkinDate ASC, b.checkinTime ASC";
                 }
            }
            $query = mysqli_query($connection, $select);
            if (mysqli_num_rows($query)>0) {
                  while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr>
                  <td><?= $data['identificationNo'] ?></td>
                  <td><?= $data['checkinDate'] ?></td>
                  <td><?= $data['checkinTime'] ?></td>
                  <td><?= $data['period'] ?></td>
                  <td><?= $data['description'] ?></td>
                  <td><?= $data['status'] ?></td>
            </tr>
            <?php
                  }
            }
            else
            {
            ?>
            <tr>
                <td colspan="6" style="text-align: center;">No data found</td>
            </tr>
            <?php
            }
            ?>
            <tr>
                  <td colspan="6" style="text-align: center;">
                        <button onclick="history.back()">Go Back</button>
                  </td>
            </tr>
      </table>
    </div>
</body>
</html>
<?php
session_start();
include 'connection.php';
if (!isset($_COOKIE['id']) && !isset($_COOKIE['pass'])) {
    echo "<script>alert('Cookie Timeout!');
    window.location='logout.php';
    </script>";
}
if (!isset($_SESSION["login"])){
      header("Location: 01_sbms_login.php");
      exit;
  }
$editID = $_GET['id'];
$data_edit = mysqli_query($connection, "SELECT * FROM user WHERE userID='$editID'");
$search = mysqli_fetch_array($data_edit);

if (isset($_POST['editUser'])) {
    $editID = $_GET['id'];
    $userID = $_POST['username'];
    $pass = $_POST['pass'];
    $fullName = $_POST['fullName'];
    $userLevel = $search['userLevel'];
    $_SESSION["fullName"] = $fullName;

    $update = mysqli_query($connection, "UPDATE user SET userID='$userID', pass='$pass',fullName='$fullName',userLevel='$userLevel' WHERE userID='$editID'");

    if ($update) {
      if ($_SESSION["level"] === 'LECTURER') {
      echo '<script>alert("Edit Profile Successful!");
      window.location="02_sbms_lecturer.php";</script>';
      } else if ($_SESSION["level"] === 'LECTURER') {
      echo '<script>alert("Edit Profile Successful!");
      window.location="03_sbms_spacemanager.php";</script>';
      }
    } else {
      if ($_SESSION["level"] === 'ADMIN') {
            echo '<script>alert("Edit Profile Unsuccessful!");
            window.location="02_sbms_lecturer.php";</script>'. mysqli_error($connection);
      } else if ($_SESSION["level"] === 'SPACEMANAGER') {
            echo '<script>alert("Edit Profile Unsuccessful!");
            window.location="03_sbms_spacemanager.php";</script>'. mysqli_error($connection);
      }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Space Booking Management System</title>
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
            <a class="login" href="02_sbms_lecturer.php">Lecturer Menu</a>
            <?php 
                } else if($_SESSION["level"] == "SPACEMANAGER") {
            ?>
            <a class="login" href="03_sbms_spacemanager.php">Space Manager Menu</a>
            <?php } ?>
            <a class="login" href="logout.php">Logout</a>
        </div>
    </nav>

    <div id="box">
        <h2>Edit Profile</h2>

        <form action="" method="POST">
            <table border="1">
                <tr>
                    <th colspan="2" style="text-align: center;">Edit Profile</th>
                    <input name="username" type="hidden" placeholder="Enter Identification ID" value="<?= $search['userID']; ?>" style="margin-left: 6px; border-radius: 0.6em; border-color: white;">
                </tr>
                <tr>
                    <td><b>Password</b></td>
                    <td><input name="pass" type="password" placeholder="Enter New Password" value="<?= $search['pass']; ?>" style="margin-left: 6px; border-radius: 0.6em; border-color: white;"></td>
                </tr>
                <tr>
                    <td><b>Full Name</b></td>
                    <td><input name="fullName" type="text" placeholder="Enter Full Name" value="<?= $search['fullName']; ?>" style="margin-left: 6px; border-radius: 0.6em; border-color: white;"></td>
                </tr>
                <tr>
                    <div class="form">
                        <td colspan="2" style="text-align:center;">
                            <input name="editUser" type="submit" value="Edit User Data" onclick="">
                        </td>
                    </div>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>
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
$editID = $_GET['userID'];
$data_edit = mysqli_query($connection, "SELECT * FROM user WHERE userID='$editID'");
$search = mysqli_fetch_array($data_edit);

if (isset($_POST['editUser'])) {
    $editID = $_GET['userID'];
    $userID = $_POST['username'];
    $pass = $_POST['pass'];
    $fullName = $_POST['fullName'];
    $userLevel = $_POST['userLevel'];

    $update = mysqli_query($connection, "UPDATE user SET userID='$userID', pass='$pass',fullName='$fullName',userLevel='$userLevel' WHERE userID='$editID'");

    if ($update) {
        echo '<script>alert("Edit User Successful!");
        window.location="04_sbms_admin.php";</script>';
    } else {
        echo '<script>alert("Edit User Unsuccessful!");
        window.location="04_sbms_admin.php";</script>'. mysqli_error($connection);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Data Editing | Space Booking Management System</title>
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
            <a class="login" href="04_sbms_admin.php">Admin Menu</a>
            <a class="login" href="logout.php">Logout</a>
        </div>
    </nav>

    <div id="box">
        <h2>Data Edit</h2>

        <form action="" method="POST">
            <table border="1">
                <tr>
                    <th colspan="2" style="text-align: center;">Edit User</th>
                </tr>
                <tr>
                    <td><b>ID</b></td>
                    <td><input name="username" type="text" placeholder="Enter Identification ID" value="<?= $search['userID']; ?>" style="margin-left: 6px; border-radius: 0.6em; border-color: white;"></td>
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
                    <td><b>User Level</b></td>
                    <td>
                        <select name="userLevel" style="margin-left: 6px; border-radius: 0.6em; border-color: darkgrey;">
                            <option value="LECTURER" <?php echo ($search['userLevel'] == 'LECTURER') ? 'selected' : ''; ?>>Lecturer</option>
                            <option value="SPACEMANAGER" <?php echo ($search['userLevel'] == 'SPACEMANAGER') ? 'selected' : ''; ?>>Space Manager</option>
                            <option value="ADMIN" <?php echo ($search['userLevel'] == 'ADMIN') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;">
                        <input name="editUser" type="submit" value="Edit User Data" onclick="">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>

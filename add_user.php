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
if (isset($_POST['addUser'])) {

    $userID = $_POST['userID'];
    $pass = $_POST['pass'];
    $fullName = $_POST['fullName'];
    $userLevel      = $_POST['userLevel'];

    $insert = mysqli_query($connection, "INSERT INTO user VALUES ('$userID','$pass','$fullName','$userLevel')");

    if ($insert) {
        echo '<script>alert("Add User Successful!");
        window.location="04_sbms_admin.php";</script>';
    } else {
        echo '<script>alert("Add User Unsuccessful!");
        window.location="04_sbms_admin.php";</script>'. mysqli_error($connection);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Adding | Space Booking Management System</title>
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
        <h2>Add New Data</h2>

        <form action="" method="POST">
            <table border="1">
                <tr>
                    <th colspan="2" style="text-align: center">Insert New User</th>
                </tr>

                <tr>
                    <td><b>ID</b></td>
                    <td><input name="userID" type="text" placeholder="Enter Identification ID" style="margin-left: 6px; border-radius: 0.6em; border-color: white;"></td>
                </tr>

                <tr>
                    <td><b>Password</b></td>
                    <td><input name="pass" type="password" placeholder="Enter Password" style="margin-left: 6px; border-radius: 0.6em; border-color: white;"></td>
                </tr>
                
                <tr>
                    <td><b>Full Name</b></td>
                    <td><input name="fullName" type="text" placeholder="Enter Full Name" style="margin-left: 6px; border-radius: 0.6em; border-color: white;"></td>
                </tr>
                
                <tr>
                    <td><b>User Level</b></td>
                    <td>
                        <select name="userLevel" style="margin-left: 6px; border-radius: 0.6em; border-color: darkgrey;">
                            <option value="LECTURER">Lecturer</option>
                            <option value="SPACEMANAGER">Space Manager</option>
                            <option value="ADMIN">Admin</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <div class="form">
                        <td colspan="2" style="text-align:center;">
                            <input type="submit" name="addUser" value="Add User Data" onclick="return confirm('Confirm Add User?');">
                        </td>
                    </div>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>

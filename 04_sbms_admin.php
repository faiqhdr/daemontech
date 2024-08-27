<?php
    session_start();
    include ('connection.php'); 
    $userID = $_SESSION["userID"];
    if (!isset($_COOKIE['id']) && !isset($_COOKIE['pass'])) {
        echo "<script>alert('Cookie Timeout!');
        window.location='logout.php';
        </script>";
    }
    if (!isset($_SESSION["login"])){
        header("Location: 01_sbms_login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Information | Space Booking Management System</title>
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
            <a class="login" href="02_sbms_lecturer.php">Lecturer View</a>
            <a class="login" href="03_sbms_spacemanager.php">Space Manager View</a>
            <a class="login" href="report.php?id=<?= $userID ?>">Booking Report</a>
            <a class="login" href="logout.php">Logout</a>
        </div>
    </nav>

    <div id="box">

        <h2>User Information</h2>


        <table border="1">
            <tr>
                <td colspan="5">
                    <form method="get">
                        <input type="text" name="searchKey" placeholder="Enter Search Term" style="margin-left: 6px; border-radius: 0.6em; border-color: white;">
                        <input type="submit" name="search" value="Search">
                    </form>
                </td>
            </tr>
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Full Name</th>
                <th>User Level</th>
                <th>Action</th>
            </tr>
            <?php
                if(isset($_GET['search']))
                {
                    $keyword = $_GET['searchKey'];
                    $select = "SELECT * FROM user WHERE userID LIKE '%$keyword%' OR fullName LIKE '%$keyword%' OR userLevel LIKE '%$keyword%' OR pass LIKE '%$keyword%'";
                }
                else
                {
                    $select = "SELECT * FROM user ORDER BY userID ASC";
                }
                $query = mysqli_query($connection, $select);
                if (mysqli_num_rows($query)>0) {
                    while ($data = mysqli_fetch_array($query)) {
                        if ($data['userLevel'] != 'ADMIN') {
                ?>
            <tr>
                <td><?= $data['userID'] ?></td>
                <td><?= $data['pass'] ?></td>
                <td><?= $data['fullName'] ?></td>
                <td style="text-align: center"><?= $data['userLevel'] ?></td>
                <td style="text-align: center">
                    <div class="modif"><a href="edit_user.php?userID=<?= $data['userID'] ?>" style="text-decoration: none">Edit</a>
                        <a href="delete_user.php?userID=<?= $data['userID'] ?>" style="text-decoration: none" onclick="return confirm('Delete this user?');"> Delete</a></div>
                </td>
            </tr>
            <?php
                        }
                    }
                }
                ?>
            <tr>
                <td colspan="5" style="text-align:center;">
                    <div class="modif">
                        <a href='add_user.php'>Add New User</a>
                    </div>
                </td>

            </tr>
        </table>
    </div>
</body>

</html>

<?php
    session_start();
    include ('connection.php'); 

    if (isset($_SESSION["login"])){
        if ($_SESSION['level'] == "LECTURER") {
            echo "<script>window.location = '02_sbms_lecturer.php';
            </script>";
        } 
        else if($_SESSION['level'] == "SPACEMANAGER") {
            echo "<script>window.location = '03_sbms_spacemanager.php';
            </script>";
        } 
        else if($_SESSION['level'] == "ADMIN") {
            echo "<script>window.location = '04_sbms_admin.php';
            </script>";
        }
		exit;
	}

    if (isset($_POST['login'])) {
		$user = $_POST['username'];
		$pass = $_POST['pass'];
		$exe = mysqli_query($connection,"SELECT * from user WHERE userID = '$user' AND pass='$pass'");
		if (mysqli_num_rows($exe) >= 1) {
			$data = mysqli_fetch_assoc($exe);
            $_SESSION["login"] = true;
			$_SESSION["userID"] = $data['userID'];
			$_SESSION["fullName"] = $data['fullName'];
			$_SESSION['level'] = $data['userLevel'];
            setcookie('id', $data['userID'], time()+300);
            setcookie('pass', $data['pass'], time()+300);
            if ($_SESSION['level'] == "LECTURER") {
                echo "<script>alert('Login Successful!');
			    window.location = '02_sbms_lecturer.php';
			    </script>";
            } 
            else if($_SESSION['level'] == "SPACEMANAGER") {
                echo "<script>alert('Login Successful!');
                window.location = '03_sbms_spacemanager.php';
                </script>";
            } 
            else if($_SESSION['level'] == "ADMIN") {
                echo "<script>alert('Login Successful!');
                window.location = '04_sbms_admin.php';
                </script>";
            }
		}else{
			echo "<script>alert('Username or Password Incorrect!');
			</script>";
		}
	}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Page | Space Booking Management System</title>
    <link rel="stylesheet" href="style_login.css">
</head>

<body>
    <nav>
        <a href="#" class="left-nav">
            <h3>Daemon Tech <i class="icon">SBMS</i></h3>
        </a>
    </nav>
    <div class="title">
        User Login
    </div>

    <body>

        <div id="box">
            <div class="avatar_container">
                <img src="https://www.apple.com/newsroom/images/live-action/wwdc/Apple_wwdc21_newsroom_homepage_tile_033021.jpg.news_app_ed.jpg" alt="Avatar" class="avatar" height="230px" width="230px">
            </div>

            <form method="post" action="">
                <div class="input-box">
                    <div>
                        <b>Username</b>
                        <input type="text" name="username" id="username" autocomplete="on" placeholder="Identification ID">
                    </div>
                    <div>
                        <b>Password</b>
                        <input type="password" name="pass" id="pass" autocomplete="on" placeholder="Password">
                    </div>
                    <div class="click">
                        <button type="submit" name="login">Login</button>
                    </div>
                </div>
            </form>

        </div>
    </body>
</html>

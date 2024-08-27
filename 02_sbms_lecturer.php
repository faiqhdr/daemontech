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
    
    if (isset($_POST['confirm'])) {
        $idno = $_SESSION["userID"];
        $name = $_SESSION["fullName"];
        $cdate = $_POST['cdate'];
        $ctime = $_POST['ctime'];
        $uduration = $_POST['uduration'];
        $rtype = $_POST['rtype'];
    
        $insert = mysqli_query($connection, "INSERT INTO booking(identificationNo,checkinDate,checkInTime,duration,roomType,date_submitted,status) VALUES ('$idno', '$cdate', '$ctime','$uduration','$rtype',current_timestamp(),'WAITING')");
    
        if ($insert) {
            switch ($uduration) {
                case "DURATION1":
                    $durationTime = "08.00 AM - 09.50 AM";
                    break;
                
                case "DURATION2":
                    $durationTime = "10.00 AM - 11.50 AM";
                    break;
                
                case "DURATION3":
                    $durationTime = "12.00 PM - 01.50 PM";
                    break;
                
                case "DURATION4":
                    $durationTime = "02.00 PM - 03.50 PM";
                    break;
                
                case "DURATION5":
                    $durationTime = "04.00 PM - 05.50 PM";
                    break;
                
                case "DURATION6":
                    $durationTime = "08.00 PM - 09.50 PM";
                    break;
                
                default:
                    $durationTime = "error";
                    break;
            }
            switch ($rtype) {
                case "TYPE1":
                    $roomType = "Lecture Hall";
                    break;
                
                case "TYPE2":
                    $roomType = "Examination Hall";
                    break;
                
                case "TYPE3":
                    $roomType = "Seminar Room";
                    break;
                
                case "TYPE4":
                    $roomType = "Interactive Learning";
                    break;
                
                case "TYPE5":
                    $roomType = "Laboratorium";
                    break;
                
                case "TYPE6":
                    $roomType = "Studio";
                    break;
                
                default:
                    $durationTime = "error";
                    break;
            }
            echo '<script>alert("Booking Request Successful!\nBooking Details:\nCheck-in Date: '.$cdate.'\nCheck-in Time: '.$ctime.'\nDuration     : '.$durationTime.'\nRoom Type    : '.$roomType.'")</script>';
        } else {
            echo '<script>alert("Booking Request Unsuccessful!")</script>' . mysqli_error($connection);
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Page | Space Booking Management System</title>
    <link rel="stylesheet" href="style_lecturer.css">
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
    <main>
        <div class="search">
            <div class="title">
                <h2>Online Booking</h2>
            </div>
            <form action="" method="post">
                <div class="input-search">
                    <div>
                        <p>Check-In Date</p>
                        <input type="date" name="cdate" id="" autocomplete="on">
                    </div>
                    <div>
                        <p>Check-In Time</p>
                        <input type="time" name="ctime" id="" autocomplete="on">
                    </div>
                    <div>
                        <p>Duration</p>
                        <select name="uduration" id="" autocomplete="on">
                            <option value="" class="empty">Choose room usage time</option>
                            <option value="DURATION1">08.00 AM - 09.50 AM</option>
                            <option value="DURATION2">10.00 AM - 11.50 AM</option>
                            <option value="DURATION3">12.00 PM - 01.50 PM</option>
                            <option value="DURATION4">02.00 PM - 03.50 PM</option>
                            <option value="DURATION5">04.00 PM - 05.50 PM</option>
                            <option value="DURATION6">08.00 PM - 09.50 PM</option>
                        </select>
                    </div>
                    <div>
                        <p>Room Type</p>
                        <select name="rtype" id="" autocomplete="on">
                            <option value="" class="empty">Choose room type</option>
                            <option value="TYPE1">Lecture Hall</option>
                            <option value="TYPE2">Examination Hall</option>
                            <option value="TYPE3">Seminar Room</option>
                            <option value="TYPE4">Interactive Learning Room</option>
                            <option value="TYPE5">Laboratium</option>
                            <option value="TYPE6">Studio</option>
                        </select>
                    </div>
                    <button class="hide-submit" type="submit" onclick="result()">
                        <i class="fas fa-equals"></i>
                    </button>
                </div>
                <button class="submit" type="submit" name = "confirm">
                    Confirm
                </button>
            </form>
        </div>
        <div class="room-type">
            <div class="title">
                <h2>Room Type</h2>
            </div>
            <div class="room-type-content">
                <div class="slideshow-container">
                    <div class="mySlides fade">
                        <img src="https://builtsurvey.utm.my/wp-content/uploads/2016/02/IMG_6657.jpg" width="500" height="300">
                        <div class="text">Lecture Hall</div>
                    </div>
                    <div class="mySlides fade">
                        <img src="https://people.utm.my/mohdfauziabu/files/2020/01/WhatsApp-Image-2020-01-06-at-09.44.26.jpeg" width="500" height="300">
                        <div class="text">Examination Hall</div>
                    </div>
                    <div class="mySlides fade">
                        <img src="https://builtsurvey.utm.my/wp-content/uploads/2016/02/IMG_6653.jpg" width="500" height="300">
                        <div class="text">Seminar Room</div>
                    </div>
                    <div class="mySlides fade">
                        <img src="https://news.utm.my/wp-content/uploads/2022/04/flexis-960x960-1.jpeg" width="500" height="300">
                        <div class="text">Interactive Learning Room</div>
                    </div>
                    <div class="mySlides fade">
                        <img src="https://engineering.utm.my/chemicalenergy/wp-content/uploads/sites/12/2014/02/20140217_124720.jpg" width="500" height="300">
                        <div class="text">Laboratorium</div>
                    </div>
                    <div class="mySlides fade">
                        <img src="https://builtsurvey.utm.my/wp-content/uploads/2016/02/359A3968.jpg" width="500" height="300">
                        <div class="text">Studio</div>
                    </div>
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>
                <br>
                <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    <span class="dot" onclick="currentSlide(4)"></span>
                    <span class="dot" onclick="currentSlide(5)"></span>
                    <span class="dot" onclick="currentSlide(6)"></span>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <h2>Our Profile</h2>
        <div>
            <a href="https://www.utm.my/edutourism/university-spaces/">Muhammad Arkan Al Rasyid | Muhammad Azzam Hamiludin | Muhammad Faiq Haidar | Muhammad Iqbal Habibie
            </a>
        </div>
        <hr>
        <h3>Copyright © 2022, Daemon Tech</h3>
    </footer>

    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }
    </script>
</body></html>

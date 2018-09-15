<?php
/* Displays user information and some useful messages */
session_start();

/* Database connection settings */
$host = 'localhost';
$user = 'root';
$pass = 'root';
$db = 'accounts';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your Clock-in page!";
  header("location: error.php");


}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
}
//$flag=mysqli_query($mysqli, "SELECT resetTimein FROM users where email = '$email'");


    $end 	= "now()"; // Current time and date

    mysqli_query($mysqli, "UPDATE users set timestampout = $end where email='$email'");
    mysqli_query($mysqli, "UPDATE users SET totalTime = addTime(totalTime, TIMEDIFF(timestampout, timestampin)) where email = '$email'");

    mysqli_query($mysqli, "UPDATE users set resetTimein = 'Y' where email='$email'");
    //mysqli_query($mysqli, "UPDATE users set timestampin = timestampout where email='$email'");

// $result = mysqli_query($mysqli, "select resetTimein from users where email='$email'");

//if ($result == 'N') {


//  mysqli_query($mysqli, "SELECT * FROM accounts.users");


// }
//else {
 // $_SESSION['message'] = "You must clock in before clockingout!";
  // header("location: logout.php");

// }

?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Welcome <?= $first_name.' '.$last_name ?></title>
  <?php include 'css/css.html'; ?>
</head>

<body>
  <div class="form">

          <h1>Welcome</h1>

          <p>
          <?php
          // set timezone
          date_default_timezone_set('America/Chicago');

          // display the date and time with a greeting
          function show_date(){
            return date('l, jS F H:i');
          }
          function greeting(){
            $hour = date('H');
            if($hour < 12){
              $greeting = "Good morning!";
            }
            else{
              $greeting = "Good day!";
            }
            return $greeting;
          }
          echo show_date();
          echo "<br/>" . greeting();

          //mysql_query("UPDATE accounts SET timestampin = '$ufname', umail = '$umail' WHERE id = '$_SESSION['userId']' ");
        //  $sql = "INSERT INTO users (first_name, last_name, email, password, hash) "
          //        . "VALUES ('$first_name','$last_name','$email','$password', '$hash')";


          //$totalHours = datetime_diff(timestampin, timestampout);
          //mysqli_query($mysqli, "UPDATE users set totalHours = '$totalHours' where id=6");// using id=6 for testing
        //  $timestampin = mysqli_query("SELECT timstampin FROM users WHERE id = 6");
          //$result1 = mysqli_fetch_array($timestampin);

          //$timestampout = mysqli_query("SELECT timestampout FROM users WHERE id = 6");
          //$result2 = mysqli_fetch_array($timestampout);
          ////////////
          //$start  = date_create();




        // / echo $result2;
        //  echo $result1;
          //echo $result2 - $result1;
          // Display message about account verification link only once
          if ( isset($_SESSION['message']) )
          {
              echo $_SESSION['message'];

              // Don't annoy the user with more messages upon page refresh
              unset( $_SESSION['message'] );
          }

          ?>
          </p>

          <?php


          ?>

          <h2><?php echo $first_name.' '.$last_name; ?></h2>
          <p><?= $email ?></p>


          <a href="logout.php"><button class="button button-block" name="logout"/>Log Out</button></a>

    </div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>

</body>
</html>

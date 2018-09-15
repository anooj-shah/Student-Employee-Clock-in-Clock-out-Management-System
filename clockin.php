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


$start = "now()";
$dateIn = "now()";  
mysqli_query($mysqli, "UPDATE users set timestampin = $start, resetTimein = 'N', dateIn = $dateIn where email = '$email'");



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
          ;

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

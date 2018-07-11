<?php session_start();

$flagerror = false;

if (isset($_POST['username'])) {

  $uname = $_POST["username"];
  $_SESSION['uname'] = $uname;
  $pass = $_POST["password"];

  include '../connection.php';

  $sql = "SELECT * FROM utenti WHERE username = '$uname' AND password = '$pass'";

  $results = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($results);
  $_SESSION['id_utente'] = $row['id'];

  if ($results->num_rows == 1){
    header('Location: ../main/main.php');
    return;
  }
  elseif ($results->num_rows == 0){
    $flagerror = true;
    $error = "<div class='err_box'>Ups, username o password sbagliati!</div>";
  }

  mysqli_close($conn);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,900" rel="stylesheet">
    <link href="../opensans/opensans.css" rel="stylesheet">
</head>
<body>
    <div class="container">
            <h1 style="margin-bottom: 10px;">login</h1>
            <form action="login.php" method="post">
                <div class="input_container">
                    <input class="login_field" type="text" placeholder="username" name="username" required>
                </div>
                <div class="input_container">
                    <input class="login_field" type="password" placeholder="password" name="password" required>
                </div>
                <div class="input_container">
                    <input class="login_button" type="submit" value="login">
                </div>
            </form>
            <?php

            if ($flagerror) {
              if ($results->num_rows == 0) echo $error;
            }

            ?>
            <a href="../index.html">indietro</a>
    </div>
</body>
</html>

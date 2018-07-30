<?php session_start();

$flagerror = false;

if (isset($_POST['username'])) {

  include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

  $uname = mysqli_real_escape_string($conn,$_POST["username"]);
  $_SESSION['uname'] = $uname;
  $pass = mysqli_real_escape_string($conn,$_POST["password"]);

  $sql = "SELECT * FROM utenti WHERE username = '$uname' AND password = '$pass'";

  $results = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($results);
  $_SESSION['id_utente'] = $row['id'];

  if ($results->num_rows == 1){
    header('Location: /libri/');
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
    <link rel="stylesheet" type="text/css" href="/style.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,900" rel="stylesheet">
    <link href="/opensans/opensans.css" rel="stylesheet">
</head>
<body>
    <div style="position: fixed; top:0; left:0; height: 100%; width: 100%; background-image: url(/imgs/sfondo.jpg); background-size: cover">
    <div class="container">

            <h1 style="margin-bottom: 10px;">accedi</h1>
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
            <img src="../imgs/donnina.svg" style="height: 200px; position: absolute;top:-130px;left;0">
            <?php

            if ($flagerror) {
              if ($results->num_rows == 0) echo $error;
            }
            ?>
            <a href="/index.html">indietro</a>
    </div>
    </div>
</body>
</html>

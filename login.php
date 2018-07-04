<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,900" rel="stylesheet">
</head>
<body>
    <div id="main_container" style="transform:translateX(0);">
        <div class="container">
            <div style="display: inline-block; text-align: left;">
                <h1>login</h1>
                <form action="login.php" method="post">
                  <input class="login_field" type="text" placeholder="username" name="username" required>
                  <input class="login_field" type="password" placeholder="password" name="password" required>
                  <input class="login_button" type="submit" value="login">
                </form>
                <?php

                $uname = $_POST["username"];
                $_SESSION['var'] = $uname;
                $_SESSION['log'] = 1;
                $pass = $_POST["password"];

                include 'connection.php';

                $sql = "SELECT * FROM utenti WHERE username = '$uname' AND password = '$pass'";

                $results = mysqli_query($conn, $sql);

                if ($results->num_rows == 1) {
                  echo "<script>window.open('main/main.php','_self');</script>";
                }elseif ($results->num_rows == 0){
                  $_SESSION['log'] = 0;
                  echo "<b style='color:red;'>Username o Password non corretti, riprova.</b><br>";
                }

                mysqli_close($conn);

                ?>
                <a onclick="scroll_to_center('main_container')">indietro</a>
            </div>
        </div>
        <div class="container">
            <div style="display: inline-block; text-align: left">
                <h1>Biblioteca</h1>
                <button class="login_button" style="width: 200px" onclick="scroll_to_left('main_container')">login</button>
                <button class="login_button" style="width: 200px" onclick="scroll_to_right('main_container')">registrati</button>
            </div>
        </div>
        <div class="container">
            <div style="display: inline-block; text-align: left">
                <h1>Registrazione</h1>
                <form action="registrazione.php" method="post">
                    <input class="login_field" type="text" placeholder="e-mail" name="email" required>
                    <input class="login_field" type="text" placeholder="username" name="username" required>
                    <input class="login_field" type="password" placeholder="password" name="password" required>
                    <input class="login_field" type="password" placeholder="conferma password" name="confpass" required>
                    <input class="login_button" type="submit" value="registrati">
                </form>
                <a onclick="scroll_to_center('main_container')">indietro</a>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

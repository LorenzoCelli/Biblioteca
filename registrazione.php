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
    <div id="main_container">
        <div class="container">
            <div style="display: inline-block; text-align: left;">
                <h1>login</h1>
                <form action="login.php" method="post">
                    <input class="login_field" type="text" placeholder="username" name="username" required>
                    <input class="login_field" type="password" placeholder="password" name="password" required>
                    <input class="login_button" type="submit" value="login">
                </form>
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
                <?php

                $_SESSION['log'] = 1;
                $uname = $_POST["username"];
                $email = $_POST["email"];
                $pass = $_POST["password"];

                include 'connection.php';

                $usercheck = mysqli_query($conn, "SELECT * FROM utenti WHERE username = '$uname'")->num_rows;
                $emailcheck = mysqli_query($conn, "SELECT * FROM utenti WHERE email = '$email'")->num_rows;
                if ($usercheck == 0 && $emailcheck == 0) {

                  $id = mysqli_query($conn, "SELECT * FROM utenti")->num_rows;
                  $_SESSION['id_utente'] = $id;
                  $sql = "INSERT INTO utenti
                  (id,username,email,password)
                  VALUES
                  ('$id','$uname','$email','$pass')";
                  $results = mysqli_query($conn, $sql);

                  if ($results) echo "<script>window.open('main/main.php','_self');</script>";
                  else echo "<b style='color:red;'>Qualcosa è andato storto, riprova.</b><br>";

                }else {
                  if ($usercheck != 0) echo "*username già in uso<br>";
                  if ($emailcheck != 0) echo "*email già in uso<br>";
                }

                mysqli_close($conn);

                ?>
                <a onclick="scroll_to_center('main_container')">indietro</a>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

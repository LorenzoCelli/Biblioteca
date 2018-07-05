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
            <div class="inner_login" style="display: inline-block; text-align: left;">
                <h1>login</h1>
                <form action="login.php" method="post">
                  <input class="login_field" type="text" placeholder="username" name="username" required>
                  <input class="login_field" type="password" placeholder="password" name="password" required>
                  <input class="login_button" type="submit" value="login">
                </form>
                <?php

                $uname = $_POST["username"];
                $pass = $_POST["password"];

                include 'connection.php';

                $sql = "SELECT * FROM utenti WHERE username = '$uname' AND password = '$pass'";

                $results = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($results);
                $_SESSION['id_utente'] = $row['id'];

                if ($results->num_rows == 1) echo "<script>window.open('main/main.php','_self');</script>";
                elseif ($results->num_rows == 0)echo "<b style='color:red;'>Username o password errati,<br> riprova.</b><br>";

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
            <div class="inner_register" style="display: inline-block; text-align: left">
                <h1>Registrazione</h1>
                <form action="registrazione.php" method="post">
                    <input class="login_field" type="email" placeholder="e-mail" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
                    <input class="login_field" type="text" placeholder="username" name="username" required>
                    <input style="margin-bottom:0;" class="login_field" type="password" placeholder="password" name="password" id="password_confirm" onkeyup="checkPassword();" required>
                    <input style="display:inline-block;margin-bottom:0;" class="login_field" type="password" placeholder="conferma password" name="confpass" id="password_confirm_check" onkeyup="checkPassword();" required>
                    <span id="message"></span>
                    <input class="login_button" type="submit" value="registrati" id="register_button">
                </form>
                <a onclick="scroll_to_center('main_container')">indietro</a>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

<?php session_start();
$uname = $_POST["username"];
$email = $_POST["email"];
$pass = $_POST["password"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Registrazione</h1>
        <form action="registrazione.php" method="post">
            <div class="input_container">
                <input id="email" value="<?php echo $email; ?>" class="login_field" type="email" placeholder="e-mail" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
                <div id="emailmsg" class="alert"><div class="point">!</div>Email già in uso!</div>
            </div>
            <div class="input_container">
                <input id="usr" value="<?php echo $uname; ?>" class="login_field" type="text" placeholder="username" name="username" required>
                <div id="usrmsg" class="alert"><div class="point">!</div>Username già in uso!</div>
            </div>
            <div class="input_container">
                <input class="login_field" type="password" placeholder="password" name="password" id="pass" onkeyup="check_pass()" required>
            </div>
            <div class="input_container">
                <input onfocus="first_focus=true;" class="login_field" type="password" placeholder="conferma password" name="confpass" id="pass_check" onkeyup="check_pass()" required>
                <div id="pass_alarm" class="alert"><div class="point">!</div>Le password non coincidono!</div>
            </div>
            <div class="input_container">
                <input class="login_button" type="submit" value="registrati" id="register_button">
            </div>
        </form>
        <script src="script.js"></script>

        <?php
        include '../connection.php';

        $usercheck = mysqli_query($conn, "SELECT * FROM utenti WHERE username = '$uname'")->num_rows;
        $emailcheck = mysqli_query($conn, "SELECT * FROM utenti WHERE email = '$email'")->num_rows;

        if ($usercheck == 0 && $emailcheck == 0) {

          $id = mysqli_query($conn, "SELECT * FROM utenti")->num_rows;
          $_SESSION['id_utente'] = $id;
          $sql = "INSERT INTO utenti
          (username,email,password)
          VALUES
          ('$uname','$email','$pass')";
          $results = mysqli_query($conn, $sql);

          if ($results) echo "<script>window.open(mainmain</script>";
          else echo "<b style='color:red;'>Qualcosa è andato storto, riprova.</b><br>";

        }else{
            echo '<script> var uname = "'.$uname.'" </script>';
            echo '<script> var email = "'.$email.'" </script>';
            if ($usercheck != 0){
                echo " <script> wrong_user(); </script> ";
            }
            if ($emailcheck != 0){
                echo " <script> wrong_email(); </script> ";
            }
        }

        mysqli_close($conn);
        ?>
        <a href="../index.html">indietro</a>
    </div>
</body>
</html>

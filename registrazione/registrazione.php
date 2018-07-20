<?php session_start();

$flagerror = false;
$flag = false;

if (isset($_POST['username'])) {

  include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

  $flag = true;
  $uname = mysqli_real_escape_string($conn,$_POST["username"]);
  $_SESSION['uname'] = $uname;
  $email = mysqli_real_escape_string($conn,$_POST["email"]);
  $pass = mysqli_real_escape_string($conn,$_POST["password"]);

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

    if ($results){
      header('Location: /libri/libri.php');
      return;
    }
    else{
      $flagerror = true;
      $error = "<b style='color:red;'>Qualcosa è andato storto, riprova.</b><br>";
    }

  }else{
      echo '<script> var uname = "'.$uname.'" </script>';
      echo '<script> var email = "'.$email.'" </script>';
  }

  mysqli_close($conn);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,900" rel="stylesheet">
    <link href="../opensans/opensans.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 style="margin-bottom: 10px;">Registrazione</h1>
        <form action="registrazione.php" method="post">
            <div class="input_container">
                <input id="email" <?php if($flag) echo "value='$email'"; ?> class="login_field" type="email" placeholder="e-mail" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
                <div id="emailmsg" class="alert"><div class="point">!</div>Email già in uso!</div>
            </div>
            <div class="input_container">
                <input id="usr" <?php if($flag) echo "value='$uname'"; ?> class="login_field" type="text" placeholder="username" name="username" required>
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
        if ($flag) {
          if ($flagerror) {
            if ($usercheck == 0 && $emailcheck == 0 && !$results) echo $error;
          }
          if ($usercheck != 0){
              echo "<script> wrong_user(); </script>";
          }
          if ($emailcheck != 0){
              echo "<script> wrong_email(); </script>";
          }
        }

        ?>
        <a href="/index.html">indietro</a>
    </div>
</body>
</html>

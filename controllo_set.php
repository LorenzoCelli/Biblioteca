<?php
if (!isset($_SESSION['uname'])) {
    header('Location: /login/login.php');
}
?>

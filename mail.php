<?php
$msg = "First line of text\nSecond line of text";

$msg = wordwrap($msg,70);

$headers = "From: webmaster@example.com";

mail("iltg407@gmail.com","My subject",$msg,$headers);
?>

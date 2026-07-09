<?php

$to = "nomiahamad@gmail.com";
$subject = "First Mail";
$msg = "hello noman";

$from = "nouman@htcjapan.jp";

// $header = "MIME-Version: 1.0" . "\r\n";
// $header .= "Content-type: text/html; charset=ISO-8859-1" . "\r\n";
$header = "From : $from";


    // echo $header;

$mail = mail($to,$subject,$msg,$header);

// echo $mail;

if ($mail) {

    echo 'Mail Sent';
    
}else{
    echo 'Mail Failed';
}

?>
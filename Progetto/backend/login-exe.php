<?php

$email = isset($_POST['email']) ? $_POST['email'] : '';

$psw = isset($_POST['psw']) ? $_POST['psw'] : '';


include_once("../common/setup.php");
include_once("../common/funzioni.php");

$ok = true;
$messages = array();

if ( !isset($email) || empty($email) ) {
    $ok = false;
    $messages[] = 'La mail non può essere vuota!';
}

if ( !isset($psw) || empty($psw) ) {
    $ok = false;
    $messages[] = 'La password non può essere vuota!';
}

if ($cid) {
  if($ok){
    $ok = isUser($cid,$email,$psw);
  	if ($ok){
  	  if (isset($_POST["remember"])){
  		   setcookie ("user",$email,time()+43200,"/");
  	   }elseif (isset($_COOKIE["user"])){
    		 unset($_COOKIE['user']);
    		 setcookie('user', null, -1, '/');
  	   }


  	  session_start();
  	  $_SESSION["utente"]=$email;
      $_SESSION["password"]=$psw;
  	  $_SESSION["logged"]=true;

      $ok = true;
      $messages[] = 'Login effettuato correttamente!';
  	}else {
      $ok = false;
      $messages[] = 'Password o email non corretti!';
    }
  }
}

echo json_encode(
    array(
        'ok' => $ok,
        'messages' => $messages,
    )
);


?>

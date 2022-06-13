<?php
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$cognome = isset($_POST['cognome']) ? $_POST['cognome'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$psw = isset($_POST['psw']) ? $_POST['psw'] : '';
$data = isset($_POST['data']) ? $_POST['data'] : '';
$dipartimento = isset($_POST['dipartimento']) ? $_POST['dipartimento'] : '';


include_once("../common/setup.php");
include_once("../common/funzioni.php");

$ok = true;
$messages = array();

if ( !isset($nome) || empty($nome) ) {
    $ok = false;
    $messages[] = 'Il nome non può essere vuoto!';
}

if ( !isset($cognome) || empty($cognome) ) {
    $ok = false;
    $messages[] = 'Il cognome non può essere vuoto!';
}

if ( !isset($email) || empty($email) ) {
    $ok = false;
    $messages[] = 'La mail non può essere vuota!';
}

if ( !isset($psw) || empty($psw) ) {
    $ok = false;
    $messages[] = 'La password non può essere vuota!';
}

if ( !isset($data) || empty($data) ) {
    $ok = false;
    $messages[] = 'La data non può essere vuota!';
}

if ( !isset($dipartimento) || empty($dipartimento) ) {
    $ok = false;
    $messages[] = 'Il dipartimento non puo essere vuoto!';
}elseif($dipartimento != 'Gestionale' || $dipartimento != 'Inscatolamento' || $dipartimento != 'Smistamento'){
	$ok = false;
    $messages[] = 'Il nome del dipartimento deve essere corretto! (Gestionale, Inscatolamento, Smistamento)';
}


if ($cid) {
  if($ok){
    $ok = isUserR($cid,$email);
  	if (!$ok){
  	  $res = registraUtente($cid,$nome,$cognome,$email,$psw,$data,$dipartimento);
  	}
    if ($res == true){
      $ok = true;
      $messages[] = 'Registrazione effettuata correttamente!';
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

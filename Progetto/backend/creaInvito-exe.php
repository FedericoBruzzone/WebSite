<?php
session_start();

include_once("../common/setup.php");
include_once("../common/funzioni.php");


	$email = isset($_GET['email']) ? $_GET['email'] : array();


	$ris2 = invitaUtenti($cid, $email ,$_GET["datainvito"],$_GET["data"],$_GET["orainizio"],$_GET["nomesalariunione"]);

	if ($ris2["status"]=='ok'){
		header("Location:../index.php?op=riunioniCreate&status=ok&msg=". urlencode($ris1["msg"] . $ris2["msg"]));
	}else{
		header("Location:../index.php?op=creaInvito&status=ko&data=". $_GET["data"] ."&orainizio=". $_GET["orainizio"] . "&nomesalariunione=". $_GET["nomesalariunione"]. "&msg=". urlencode($ris1["msg"] . $ris2["msg"]));
	}


?>

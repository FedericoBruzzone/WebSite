<?php
session_start();

include_once("../common/setup.php");
include_once("../common/funzioni.php");

$utente =  $_SESSION["utente"];


	$ris1 = rimuoviInvito($cid,$utente,$_GET["data"],$_GET["orainizio"],$_GET["nomesalariunione"]);


	if ($ris1["status"]=='ok'){
		header("Location:../index.php?op=invitiAccettati&status=ok&msg=". urlencode($ris1["msg"]));
	}else{
		header("Location:../index.php?op=invitiAccettati&status=ko&msg=". urlencode($ris1["msg"]));
	}

?>

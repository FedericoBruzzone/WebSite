<?php
session_start();

include_once("../common/setup.php");
include_once("../common/funzioni.php");


	$ris1= leggiRiunioni($cid);

	if ($ris1["status"]=='ok')
		$ris2 = scriviRiunione($cid,$ris1["contenuto"],$_GET["data"],$_GET["orainizio"],$_GET["nomesalariunione"],$_GET["durata"],$_GET["tema"]);



	if ($ris1["status"]=='ok' && $ris2["status"]=='ok'){
		header("Location:../index.php?op=creaInvito&data=". $_GET["data"] ."&orainizio=". $_GET["orainizio"] . "&nomesalariunione=". $_GET["nomesalariunione"] ."&status=ok&msg=". urlencode($ris1["msg"] . $ris2["msg"]));
	}else{
		header("Location:../index.php?status=ko&msg=". urlencode($ris1["msg"] . $ris2["msg"]));
	}

?>

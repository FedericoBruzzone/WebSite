<?php
session_start();

include_once("../common/setup.php");
include_once("../common/funzioni.php");



	
	$ris2 = aggiornaUtente($cid,$_GET["nome"],$_GET["cognome"],$_GET["email"],$_GET["password"]);



	if ($ris2["status"]=='ok'){
		header("Location:../index.php?op=profiloUtente&status=ok&msg=". urlencode($ris1["msg"] . $ris2["msg"]));
	}else{
		header("Location:../index.php?status=ko&msg=". urlencode($ris1["msg"] . $ris2["msg"]));
	}

?>

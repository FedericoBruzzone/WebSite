<?php
session_start();

include_once("../common/setup.php");
include_once("../common/funzioni.php");

	$ris1 = cancellaAutorizzato($cid,$_GET["email"],$_GET["emaildirettore"]);
	
	
	if ($ris1["status"]=='ok'){
		header("Location:../index.php?op=visualizzaAutorizzati&status=ok&msg=". urlencode($ris1["msg"]));
	}else{
		header("Location:../index.php?op=visualizzaAutorizzati&status=ko&msg=". urlencode($ris1["msg"]));
	}

?>
